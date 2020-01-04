<?php
namespace mstmvd\crud\Models;

use mstmvd\crud\Scopes\FilterScope;
use mstmvd\crud\Scopes\LimitOffsetScope;
use mstmvd\crud\Scopes\OrderScope;
use mstmvd\crud\Scopes\WithScope;
use Illuminate\Database\Eloquent\Model;
use mstmvd\crud\Traits\ModelTableNameTrait;

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
