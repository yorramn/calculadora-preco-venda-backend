<?php

namespace App\Repositories\Quotes;

use App\Models\Quote\Quote;

class QuoteRepository extends \App\Repositories\BaseRepository
{
    /**
     * @param array $quotes
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function createMany(array $quotes): \Illuminate\Database\Eloquent\Collection|array
    {
        Quote::query()->insert($quotes);
        return Quote::query()->get();
    }
}
