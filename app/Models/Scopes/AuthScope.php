<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AuthScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($model->getTable() != 'users' && $user) {
                $whereColumn = $model->getTable() . '.user_id';
                $builder->where($whereColumn, $user->id);
            }
        }
    }
}
