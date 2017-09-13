<?php namespace Arcanesoft\Blog\Tests\Unit\Models;

use Arcanesoft\Auth\Models\User;
use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Events\Posts\AbstractPostEvent;
use Arcanesoft\Blog\Events\Posts\PostCreated;
use Arcanesoft\Blog\Events\Posts\PostCreating;
use Arcanesoft\Blog\Events\Posts\PostSaved;
use Arcanesoft\Blog\Events\Posts\PostSaving;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
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

        $this->assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'fr',
            'content_raw'  => '# This is a **markdown** `content`',
            'content_html' => "<h1>This is a <strong>markdown</strong> <code>content</code></h1>",
        ]);

        $this->assertInstanceOf(\Arcanesoft\Auth\Models\User::class, $post->author);
        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $post->tags);

        $this->assertPostCreationEvents($post);

        // SEO Stuff
        $this->assertSame('http://localhost/dashboard/blog/posts/1/show', $post->getShowUrl());
        $this->assertSame('http://localhost/dashboard/blog/posts/1/edit', $post->getEditUrl());
    }

    /** @test */
    public function it_can_create_and_update_with_tags_and_seo_attributes()
    {
        // CREATE

        /** @var  \Illuminate\Database\Eloquent\Collection  $tags */
        $tags = factory(Tag::class, 5)->create();

        /** @var  \Arcanesoft\Blog\Models\Post  $post */
        $post = Post::createOne([
            'author_id'       => factory(Category::class)->create()->id,
            'category_id'     => factory(User::class)->create()->id,
            'locale'          => 'fr',
            'title'           => 'Culpa reprehenderit aut voluptatem voluptas quibusdam ratione nam.',
            'slug'            => 'Cumque exercitationem est eius alias omnis.',
            'excerpt'         => 'Labore harum tenetur voluptatibus ut. Eos temporibus quas sapiente sit neque. Odio hic dolorem saepe et aperiam ut. Cupiditate reiciendis ab porro et voluptatum.',
            'thumbnail'       => 'http://example.com/img/thumbnail.jpg',
            'content'         => '# This is a **markdown** `content`',
            'is_draft'        => false,
            'published_at'    => '2017-01-01 12:00:00',
            'tags'            => $tags->pluck('id')->toArray(),

            // SEO
            'seo_title'       => 'Culpa reprehenderit aut voluptatem voluptas quibusdam ratione nam.',
            'seo_description' => 'Labore harum tenetur voluptatibus ut. Eos temporibus quas sapiente sit neque.',
            'seo_keywords'    => ['keyword-1', 'keyword-2', 'keyword-3', 'keyword-4', 'keyword-5'],
        ]);

        $this->assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'fr',
            'content_raw'  => '# This is a **markdown** `content`',
            'content_html' => "<h1>This is a <strong>markdown</strong> <code>content</code></h1>",
        ]);

        $this->assertTrue($post->isDraft());
        $this->assertFalse($post->isPublished());
        $this->assertSame('draft', $post->status);
        $this->assertSame('Draft', $post->status_name);
        $this->assertTrue($post->hasThumbnail());

        $this->assertEquals(
            $tags->pluck('id')->toArray(),
            $post->tags->pluck('id')->toArray()
        );

        // UPDATE

        $post->updateOne([
            'status'    => PostStatus::STATUS_PUBLISHED,
            'tags'      => $tags->only([1, 2, 3])->pluck('id')->toArray(),
            'thumbnail' => null,

            // SEO
            'seo_title'       => 'Culpa reprehenderit aut voluptatem voluptas quibusdam ratione nam.',
            'seo_description' => 'Labore harum tenetur voluptatibus ut. Eos temporibus quas sapiente sit neque.',
            'seo_keywords'    => ['seo-keyword-1', 'seo-keyword-2', 'seo-keyword-3', 'seo-keyword-4'],
        ]);

        $this->assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'fr',
            'content_raw'  => '# This is a **markdown** `content`',
            'content_html' => "<h1>This is a <strong>markdown</strong> <code>content</code></h1>",
        ]);

        $this->assertFalse($post->isDraft());
        $this->assertTrue($post->isPublished());
        $this->assertSame('published', $post->status);
        $this->assertSame('Published', $post->status_name);
        $this->assertFalse($post->hasThumbnail());
    }

    /** @test */
    public function it_can_get_post_statuses()
    {
        $statuses = Post::getStatuses();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $statuses);
        $this->assertCount(2, $statuses);
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
            $this->assertEquals($expected, Post::getStatuses()->toArray());
        }
    }

    /** @test */
    public function it_can_get_localized_posts()
    {
        $postsPerLocale = 2;

        foreach ($locales = ['en', 'fr', 'es'] as $locale) {
            factory(Post::class, $postsPerLocale)->create(compact('locale'));
        }

        $this->assertSame(count($locales) * $postsPerLocale, Post::query()->count());

        foreach ($locales as $locale) {
            $this->assertSame($postsPerLocale, Post::localized($locale)->count());
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
        $this->assertPostEvents([
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
