<?php namespace Arcanesoft\Blog\Providers;

use Arcanedev\Support\Providers\CommandServiceProvider as ServiceProvider;

/**
 * Class     CommandServiceProvider
 *
 * @package  Arcanesoft\Blog\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommandServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerPublishCommand();
        $this->registerSetupCommand();

        $this->commands($this->commands);
    }

    /**
     * Get the provided commands.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanesoft.blog.commands.publish',
            'arcanesoft.blog.commands.setup',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Command Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the publish command.
     */
    private function registerPublishCommand()
    {
        $this->app->singleton(
            'arcanesoft.blog.commands.publish',
            \Arcanesoft\Blog\Console\PublishCommand::class
        );

        $this->commands[] = \Arcanesoft\Blog\Console\PublishCommand::class;
    }

    /**
     * Register the setup command.
     */
    private function registerSetupCommand()
    {
        $this->app->singleton(
            'arcanesoft.blog.commands.setup',
            \Arcanesoft\Blog\Console\SetupCommand::class
        );

        $this->commands[] = \Arcanesoft\Blog\Console\SetupCommand::class;
    }
}
