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
        'created_by',
        'views' // Ескі кодта көру саны бар еді
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'specifications' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'image_url',
        'short_description',
        'formatted_price',
        'in_stock',
        'stock_status'
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
        return $this->hasManyThrough(Order::class, OrderItem::class);
    }

    // Accessor - суреттің толық URL-ін алу (ескі кодқа сәйкес)
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-product.jpg');
        }

        // Егер сурет URL болса
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Егер сурет жергілікті файл болса - storage папкасынан
        if (Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        // Егер uploads папкасында болса (ескі кодқа сәйкес)
        if (file_exists(public_path('uploads/' . $this->image))) {
            return asset('uploads/' . $this->image);
        }

        return asset('images/default-product.jpg');
    }

    // Accessor - қысқаша сипаттама
    public function getShortDescriptionAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->description), 100);
    }

    // Accessor - пішімделген баға (ескі кодтағы сияқты)
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₸';
    }

    // Статус тексеру (ескі кодтағы сияқты)
    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock > 10) {
            return 'Қоймада бар';
        } elseif ($this->stock > 0) {
            return 'Аз қалды';
        } else {
            return 'Сатылымда жоқ';
        }
    }

    // Ескі кодтағы getProductImage функциясына сәйкес
    public function getProductImage($imagePath = null)
    {
        $image = $imagePath ?: $this->image;
        
        if (!$image) {
            return asset('images/default-product.jpg');
        }

        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        if (Storage::disk('public')->exists($image)) {
            return asset('storage/' . $image);
        }

        if (file_exists(public_path('uploads/' . $image))) {
            return asset('uploads/' . $image);
        }

        return asset('images/default-product.jpg');
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

    // Scope - іздеу бойынша (ескі кодтағы сияқты)
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%")
              ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                  $categoryQuery->where('name', 'like', "%{$searchTerm}%");
              });
        });
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

    // Өнімнің орташа рейтингі (ескі кодта 4.5 көрсетілген)
    public function getAverageRatingAttribute()
    {
        // Уақытша тіркелген мән - ескі кодта 4.5 көрсетілген
        return 4.5;
    }

    // Пікірлер саны (ескі кодта 128 көрсетілген)
    public function getReviewsCountAttribute()
    {
        // Уақытша тіркелген мән
        return 128;
    }

    // Ұқсас өнімдерді алу (ескі кодтағы сияқты)
    public function getRelatedProducts($limit = 4)
    {
        return self::where('category_id', $this->category_id)
                  ->where('id', '!=', $this->id)
                  ->where('stock', '>', 0)
                  ->limit($limit)
                  ->get();
    }

    // Көру санын арттыру (ескі кодтағы сияқты)
    public function incrementViews()
    {
        $this->increment('views');
        return $this;
    }

    // Өнімді себетке қосуға болады ма?
    public function getCanAddToCartAttribute()
    {
        return $this->in_stock && auth()->check();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (auth()->check()) {
                $product->created_by = auth()->id();
            }
        });

        static::deleting(function ($product) {
            // Өнім суретін жою
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($product->image);
            }
        });
    }
}