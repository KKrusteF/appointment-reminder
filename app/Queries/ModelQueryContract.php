<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModelQueryContract
{
    /**
     * Get all of records of a given model.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection;

    /**
     *  Get paginate of records of a given model
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated(): LengthAwarePaginator;
}
