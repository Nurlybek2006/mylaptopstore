<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessor - қысқаша сипаттама
    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 100);
    }

    // Accessor - өнімдер саны
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    // Accessor - белсенді өнімдер саны (қоры бар)
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->where('stock', '>', 0)->count();
    }

    // Accessor - слаг (URL үшін)
    public function getSlugAttribute()
    {
        return Str::slug($this->name);
    }

    // Әдіс - категорияны жоюға болады ма? (өнімдері жоқ болса)
    public function getCanDeleteAttribute()
    {
        return $this->products_count === 0;
    }

    // Әдіс - орташа баға
    public function getAveragePriceAttribute()
    {
        return $this->products()->avg('price');
    }

    // Әдіс - жалпы қор саны
    public function getTotalStockAttribute()
    {
        return $this->products()->sum('stock');
    }

    // Scope - өнімдері бар категориялар
    public function scopeHasProducts($query)
    {
        return $query->whereHas('products');
    }

    // Scope - белсенді өнімдері бар категориялар
    public function scopeHasActiveProducts($query)
    {
        return $query->whereHas('products', function($q) {
            $q->where('stock', '>', 0);
        });
    }

    // Scope - атауы бойынша іздеу
    public function scopeByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    // Әдіс - категория статистикасы
    public function getStatisticsAttribute()
    {
        return [
            'total_products' => $this->products_count,
            'active_products' => $this->active_products_count,
            'average_price' => $this->average_price,
            'total_stock' => $this->total_stock
        ];
    }

    // Әдіс - категорияны көшіру (болашақта өнімдерді басқа категорияға көшіру үшін)
    public function mergeInto($targetCategoryId)
    {
        $targetCategory = Category::find($targetCategoryId);
        
        if ($targetCategory) {
            // Барлық өнімдерді жаңа категорияға көшіру
            $this->products()->update(['category_id' => $targetCategoryId]);
            
            return true;
        }
        
        return false;
    }

    // Әдіс - категорияны жасау алдында тексеру
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            // Атау бос емес екенін тексеру
            if (empty($category->name)) {
                throw new \Exception('Категория атауы міндетті түрде толтырылуы керек');
            }
        });

        static::deleting(function ($category) {
            // Егер категорияда өнімдер болса, жоюға болмайды
            if ($category->products()->count() > 0) {
                throw new \Exception('Бұл категорияда өнімдер бар, сондықтан жойылмайды. Алдымен өнімдерді басқа категорияға көшіріңіз.');
            }
        });
    }

    // Әдіс - кестеде көрсету үшін пішімделген ақпарат
    public function getTableRowAttribute()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->short_description,
            'products_count' => $this->products_count,
            'active_products' => $this->active_products_count,
            'average_price' => $this->average_price ? number_format($this->average_price, 0, ',', ' ') . ' ₸' : '0 ₸',
            'created_at' => $this->created_at->format('d.m.Y H:i'),
            'can_delete' => $this->can_delete
        ];
    }
}