<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name', 
        'username',
        'email',
        'phone',
        'password',
        'avatar',
        'role',
        'email_verified',
        'last_login'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'email_verified' => 'boolean',
        ];
    }

    // Байланыстар
    public function products()
    {
        return $this->hasMany(Product::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function marketplaceProducts()
    {
        return $this->hasMany(MarketplaceProduct::class);
    }

    public function laptopRequests()
    {
        return $this->hasMany(LaptopRequest::class);
    }

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    // Accessor - толық аты
    public function getNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    // Accessor - рөл атауы
    public function getRoleNameAttribute()
    {
        $roles = [
            'admin' => 'Админ',
            'user' => 'Пайдаланушы',
            'moderator' => 'Модератор'
        ];

        return $roles[$this->role] ?? $this->role;
    }

    // Accessor - админ ба
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    // Accessor - пішімделген телефон
    public function getFormattedPhoneAttribute()
    {
        if (!$this->phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        if (strlen($phone) === 11) {
            return '+7 (' . substr($phone, 1, 3) . ') ' . substr($phone, 4, 3) . '-' . substr($phone, 7, 2) . '-' . substr($phone, 9, 2);
        }
        
        return $this->phone;
    }

    // Accessor - аватар URL
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        }
        
        // Әдепкі аватар - әрекеттің бас әріпі
        $name = $this->first_name ? $this->first_name[0] : ($this->username ? $this->username[0] : 'U');
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    // Scope - рөл бойынша
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Scope - админдер
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Scope - қарапайым пайдаланушылар
    public function scopeRegularUsers($query)
    {
        return $query->where('role', 'user');
    }

    // Scope - белсенді пайдаланушылар (соңғы 30 күнде кірген)
    public function scopeActive($query)
    {
        return $query->where('last_login', '>=', now()->subDays(30));
    }

    // Әдіс - рөлді тексеру
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Әдіс - админді тексеру
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Әдіс - соңғы кіруді жаңарту
    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }

    // Әдіс - тапсырыстар саны
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    // Әдіс - өнімдер саны
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    // Әдіс - белсенді себет элементтері саны
    public function getCartItemsCountAttribute()
    {
        return $this->cartItems()->count();
    }

    // Әдіс - жалпы тапсырыс сомасы
    public function getTotalOrderAmountAttribute()
    {
        return $this->orders()->sum('total_amount');
    }
}