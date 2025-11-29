<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'budget',
        'purpose',
        'specifications',
        'status'
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Accessor - пішімделген бюджет
    public function getFormattedBudgetAttribute()
    {
        return $this->budget ? number_format($this->budget, 0, ',', ' ') . ' ₸' : null;
    }

    // Accessor - статус атауы
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'new' => 'Жаңа',
            'processing' => 'Өңделуде',
            'completed' => 'Аяқталған'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Scope - статус бойынша
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}