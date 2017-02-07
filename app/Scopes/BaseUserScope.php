<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope as ScopeInterface;

class BaseUserScope implements ScopeInterface {

    protected $scope_filter;
    protected $scope_column;

    public function apply(Builder $builder, Model $model)
    {
        $builder->where($this->scope_column, $this->scope_filter);
    }

    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();

        foreach ( (array) $query->wheres as $key => $where) {
            if ($where['column'] == $this->scope_column) {
                unset($query->wheres[$key]);
            }
            $query->wheres = array_values($query->wheres);
        }
    }
}
