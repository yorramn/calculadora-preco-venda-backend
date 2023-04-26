<?php

namespace Database\Seeders;

use App\Enums\Plan\PlanType;
use App\Models\Plan\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::query()->create([
                    'name' => 'básico',
                    'description' => 'básico',
                    'price' => 70,
                    'type' => PlanType::MONTHLY,
                    'details' => [
                        'teste',
                        'teste',
                        'teste',
                        'teste',
                        'teste'
                    ]
                ]);
        Plan::query()->create([
                    'name' => 'básico',
                    'description' => 'básico',
                    'price' => 25,
                    'type' => PlanType::MONTHLY,
                    'details' => [
                        'teste',
                        'teste',
                        'teste',
                        'teste',
                        'teste'
                    ]
                ]);
        Plan::query()->create([
                    'name' => 'básico',
                    'description' => 'básico',
                    'price' => 45,
                    'type' => PlanType::MONTHLY,
                    'details' => [
                        'teste',
                        'teste',
                        'teste',
                        'teste',
                        'teste'
                    ]
                ]);
    }
}
