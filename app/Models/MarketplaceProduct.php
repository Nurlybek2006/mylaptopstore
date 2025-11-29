<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceProduct extends Model
{
    use HasFactory;

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
}