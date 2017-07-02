<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as ScopeInterface;

class GlobalQueryScope implements ScopeInterface
{

    protected $filter_key;
    protected $column_name;

    function __construct($filter_key, $column_name)
    {
        $this->filter_key = $filter_key;
        $this->column_name = $column_name;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where($this->column_name, $this->filter_key);
    }

    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();

        foreach ( (array) $query->wheres as $key => $where)
        {
            if ($where['column'] == $this->column_name)
            {
                unset($query->wheres[$key]);
            }
            $query->wheres = array_values($query->wheres);
        }
    }
}
