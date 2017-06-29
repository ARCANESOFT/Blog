<?php namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Contracts\Auth\Models\User;
use Arcanesoft\Core\Bases\Policy;

/**
 * Class     TagsPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TagsPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const PERMISSION_LIST   = 'blog.tags.list';
    const PERMISSION_SHOW   = 'blog.tags.show';
    const PERMISSION_CREATE = 'blog.tags.create';
    const PERMISSION_UPDATE = 'blog.tags.update';
    const PERMISSION_DELETE = 'blog.tags.delete';

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
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
        return $user->may(static::PERMISSION_LIST);
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
        return $user->may(static::PERMISSION_SHOW);
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
        return $user->may(static::PERMISSION_CREATE);
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
        return $user->may(static::PERMISSION_UPDATE);
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
        return $user->may(static::PERMISSION_UPDATE);
    }
}
