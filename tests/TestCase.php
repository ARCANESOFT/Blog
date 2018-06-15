<?php namespace Arcanesoft\Blog\Tests;

use Arcanesoft\Auth\AuthServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanesoft\Auth\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Arcanesoft\Auth\AuthServiceProvider::class,
            \Arcanesoft\Blog\BlogServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     */
    protected function getEnvironmentSetUp($app)
    {
        /** @var  \Illuminate\Contracts\Config\Repository  $config */
        $config = $app['config'];

        $config->set('database.default', 'testing');
        $config->set('arcanesoft.blog.database.connection', 'testing');
        $config->set('arcanesoft.auth.database.connection', 'testing');
        $config->set('laravel-auth.database.connection', 'testing');

        $config->set('auth.providers.users.model', \Arcanesoft\Auth\Models\User::class);
    }
}
