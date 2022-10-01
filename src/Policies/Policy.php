<?php

namespace Armincms\Papyrus\Policies;

use Armincms\Contract\Policies\Policy as ArminPolicy;
use Armincms\Contract\Policies\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

abstract class Policy extends ArminPolicy
{
    use SoftDeletes;

    /**
     * Determine whether the user can publish the page.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $admin
     * @return mixed
     */
    public function publish(Authenticatable $user, Model $model)
    {
    }

    /**
     * Determine whether the user can archive the page.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $admin
     * @return mixed
     */
    public function archive(Authenticatable $user, Model $model)
    {
    }
}
