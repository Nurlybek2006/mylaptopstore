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
        'product_id',
        'product_name',
        'user_id',
        'total_amount',
        'shipping_cost',
        'quantity',
        'status',
        'payment_method',
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

    // Accessor - статус атауы
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'Күтілуде',
            'processing' => 'Өңделуде',
            'completed' => 'Аяқталған',
            'cancelled' => 'Бас тартылған'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Scope - статус бойынша
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Өнімдер саны
    public function getItemsCountAttribute()
    {
        return $this->items->count();
    }
}