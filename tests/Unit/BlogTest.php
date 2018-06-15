<?php namespace Arcanesoft\Blog\Tests\Unit;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Tests\TestCase;

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
    public function it_can_be_instantiated()
    {
        $blog = Blog::instance();

        static::assertInstanceOf(Blog::class, $blog);
    }

    /** @test */
    public function it_can_check_if_translatable()
    {
        $blog = Blog::instance();

        static::assertFalse($blog->isTranslatable());
        static::assertFalse(Blog::isTranslatable());

        $this->app['config']->set('arcanesoft.blog.translatable.enabled', true);

        static::assertTrue($blog->isTranslatable());
        static::assertTrue(Blog::isTranslatable());
    }

    /** @test */
    public function it_can_check_if_media_manager_installed()
    {
        $this->assertFalse($this->blog->isMediaManagerInstalled());

        $this->app->register(\Arcanesoft\Media\MediaServiceProvider::class);

        $this->assertTrue($this->blog->isMediaManagerInstalled());
    }

    /** @test */
    public function it_can_check_if_seo_manager_installed()
    {
        $this->assertFalse($this->blog->isSeoManagerInstalled());

        $this->app->register(\Arcanesoft\Seo\SeoServiceProvider::class);

        $this->assertTrue($this->blog->isSeoManagerInstalled());
    }
}
