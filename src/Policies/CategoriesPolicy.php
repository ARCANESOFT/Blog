<?php namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Contracts\Auth\Models\User;
use Arcanesoft\Core\Bases\Policy;

/**
 * Class     CategoriesPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const PERMISSION_LIST   = 'blog.categories.list';
    const PERMISSION_SHOW   = 'blog.categories.show';
    const PERMISSION_CREATE = 'blog.categories.create';
    const PERMISSION_UPDATE = 'blog.categories.update';
    const PERMISSION_DELETE = 'blog.categories.delete';

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    /**
     * Allow to list all the categories.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function listPolicy(User $user)
    {
        return $user->may(static::PERMISSION_LIST);
    }

    /**
     * Allow to show a category details.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function showPolicy(User $user)
    {
        return $user->may(static::PERMISSION_SHOW);
    }

    /**
     * Allow to create a category.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function createPolicy(User $user)
    {
        return $user->may(static::PERMISSION_CREATE);
    }

    /**
     * Allow to update a category.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function updatePolicy(User $user)
    {
        return $user->may(static::PERMISSION_UPDATE);
    }

    /**
     * Allow to delete a category.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function deletePolicy(User $user)
    {
        return $user->may(static::PERMISSION_DELETE);
    }
}
