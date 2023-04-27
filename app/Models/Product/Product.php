<?php

namespace App\Models\Product;

use App\Enums\Product\ProductStatusEnum;
use App\Models\Category\Category;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['owner', 'category', 'images'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'status',
        'user_id',
    ];

    protected function slug () : Attribute
    {
        return Attribute::make(
            get : fn (string $string) => strtolower($string),
            set:  fn (string $value) => Str::slug($value, '-', 'pt-BR'),
        );
    }

    protected $casts = [
        'status' => ProductStatusEnum::class,
    ];


    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category() : BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
    }

    public function images() : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
