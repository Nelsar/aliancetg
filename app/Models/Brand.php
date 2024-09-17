<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    public static function boot(): void
    {
        parent::boot();

        static::creating(function($brand){
            $slug = Str::slug($brand->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $brand->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }
}
