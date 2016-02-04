<?php namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     PostsPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsPolicy
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
            'listPolicy'   => 'blog.posts.list',
            'showPolicy'   => 'blog.posts.show',
            'createPolicy' => 'blog.posts.create',
            'updatePolicy' => 'blog.posts.update',
            'deletePolicy' => 'blog.posts.delete',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Allow to list all the posts.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function listPolicy(User $user)
    {
        return $user->may('blog.posts.list');
    }

    /**
     * Allow to show a post details.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function showPolicy(User $user)
    {
        return $user->may('blog.posts.show');
    }

    /**
     * Allow to create a post.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function createPolicy(User $user)
    {
        return $user->may('blog.posts.create');
    }

    /**
     * Allow to update a post.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function updatePolicy(User $user)
    {
        return $user->may('blog.posts.update');
    }

    /**
     * Allow to delete a post.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function deletePolicy(User $user)
    {
        return $user->may('blog.posts.delete');
    }
}
