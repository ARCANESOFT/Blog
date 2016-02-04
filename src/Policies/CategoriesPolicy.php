<?php namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     CategoriesPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CategoriesPolicy
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters and Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the policies.
     *
     * @return array
     */
    public static function getPolicies()
    {
        return [
            'listPolicy'   => 'blog.categories.list',
            'showPolicy'   => 'blog.categories.show',
            'createPolicy' => 'blog.categories.create',
            'updatePolicy' => 'blog.categories.update',
            'deletePolicy' => 'blog.categories.delete',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies Functions
     | ------------------------------------------------------------------------------------------------
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
        return $user->may('blog.categories.list');
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
        return $user->may('blog.categories.show');
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
        return $user->may('blog.categories.create');
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
        return $user->may('blog.categories.update');
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
        return $user->may('blog.categories.delete');
    }
}
