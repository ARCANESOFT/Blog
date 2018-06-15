<?php namespace Arcanesoft\Blog\Tests\Unit\Models;

use Arcanesoft\Blog\Events\Posts\AbstractPostEvent;
use Arcanesoft\Blog\Events\Posts\PostCreated;
use Arcanesoft\Blog\Events\Posts\PostCreating;
use Arcanesoft\Blog\Events\Posts\PostSaved;
use Arcanesoft\Blog\Events\Posts\PostSaving;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Tests\TestCase;
use Illuminate\Support\Facades\Event;

/**
 * Class     PostTest
 *
 * @package  Arcanesoft\Blog\Tests\Unit\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Using model factories ?
 */
class PostTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);

        Event::fake();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_create()
    {
        /** @var  \Arcanesoft\Blog\Models\Post  $post */
        $post = factory(Post::class)->create();

        static::assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'fr',
            'content_raw'  => '# This is a **markdown** `content`',
            'content_html' => "<h1>This is a <strong>markdown</strong> <code>content</code></h1>",
        ]);

        static::assertInstanceOf(\Arcanesoft\Auth\Models\User::class, $post->author);
        static::assertInstanceOf(Category::class, $post->category);
        static::assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $post->tags);

        static::assertPostCreationEvents($post);

        // SEO Stuff
        static::assertSame('http://localhost/dashboard/blog/posts/1/show', $post->getShowUrl());
        static::assertSame('http://localhost/dashboard/blog/posts/1/edit', $post->getEditUrl());
    }

    /** @test */
    public function it_can_get_post_statuses()
    {
        $statuses = Post::getStatuses();

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $statuses);
        static::assertCount(2, $statuses);
    }

    /** @test */
    public function it_can_get_post_translated_statuses()
    {
        $expectations = [
            'en' => [
                'draft'     => 'Draft',
                'published' => 'Published',
            ],
            'fr' => [
                'draft'     => 'Brouillon',
                'published' => 'Publié',
            ],
        ];

        foreach ($expectations as $locale => $expected) {
            $this->app->setLocale($locale);
            static::assertEquals($expected, Post::getStatuses()->toArray());
        }
    }

    /** @test */
    public function it_can_get_localized_posts()
    {
        $postsPerLocale = 2;

        foreach ($locales = ['en', 'fr', 'es'] as $locale) {
            factory(Post::class, $postsPerLocale)->create(compact('locale'));
        }

        static::assertSame(count($locales) * $postsPerLocale, Post::query()->count());

        foreach ($locales as $locale) {
            static::assertSame($postsPerLocale, Post::localized($locale)->count());
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  \Arcanesoft\Blog\Models\Post  $post
     */
    protected function assertPostCreationEvents($post)
    {
        static::assertPostEvents([
            PostCreating::class, PostCreated::class, PostSaving::class, PostSaved::class
        ], function (AbstractPostEvent $e) use ($post) {
            return $e->post->id === $post->id;
        });
    }

    /**
     * @param  array          $events
     * @param  \Closure|null  $callback
     */
    protected function assertPostEvents(array $events, $callback = null)
    {
        foreach ($events as $event) {
            Event::assertDispatched($event, $callback);
        }
    }
}
