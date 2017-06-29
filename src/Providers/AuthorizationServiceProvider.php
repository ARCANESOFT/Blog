<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Blog\Policies\CategoriesPolicy;
use Arcanesoft\Blog\Policies\DashboardPolicy;
use Arcanesoft\Blog\Policies\PostsPolicy;
use Arcanesoft\Blog\Policies\TagsPolicy;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register any application authentication / authorization services.
     */
    public function boot()
    {
        parent::registerPolicies();

        $this->defineMany(DashboardPolicy::class, DashboardPolicy::policies());
        $this->defineMany(PostsPolicy::class, PostsPolicy::policies());
        $this->defineMany(CategoriesPolicy::class, CategoriesPolicy::policies());
        $this->defineMany(TagsPolicy::class, TagsPolicy::policies());
    }
}
