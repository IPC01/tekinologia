<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'excerpt', 'price',
        'discount_price', 'demo_url', 'category_id', 'author_id',
        'is_active', 'is_featured', 'tags', 'product_type', 'license',
        'version', 'requirements', 'compatibility', 'average_rating',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
  public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function coverImage()
    {
        return $this->hasOne(File::class)->where('type', 'cover_image');
    }

    public function additionalImages()
    {
        return $this->hasMany(File::class)->where('type', 'additional_image');
    }

    public function downloadFile()
    {
        return $this->hasOne(File::class)->where('type', 'download_file');
    }
       public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
