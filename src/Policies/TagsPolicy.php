<?php namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     TagsPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsPolicy
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
            'listPolicy'   => 'blog.tags.list',
            'showPolicy'   => 'blog.tags.show',
            'createPolicy' => 'blog.tags.create',
            'updatePolicy' => 'blog.tags.update',
            'deletePolicy' => 'blog.tags.delete',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Allow to list all the tags.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function listPolicy(User $user)
    {
        return $user->may('blog.tags.list');
    }

    /**
     * Allow to show a tag details.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function showPolicy(User $user)
    {
        return $user->may('blog.tags.show');
    }

    /**
     * Allow to create a tag.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function createPolicy(User $user)
    {
        return $user->may('blog.tags.create');
    }

    /**
     * Allow to update a tag.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function updatePolicy(User $user)
    {
        return $user->may('blog.tags.update');
    }

    /**
     * Allow to delete a tag.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function deletePolicy(User $user)
    {
        return $user->may('blog.tags.delete');
    }
}
