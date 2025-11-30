<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // ← БҰЛ ЖЕРҒЕ ҚОСУ КЕРЕК

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'short_description',
        'products_count',
        'active_products_count',
        'slug',
        'can_delete',
        'image_url',
        'formatted_average_price',
        'formatted_total_value'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Accessor - сурет URL
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-category.jpg');
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        if (file_exists(public_path('uploads/' . $this->image))) {
            return asset('uploads/' . $this->image);
        }

        return asset('images/default-category.jpg');
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

    // Әдіс - пішімделген орташа баға
    public function getFormattedAveragePriceAttribute()
    {
        $avgPrice = $this->average_price;
        return $avgPrice ? number_format($avgPrice, 0, ',', ' ') . ' ₸' : '0 ₸';
    }

    // Әдіс - жалпы қор саны
    public function getTotalStockAttribute()
    {
        return $this->products()->sum('stock');
    }

    // Әдіс - жалпы баға (DB қолдану керек)
    public function getTotalValueAttribute()
    {
        return $this->products()->sum(DB::raw('price * stock'));
    }

    // Әдіс - пішімделген жалпы баға
    public function getFormattedTotalValueAttribute()
    {
        return number_format($this->total_value, 0, ',', ' ') . ' ₸';
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

    // Scope - танымал категориялар (көп өнімді)
    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('products')
                    ->orderBy('products_count', 'desc')
                    ->limit($limit);
    }

    // Әдіс - категория статистикасы
    public function getStatisticsAttribute()
    {
        return [
            'total_products' => $this->products_count,
            'active_products' => $this->active_products_count,
            'average_price' => $this->formatted_average_price,
            'total_stock' => $this->total_stock,
            'total_value' => $this->formatted_total_value
        ];
    }

    // Әдіс - категорияны көшіру
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

    // Әдіс - кестеде көрсету үшін пішімделген ақпарат
    public function getTableRowAttribute()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->short_description,
            'products_count' => $this->products_count,
            'active_products' => $this->active_products_count,
            'average_price' => $this->formatted_average_price,
            'created_at' => $this->created_at->format('d.m.Y H:i'),
            'can_delete' => $this->can_delete
        ];
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

            // Бірдей атаумен категория бар ма тексеру
            $existingCategory = Category::where('name', $category->name)->first();
            if ($existingCategory) {
                throw new \Exception('Бұл атаумен категория бар');
            }
        });

        static::updating(function ($category) {
            // Ескі суретті жою
            if ($category->isDirty('image') && $category->getOriginal('image')) {
                $oldImage = $category->getOriginal('image');
                if (!filter_var($oldImage, FILTER_VALIDATE_URL)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
                }
            }
        });

        static::deleting(function ($category) {
            // Егер категорияда өнімдер болса, жоюға болмайды
            if ($category->products()->count() > 0) {
                throw new \Exception('Бұл категорияда өнімдер бар, сондықтан жойылмайды. Алдымен өнімдерді басқа категорияға көшіріңіз.');
            }

            // Категория суретін жою
            if ($category->image && !filter_var($category->image, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image);
            }
        });
    }
}