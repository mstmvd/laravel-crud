<?php
namespace mstmvd\crud\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WithScope implements Scope
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
        if (request()->query('with')) {
            $items = explode(',', request()->query('with'));
            foreach ($items as $item) {
                if (method_exists($model, $item)) {
                    $builder->with($item);
                }
            }
        }
    }
}
