<?php
namespace LaravelUtils\Crud\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Arr;

class PaginateScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (request()->query('paginate')) {
            $params = request()->query();
            Arr::forget($params, 'page');

            $usePaginate = (request()->has('paginate') && request()->input('paginate')) != false;

            if ($usePaginate) {
                $perPage = request()->has('per-page') ? request()->input('per-page') : null;
                $builder->paginate($perPage)->appends($params);
            }
        }
    }
}
