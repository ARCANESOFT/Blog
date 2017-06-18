<?php namespace Arcanesoft\Blog\Tests;

use Arcanesoft\Blog\Blog;

/**
 * Class     BlogTest
 *
 * @package  Arcanesoft\Blog\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BlogTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Blog\Blog */
    protected $blog;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp()
    {
        parent::setUp();

        $this->blog = new Blog;
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_check_if_media_manager_installed()
    {
        $this->assertFalse($this->blog->isMediaManagerInstalled());

        $this->app->register(\Arcanesoft\Media\MediaServiceProvider::class);

        $this->assertTrue($this->blog->isMediaManagerInstalled());
    }
}
