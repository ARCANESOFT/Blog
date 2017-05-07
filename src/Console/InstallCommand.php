<?php namespace Arcanesoft\Blog\Console;

use Arcanesoft\Blog\Seeds\DatabaseSeeder;

/**
 * Class     SetupCommand
 *
 * @package  Arcanesoft\Blog\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InstallCommand extends AbstractCommand
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Blog module.';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', ['--class' => DatabaseSeeder::class]);
    }
}
