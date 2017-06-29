<?php namespace Arcanesoft\Blog\Console;

use Arcanedev\Support\Bases\Command;
use Arcanesoft\Blog\BlogServiceProvider;

/**
 * Class     PublishCommand
 *
 * @package  Arcanesoft\Blog\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PublishCommand extends Command
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
    protected $signature   = 'blog:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish blog config, migrations and other stuff.';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--provider' => BlogServiceProvider::class]);
    }
}
