<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Blog\Policies;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register any application authentication / authorization services.
     */
    public function boot()
    {
        parent::registerPolicies();

        $this->registerPostsPolicies();
        $this->registerCategoriesPolicies();
        $this->registerTagsPolicies();
        $this->registerOtherPolicies();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register posts authorizations.
     */
    private function registerPostsPolicies()
    {
        $this->defineMany(
            Policies\PostsPolicy::class,
            Policies\PostsPolicy::getPolicies()
        );
    }

    /**
     * Register categories authorizations.
     */
    private function registerCategoriesPolicies()
    {
        $this->defineMany(
            Policies\CategoriesPolicy::class,
            Policies\CategoriesPolicy::getPolicies()
        );
    }

    /**
     * Register tags authorizations.
     */
    private function registerTagsPolicies()
    {
        $this->defineMany(
            Policies\TagsPolicy::class,
            Policies\TagsPolicy::getPolicies()
        );
    }

    /**
     * Register other authorizations for blog module.
     */
    private function registerOtherPolicies()
    {
        //
    }
}
