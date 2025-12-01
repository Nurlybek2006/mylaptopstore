<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'stripe_payment_id', 
        'stripe_session_id', // ← ЖАҢА: Stripe сессиясы үшін
        'product_id',
        'product_name',
        'user_id',
        'total_amount',
        'shipping_cost',
        'quantity',
        'status',
        'payment_method',
        'payment_status',    // ← ЖАҢА: Төлем статусы
        'shipping_address',
        'phone',
        'customer_email',
        'customer_name'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'formatted_total',
        'status_label',
        'payment_status_label',
        'items_count'
    ];

    // Байланыстар
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor - пішімделген жиынтық сома
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 0, ',', ' ') . ' ₸';
    }

    // Accessor - тапсырыс статус атауы
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Күтілуде',
            'processing' => 'Өңделуде',
            'completed' => 'Аяқталған',
            'cancelled' => 'Бас тартылған',
            'refunded' => 'Қайтарылған'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Accessor - төлем статус атауы
    public function getPaymentStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Төлем күтілуде',
            'paid' => 'Төленді',
            'failed' => 'Төлем сәтсіз',
            'cancelled' => 'Төлем бас тартылды',
            'refunded' => 'Қайтарылды'
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    // Accessor - толық мекенжай
    public function getFullAddressAttribute()
    {
        return $this->shipping_address . ($this->phone ? ' | Телефон: ' . $this->phone : '');
    }

    // Accessor - тапсырыс күні
    public function getOrderDateAttribute()
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    // Accessor - жеткізу құнымен жалпы сома
    public function getTotalWithShippingAttribute()
    {
        return $this->total_amount + $this->shipping_cost;
    }

    // Accessor - жеткізу құнымен пішімделген жалпы сома
    public function getFormattedTotalWithShippingAttribute()
    {
        return number_format($this->total_with_shipping, 0, ',', ' ') . ' ₸';
    }

    // Өнімдер саны
    public function getItemsCountAttribute()
    {
        return $this->items->count();
    }

    // Тапсырыс нөмірі
    public function getOrderNumberAttribute()
    {
        return '#' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    // Тапсырыстың сипаттамасы
    public function getDescriptionAttribute()
    {
        if ($this->product_name) {
            return $this->product_name . ' (x' . $this->quantity . ')';
        } elseif ($this->items_count > 0) {
            $itemNames = $this->items->map(function($item) {
                return $item->product->name . ' (x' . $item->quantity . ')';
            })->implode(', ');
            
            return $itemNames;
        }
        
        return 'Тапсырыс #' . $this->id;
    }

    // Статус бойынша түстер
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    // Төлем статусы бойынша түстер
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            'refunded' => 'info'
        ];

        return $colors[$this->payment_status] ?? 'secondary';
    }

    // Scope - статус бойынша
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope - төлем статусы бойынша
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    // Scope - пайдаланушының тапсырыстары
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope - белсенді тапсырыстар
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled', 'refunded']);
    }

    // Scope - соңғы тапсырыстар
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Scope - күні бойынша
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope - жыл бойынша
    public function scopeThisMonth($query)
    {
        return $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
    }

    // Әдіс - тапсырыс сәтті аяқталды ма?
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed' && $this->payment_status === 'paid';
    }

    // Әдіс - тапсырысты жоюға болады ма?
    public function getCanCancelAttribute()
    {
        return in_array($this->status, ['pending', 'processing']) && 
               $this->payment_status !== 'paid';
    }

    // Әдіс - тапсырысты растауға болады ма?
    public function getCanConfirmAttribute()
    {
        return $this->status === 'pending' && 
               in_array($this->payment_status, ['pending', 'paid']);
    }

    // Әдіс - жеткізу мәліметтері бар ма?
    public function getHasShippingInfoAttribute()
    {
        return !empty($this->shipping_address) || !empty($this->phone);
    }

    // Әдіс - Stripe арқылы төленді ма?
    public function getIsPaidWithStripeAttribute()
    {
        return $this->payment_method === 'stripe' && 
               !empty($this->stripe_payment_id);
    }

    // Әдіс - өнім атауы (кері сәйкестік)
    public function getProductNamesAttribute()
    {
        if ($this->product_name) {
            return [$this->product_name];
        }
        
        return $this->items->pluck('product.name')->toArray();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // Егер төлем әдісі Stripe болса, payment_status = pending
            if ($order->payment_method === 'stripe') {
                $order->payment_status = $order->payment_status ?? 'pending';
            }
        });

        static::updating(function ($order) {
            // Егер статус completed болса, payment_status = paid
            if ($order->isDirty('status') && $order->status === 'completed') {
                $order->payment_status = 'paid';
            }
            
            // Егер статус cancelled болса, payment_status = cancelled
            if ($order->isDirty('status') && $order->status === 'cancelled') {
                $order->payment_status = 'cancelled';
            }
        });
    }
}