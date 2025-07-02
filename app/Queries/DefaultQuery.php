<?php

namespace App\Queries;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;


abstract class DefaultQuery extends QueryBuilder implements ModelQueryContract
{
    public array $config = [];

    public function __construct(Builder $model, array $config = [])
    {
        parent::__construct($model);

        foreach ($config as $key => $value) {
            switch ($key) {
                case 'filters':
                    $this->allowedFilters(array_values($value));
                    break;
                case 'includes':
                    $this->allowedIncludes(array_values($value));
                    break;
                case 'sorts':
                    $this->allowedSorts(array_values($value));
                    break;
            }
            $this->config[$key] = array_keys($value);
        }
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        return $this->get();
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginated(): LengthAwarePaginator
    {
        $paginate = $this->paginate((int)request()->get('per_page', 100));
        $paginate->config = $this->config;
        return $paginate;
    }
}
