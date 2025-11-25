<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * (Các thuộc tính cho phép gán giá trị hàng loạt)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'role',         // QUAN TRỌNG: Để chức năng Thăng/Hạ cấp hoạt động
        'is_active',    // QUAN TRỌNG: Để chức năng Khóa tài khoản hoạt động
        'google_id',    // Dành cho chức năng đăng nhập Google (nếu có)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean', // Giúp Laravel hiểu is_active là true/false thay vì 1/0
    ];

    // ================= RELATIONSHIPS (QUAN HỆ) =================

    /**
     * Quan hệ 1-nhiều: Một User sở hữu nhiều Document.
     * Hàm này cần thiết cho Controller UserManagement để kiểm tra
     * xem User có bài đăng hay không trước khi xóa.
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }
}