<?php

namespace App\Models;

use App\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'category_id', 'status',
    ];

    protected function casts()
    {
        return [
            'status' => ProductStatus::class,
            'created_at' => 'datetime:D, d M Y',
            'updated_at' => 'datetime:D, d M Y',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
