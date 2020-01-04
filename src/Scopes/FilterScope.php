<?php
namespace mstmvd\crud\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FilterScope implements Scope
{

    private $operators = [
        'gt' => '>',
        'gte' => '>=',
        'eq' => '=',
        'neq' => '!=',
        'lt' => '<',
        'lte' => '<=',
    ];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        foreach (request()->query() as $item => $value) {
            @list($field, $operator) = explode('$', $item);
            if (!$operator) {
                $operator = 'eq';
            }
            if (in_array($field, $model->filterable)) {
                $builder->where($field, $this->operators[$operator], $value);
            }
        }
    }
}
