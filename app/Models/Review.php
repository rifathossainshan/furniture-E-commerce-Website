<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'customer_name',
        'rating',
        'comment',
        'status',
        'admin_reply',
        'reply_by',
        'replied_at',
        'review_date',
        'is_admin_added',
        'is_verified_reply',
    ];

    protected $casts = [
        'review_date' => 'datetime',
        'is_admin_added' => 'boolean',
        'is_verified_reply' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }
}
