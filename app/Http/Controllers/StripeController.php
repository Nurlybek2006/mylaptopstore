<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; // ← ЖАҢА
use Illuminate\Support\Facades\Log; // ← ЖАҢА

class StripeController extends Controller
{
    public function __construct()
    {
        // Stripe API кілтін орнату
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // Бір өнімді Stripe арқылы сатып алу
    public function checkout(Request $request)
    {
        $input = $request->json()->all();
        $productId = $input['product_id'] ?? null;
        $quantity = $input['quantity'] ?? 1;

        if (!$productId) {
            return response()->json(['error' => 'Тауар ID табылмады'], 400);
        }

        try {
            $product = Product::findOrFail($productId);
            
            // Пайдаланушы деректері
            $customerEmail = Auth::check() ? Auth::user()->email : 'customer@example.com';
            $customerName = Auth::check() ? Auth::user()->name : 'Сатып алушы';
            $userId = Auth::id();

            // Қорды тексеру
            if ($quantity > $product->stock) {
                return response()->json([
                    'error' => 'Қорда жеткілікті өнім жоқ. Қолжетімді саны: ' . $product->stock
                ], 400);
            }

            // Тапсырыс жасау
            $orderAmount = $product->price * $quantity;
            
            $orderData = [
                'user_id' => $userId,
                'total_amount' => $orderAmount,
                'status' => 'pending',
                'payment_method' => 'stripe',
                'customer_email' => $customerEmail,
                'customer_name' => $customerName,
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Егер payment_status бағаны бар болса, қосу
            if (Schema::hasColumn('orders', 'payment_status')) {
                $orderData['payment_status'] = 'pending';
            }

            $order = Order::create($orderData);

            // OrderItem қосу
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
                'name' => $product->name,
                'image' => $product->image
            ]);

            // Өнім суретін дайындау
            $imageUrl = $product->image_url;
            if (strpos($imageUrl, 'http') !== 0) {
                $imageUrl = asset($imageUrl);
            }

            // Stripe Checkout Session жасау
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'kzt',
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->short_description ?? '',
                            'images' => $imageUrl ? [$imageUrl] : [],
                        ],
                        'unit_amount' => $product->price * 100, // теңге → тиын
                    ],
                    'quantity' => $quantity,
                ]],
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                'cancel_url' => route('stripe.cancel') . '?order_id=' . $order->id,
                'customer_email' => $customerEmail,
                'metadata' => [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'customer_name' => $customerName,
                    'user_id' => $userId,
                    'cart_checkout' => false // ← бір өнім екенін белгілеу
                ]
            ]);

            // Order-ге session_id жазу
            $order->update(['stripe_session_id' => $session->id]);

            return response()->json([
                'id' => $session->id,
                'order_id' => $order->id,
                'success' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout қатесі: ' . $e->getMessage());
            return response()->json([
                'error' => 'Төлем сессиясын жасау сәтсіз: ' . $e->getMessage()
            ], 500);
        }
    }

    // Төлем сәтті
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $orderId = $request->get('order_id');

        if (!$sessionId || !$orderId) {
            return redirect()->route('products.index');
        }

        try {
            // Stripe сессиясын алу
            $session = Session::retrieve($sessionId);
            $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
            
            // Тапсырысты табу
            $order = Order::findOrFail($orderId);
            
            // Metadata алу
            $metadata = $session->metadata;
            $isCartCheckout = $metadata->cart_checkout ?? false;
            
            // Тапсырыс статусын жаңарту
            $updateData = [
                'status' => 'completed',
                'payment_status' => 'paid',
                'stripe_payment_id' => $paymentIntent->id,
                'stripe_session_id' => $sessionId
            ];
            
            $order->update($updateData);

            // Өнім қорын азайту
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            // Егер себеттен төлеу болса, себетті тазалау
            if ($isCartCheckout) {
                session()->forget('cart');
            }

            // Тапсырыс ақпаратын алу
            $orderDetails = $order->load(['items.product']);

            return view('stripe.success', [
                'order' => $orderDetails,
                'session' => $session
            ]);

        } catch (\Exception $e) {
            Log::error('Stripe success қатесі: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Төлемді растау кезінде қате орын алды');
        }
    }

    // Төлем бас тартылды
    public function cancel(Request $request)
    {
        $orderId = $request->get('order_id');

        if ($orderId) {
            $order = Order::find($orderId);
            
            if ($order && $order->status === 'pending') {
                $updateData = [
                    'status' => 'cancelled'
                ];
                
                // Егер payment_status бағаны бар болса
                if (Schema::hasColumn('orders', 'payment_status')) {
                    $updateData['payment_status'] = 'cancelled';
                }
                
                $order->update($updateData);
            }

            return view('stripe.cancel', ['order' => $order ?? null]);
        }

        return view('stripe.cancel');
    }

    // Stripe Webhook (қосымша)
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            return response()->json(['error' => 'Жарамсыз payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Жарамсыз имза'], 400);
        }

        // Оқиғаны өңдеу
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function handleCheckoutSessionCompleted($session)
    {
        $orderId = $session->metadata->order_id ?? null;
        $isCartCheckout = $session->metadata->cart_checkout ?? false;
        
        if ($orderId) {
            $order = Order::find($orderId);
            
            if ($order && $order->status === 'pending') {
                $updateData = [
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'stripe_payment_id' => $session->payment_intent,
                    'stripe_session_id' => $session->id
                ];
                
                $order->update($updateData);

                // Өнім қорын азайту
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }
                
                // Егер себеттен төлеу болса, себетті тазалау
                if ($isCartCheckout) {
                    session()->forget('cart');
                }
            }
        }
    }

    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Төлем сәтті аяқталған кезде
        Log::info('Төлем сәтті аяқталды: ' . $paymentIntent->id);
    }
}