<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:D, d M Y',
            'updated_at' => 'datetime:D, d M Y',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
