<?php namespace Arcanesoft\Blog\Tests\Unit\Models;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Events\Tags\AbstractTagEvent;
use Arcanesoft\Blog\Events\Tags\TagCreated;
use Arcanesoft\Blog\Events\Tags\TagCreating;
use Arcanesoft\Blog\Events\Tags\TagSaved;
use Arcanesoft\Blog\Events\Tags\TagSaving;
use Arcanesoft\Blog\Events\Tags\TagUpdated;
use Arcanesoft\Blog\Events\Tags\TagUpdating;
use Arcanesoft\Blog\Models\Tag;
use Arcanesoft\Blog\Tests\TestCase;
use Illuminate\Support\Facades\Event;

/**
 * Class     TagTest
 *
 * @package  Arcanesoft\Blog\Tests\Unit\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Using model factories ?
 */
class TagTest extends TestCase
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
    public function it_can_create_without_translations()
    {
        static::assertFalse(Blog::isTranslatable());

        $tag = Tag::createOne(['name' => 'Laravel']);

        static::assertTagCreationEvents($tag);

        static::assertDatabaseHas($tag->getTable(), [
            'name' => 'Laravel', 'slug' => 'laravel',
        ]);

        $tag = Tag::createOne(['name' => 'ARCANEDEV', 'slug' => 'Software Company']);

        static::assertDatabaseHas($tag->getTable(), [
            'name' => 'ARCANEDEV', 'slug' => 'software-company',
        ]);

        static::assertTagCreationEvents($tag);
    }

    /** @test */
    public function it_can_update_without_translations()
    {
        static::assertFalse(Blog::isTranslatable());

        $tag = Tag::createOne(['name' => 'Laravel']);

        static::assertTagCreationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        $tag->updateOne(['name' => 'Zonda']);

        static::assertTagModificationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => 'Zonda', 'slug' => 'laravel',
        ]);

        $tag->updateOne(['slug' => 'Zonda']);

        static::assertTagModificationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => 'Zonda', 'slug' => 'zonda',
        ]);
    }

    /** @test */
    public function it_can_create_with_translations()
    {
        $this->enableTranslations();

        $tag = Tag::createOne([
            'name' => ['en' => 'Tutorials', 'fr' => 'Tutoriaux']
        ]);

        static::assertTagCreationEvents($tag);

        static::assertDatabaseHas($tag->getTable(), [
            'name' => json_encode(['en' => 'Tutorials', 'fr' => 'Tutoriaux']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);

        $tag = Tag::createOne([
            'name' => ['en' => 'News', 'fr' => 'Actualités'],
            'slug' => ['en' => 'Our latest news', 'fr' => 'Nos dernières nouvelles'],
        ]);

        static::assertDatabaseHas($tag->getTable(), [
            'name' => json_encode(['en' => 'News', 'fr' => 'Actualités']),
            'slug' => json_encode(['en' => 'our-latest-news', 'fr' => 'nos-dernieres-nouvelles']),
        ]);

        static::assertTagCreationEvents($tag);
    }

    /** @test */
    public function it_can_update_with_translations()
    {
        $this->enableTranslations();

        static::assertTrue(Blog::isTranslatable());

        $tag = Tag::createOne([
            'name' => ['en' => 'Tutorials', 'fr' => 'Tutoriaux'],
        ]);

        static::assertTagCreationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => json_encode(['en' => 'Tutorials', 'fr' => 'Tutoriaux']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);

        $tag->updateOne([
            'name' => ['en' => 'Formation', 'fr' => 'Formations']
        ]);

        static::assertTagModificationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => json_encode(['en' => 'Formation', 'fr' => 'Formations']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);

        $tag->updateOne([
            'slug' => ['en' => 'tutorials', 'fr' => 'tutoriaux'],
        ]);

        static::assertTagModificationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => json_encode(['en' => 'Formation', 'fr' => 'Formations']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);
    }

    /** @test */
    public function it_can_get_data_for_select_input_without_translations()
    {
        static::assertFalse(Blog::isTranslatable());

        $categories = Tag::createMany([
            ['name' => 'News'],
            ['name' => 'Tutorials'],
            ['name' => 'Videos'],
        ]);

        static::assertCount(3, $categories);


        $selectData = Tag::getSelectData();

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $selectData);
        static::assertCount(3, $selectData);
        static::assertSame([
            1 => 'News',
            2 => 'Tutorials',
            3 => 'Videos',
        ], $selectData->toArray());
    }

    /** @test */
    public function it_can_add_posts()
    {
        $tag = Tag::createOne(['name' => 'Laravel']);

        static::assertTagCreationEvents($tag);
        static::assertDatabaseHas($tag->getTable(), [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        static::assertCount(0, $tag->posts);
        static::assertFalse($tag->hasPosts());
        static::assertTrue($tag->isDeletable());

        /** @var  \Arcanesoft\Blog\Models\Post  $post */
        $post = $tag->posts()->create([
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'en',
            'title'        => 'Learn how to zonda !',
            'slug'         => 'Learn how to zonda !',
            'excerpt'      => 'Learn how to zonda !',
            'thumbnail'    => 'https://i2.wp.com/wp.laravel-news.com/wp-content/uploads/2016/12/valet-2.0.jpg?resize=2200%2C1125',
            'content'      => '# Zonda FTW !',
            'published_at' => \Carbon\Carbon::now(),
        ]);

        $tag->load('posts');

        static::assertCount(1, $tag->posts);
        static::assertTrue($tag->hasPosts());
        static::assertFalse($tag->isDeletable());

        static::assertDatabaseHas($post->getTable(), [
            'author_id'    => 1,
            'category_id'  => 1,
            'locale'       => 'en',
            'title'        => 'Learn how to zonda !',
            'slug'         => 'learn-how-to-zonda',
            'excerpt'      => 'Learn how to zonda !',
            'thumbnail'    => 'https://i2.wp.com/wp.laravel-news.com/wp-content/uploads/2016/12/valet-2.0.jpg?resize=2200%2C1125',
            'content_raw'  => '# Zonda FTW !',
            'content_html' => '<h1>Zonda FTW !</h1>',
        ]);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    protected function assertTagCreationEvents(Tag $tag)
    {
        static::assertTagEvents([
            TagCreating::class, TagCreated::class, TagSaving::class, TagSaved::class
        ], function (AbstractTagEvent $e) use ($tag) {
            return $e->tag->id === $tag->id;
        });
    }

    protected function assertTagModificationEvents(Tag $tag)
    {
        static::assertTagEvents([
            TagUpdating::class, TagUpdated::class, TagSaving::class, TagSaved::class
        ], function (AbstractTagEvent $e) use ($tag) {
            return $e->tag->id === $tag->id;
        });
    }

    /**
     * @param  array          $events
     * @param  \Closure|null  $callback
     */
    protected function assertTagEvents(array $events, $callback = null)
    {
        foreach ($events as $event) {
            Event::assertDispatched($event, $callback);
        }
    }

    protected function enableTranslations()
    {
        $this->app['config']->set('arcanesoft.blog.translatable.enabled', true);

        static::assertTrue(Blog::isTranslatable());
    }
}
