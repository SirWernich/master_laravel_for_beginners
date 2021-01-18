<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Psr7\build_query;

class DeletedAdminScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Auth::check() => check if current user is authenticated
        // Auth::user() => gets the current user object
        if (Auth::check() && Auth::user()->is_admin) {
            // $builder->withTrashed();
            $builder->withoutGlobalScope('Illuminate\Database\Eloquent\SoftDeletingScope');
        }
    }
}

?>
