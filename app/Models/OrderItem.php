<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id', 
        'quantity',
        'price',
        'name', // ← ЖАҢА: өнім атауын сақтау
        'image' // ← ЖАҢА: өнім суретін сақтау
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    protected $appends = [
        'formatted_price',
        'total',
        'formatted_total',
        'product_image_url'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor - пішімделген баға
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₸';
    }

    // Accessor - жалпы сома (саны * бағасы)
    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    // Accessor - пішімделген жалпы сома
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 0, ',', ' ') . ' ₸';
    }

    // Accessor - өнім атауы (егер name болмаса, product-тан алу)
    public function getNameAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return $this->product ? $this->product->name : 'Өнім';
    }

    // Accessor - өнім суретінің URL
    public function getProductImageUrlAttribute()
    {
        if ($this->image) {
            // Егер image URL болса
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // Егер image жолы болса
            if (file_exists(public_path('uploads/' . $this->image))) {
                return asset('uploads/' . $this->image);
            }
            
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }
        
        // Өнімден алу
        if ($this->product && $this->product->image) {
            return $this->product->image_url;
        }
        
        return asset('images/default-product.jpg');
    }

    // Accessor - өнім сипаттамасы
    public function getProductDescriptionAttribute()
    {
        if ($this->product) {
            return $this->product->short_description;
        }
        
        return '';
    }

    // Accessor - өнім категориясы
    public function getProductCategoryAttribute()
    {
        if ($this->product && $this->product->category) {
            return $this->product->category->name;
        }
        
        return '';
    }

    // Әдіс - қоры бар ма?
    public function getHasStockAttribute()
    {
        if ($this->product) {
            return $this->product->stock >= $this->quantity;
        }
        
        return true;
    }

    // Әдіс - қор статусы
    public function getStockStatusAttribute()
    {
        if (!$this->product) {
            return 'Қолжетімді емес';
        }
        
        if ($this->product->stock <= 0) {
            return 'Сатылымда жоқ';
        } elseif ($this->product->stock < $this->quantity) {
            return 'Шекті қор (' . $this->product->stock . ' қалды)';
        } else {
            return 'Қолжетімді';
        }
    }

    // Әдіс - қор түсі
    public function getStockColorAttribute()
    {
        if (!$this->product) {
            return 'secondary';
        }
        
        if ($this->product->stock <= 0) {
            return 'danger';
        } elseif ($this->product->stock < $this->quantity) {
            return 'warning';
        } else {
            return 'success';
        }
    }

    // Әдіс - сілтеме (өнім бетіне)
    public function getProductUrlAttribute()
    {
        if ($this->product) {
            return route('products.show', $this->product_id);
        }
        
        return '#';
    }

    // Әдіс - өнім ID-сы
    public function getProductIdAttribute($value)
    {
        return $value ?: ($this->product ? $this->product->id : null);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            // Егер өнім байланысы болса, ақпаратты толтыру
            if ($item->product && empty($item->name)) {
                $item->name = $item->product->name;
                $item->image = $item->product->image;
            }
        });
    }
}