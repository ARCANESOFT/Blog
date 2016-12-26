<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Blog\Policies;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies();

        $this->registerPostsPolicies($gate);
        $this->registerCategoriesPolicies($gate);
        $this->registerTagsPolicies($gate);
        $this->registerOtherPolicies($gate);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register posts authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerPostsPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\PostsPolicy::class,
            Policies\PostsPolicy::getPolicies()
        );
    }

    /**
     * Register categories authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerCategoriesPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\CategoriesPolicy::class,
            Policies\CategoriesPolicy::getPolicies()
        );
    }

    /**
     * Register tags authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerTagsPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\TagsPolicy::class,
            Policies\TagsPolicy::getPolicies()
        );
    }

    /**
     * Register other authorizations for blog module.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerOtherPolicies(GateContract $gate)
    {
        //
    }
}
