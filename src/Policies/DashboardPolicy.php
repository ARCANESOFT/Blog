<?php namespace Arcanesoft\Blog\Policies;

use Arcanesoft\Contracts\Auth\Models\User;
use Arcanesoft\Core\Bases\Policy;

/**
 * Class     DashboardPolicy
 *
 * @package  Arcanesoft\Blog\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const PERMISSION_STATS = 'blog.dashboard.stats';

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    /**
     * Allow to list all the statistics.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function statsPolicy(User $user)
    {
        return $user->may(static::PERMISSION_STATS);
    }
}
