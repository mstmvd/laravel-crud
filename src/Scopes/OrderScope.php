<?php
namespace mstmvd\crud\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class   OrderScope implements Scope
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
        if (request()->query('order-by')) {
            $items = explode(',', request()->query('order-by'));
            foreach ($items as $item) {
                @list($field, $direction) = explode(':', $item);
                if (!$direction) {
                    $direction = 'asc';
                }
                if (in_array($field, $model->sortable)) {
                    $builder->orderBy($field, $direction);
                }
            }
        } else {
            $builder->orderBy('id', 'desc');
        }
    }
}
