<?php namespace Arcanesoft\Blog\Tests\Unit\Models;

use Arcanesoft\Auth\Models\User;
use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Models\Post;
use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\Tests\TestCase;
use Arcanesoft\Seo\SeoServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Class     PostWithSeoTest
 *
 * @package  Arcanesoft\Blog\Tests\Unit\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostWithSeoTest extends TestCase
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

        $this->app->register(SeoServiceProvider::class);

        $this->artisan('migrate', ['--database' => 'testing']);

        Event::fake();
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

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

        static::assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'fr',
            'content_raw'  => '# This is a **markdown** `content`',
            'content_html' => "<h1>This is a <strong>markdown</strong> <code>content</code></h1>",
        ]);

        static::assertTrue($post->isDraft());
        static::assertFalse($post->isPublished());
        static::assertSame('draft', $post->status);
        static::assertSame('Draft', $post->status_name);
        static::assertTrue($post->hasThumbnail());

        static::assertEquals(
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

        static::assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'fr',
            'content_raw'  => '# This is a **markdown** `content`',
            'content_html' => "<h1>This is a <strong>markdown</strong> <code>content</code></h1>",
        ]);

        static::assertFalse($post->isDraft());
        static::assertTrue($post->isPublished());
        static::assertSame('published', $post->status);
        static::assertSame('Published', $post->status_name);
        static::assertFalse($post->hasThumbnail());
    }
}
