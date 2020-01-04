<?php
namespace mstmvd\crud\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LimitOffsetScope implements Scope
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
        if (request()->query('limit')) {
            $builder->limit(request()->query('limit'));
        }
        if (request()->query('offset')) {
            $builder->offset(request()->query('offset'));
        }
    }
}
