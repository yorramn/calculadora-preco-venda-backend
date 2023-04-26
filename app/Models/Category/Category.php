<?php

namespace App\Models\Category;

use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['owner', 'children', 'parent'];

    protected $casts = [
      'deleted_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'parent_id'
    ];

    protected function slug () : Attribute
    {
        return Attribute::make(
            get : fn (string $string) => strtolower($string),
            set:  fn (string $value) => Str::slug($value, '-', 'pt-BR'),
        );
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(self::class, 'id', 'parent_id');
    }
}
