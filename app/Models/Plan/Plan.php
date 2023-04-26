<?php

namespace App\Models\Plan;

use App\Enums\Plan\PlanType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'details'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'type' => PlanType::class,
        'details' => 'array'
    ];

    public function users () : BelongsToMany {
        return $this->belongsToMany(User::class, 'users_plans', 'user_id', 'plan_id');
    }
}
