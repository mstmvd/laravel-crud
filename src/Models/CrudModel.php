<?php
namespace LaravelUtils\Crud\Models;

use LaravelUtils\Crud\Scopes\FilterScope;
use LaravelUtils\Crud\Scopes\LimitOffsetScope;
use LaravelUtils\Crud\Scopes\OrderScope;
use LaravelUtils\Crud\Scopes\WithScope;
use LaravelUtils\Crud\Traits\ModelTableNameTrait;
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
