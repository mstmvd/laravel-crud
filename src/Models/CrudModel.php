<?php
namespace LaravelTools\Crud\Models;

use LaravelTools\Crud\Scopes\FilterScope;
use LaravelTools\Crud\Scopes\LimitOffsetScope;
use LaravelTools\Crud\Scopes\OrderScope;
use LaravelTools\Crud\Scopes\WithScope;
use LaravelTools\Crud\Traits\ModelTableNameTrait;
use Illuminate\Database\Eloquent\Model;

abstract class CrudModel extends Model
{
    use ModelTableNameTrait;

    public $filterable = [];
    public $sortable = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new FilterScope);
        static::addGlobalScope(new OrderScope);
        static::addGlobalScope(new LimitOffsetScope());
        static::addGlobalScope(new WithScope());
    }
}
