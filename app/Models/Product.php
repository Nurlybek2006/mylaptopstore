<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'category_id', 
        'image', 
        'stock', 
        'specifications', 
        'created_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer', // Бұл жолды қосыңыз
        'specifications' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Байланыстар
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // creator - user байланысының синонимы
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Accessor - суреттің толық URL-ін алу
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-product.jpg');
        }

        // Егер сурет URL болса
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Егер сурет жергілікті файл болса
        return asset('storage/' . $this->image);
    }

    // Accessor - қысқаша сипаттама
    public function getShortDescriptionAttribute()
    {
        return \Illuminate\Support\Str::limit($this->description, 100);
    }

    // Accessor - пішімделген баға
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₸';
    }

    // Статус тексеру
    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getStockStatusAttribute()
    {
        return $this->stock > 0 ? 'Сатылымда' : 'Сатылымнан шығарылған';
    }

    // Scope - тек қолжетімді өнімдер
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    // Scope - категория бойынша
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Scope - баға диапазоны бойынша
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    // Өнімді жасаған пайдаланушы админ бе?
    public function getIsCreatedByAdminAttribute()
    {
        return $this->creator && $this->creator->role === 'admin';
    }

    // Өнімнің жалпы табысы (егер тапсырыстар болса)
    public function getTotalRevenueAttribute()
    {
        return $this->orders()->where('status', 'completed')->sum('total_amount');
    }

    // Өнімнің орташа рейтингі (келешекте рейтинг жүйесі қосылса)
    public function getAverageRatingAttribute()
    {
        // Келешекте рейтинг жүйесі үшін
        return 0;
    }
}