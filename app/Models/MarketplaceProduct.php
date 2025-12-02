<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // SoftDeletes қосу

class MarketplaceProduct extends Model
{
    use HasFactory, SoftDeletes; // SoftDeletes қосу

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'category',
        'brand',
        'condition',
        'images',
        'status',
        'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interests()
    {
        return $this->hasMany(MarketplaceInterest::class, 'product_id');
    }

    public function messages()
    {
        return $this->hasMany(MarketplaceMessage::class, 'product_id');
    }

    // Бірінші суретті алу үшін accessor
    public function getFirstImageAttribute()
    {
        $images = $this->images;
        if (!empty($images) && is_array($images) && count($images) > 0) {
            return $images[0];
        }
        return 'https://via.placeholder.com/400x300/1e3c72/ffffff?text=No+Image';
    }

    // Жағдайдың текстық атауын алу
    public function getConditionTextAttribute()
    {
        $conditions = [
            'new' => 'Жаңа',
            'used' => 'Қолданылған',
            'refurbished' => 'Жөнделген'
        ];
        return $conditions[$this->condition] ?? 'Белгісіз';
    }

    // Статустың текстық атауын алу
    public function getStatusTextAttribute()
    {
        $statuses = [
            'active' => 'Белсенді',
            'sold' => 'Сатылды',
            'inactive' => 'Белсенді емес'
        ];
        return $statuses[$this->status] ?? 'Белгісіз';
    }

    // Бағаны әдемі форматта алу
    public function getFormattedPriceAttribute()
    {
        return '₸' . number_format($this->price, 0, ',', ' ');
    }

    // Тауар белсенді ме екенін тексеру
    public function isActive()
    {
        return $this->status === 'active';
    }

    // Тауар пайдаланушыға тиесілі ме екенін тексеру
    public function belongsToUser($userId)
    {
        return $this->user_id == $userId;
    }
}