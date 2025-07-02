<?php

namespace App\Models\Traits;

trait QueryBuilderBindable
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?\Illuminate\Database\Eloquent\Model
    {

        $class = "App\\Queries\\" . class_basename($this->getModel()) . "Query";

        return (new $class)->where($field ?? $this->getRouteKeyName(), $value)->first();
    }
}
