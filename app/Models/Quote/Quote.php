<?php

namespace App\Models\Quote;

use App\Enums\Quotes\QuoteStatusEnum;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Quote extends Model
{
    use HasFactory;

    protected $with = ['owner', 'category', 'product'];

    protected $fillable = [
        'name',
        'total_fixed_costs',
        'total_variable_costs',
        'price_sale',
        'link',
        'status',
        'category_id',
        'product_id',
        'user_id'
    ];

    protected $casts = [
      'total_fixed_costs' => 'decimal:2',
      'total_variable_costs' => 'decimal:2',
      'price' => 'decimal:2',
      'status' => QuoteStatusEnum::class,
    ];

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
}
