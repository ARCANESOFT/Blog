<?php namespace Arcanesoft\Blog\Tests\Unit\Models;

use Arcanesoft\Blog\Blog;
use Arcanesoft\Blog\Events\Categories\AbstractCategoryEvent;
use Arcanesoft\Blog\Events\Categories\CategoryCreated;
use Arcanesoft\Blog\Events\Categories\CategoryCreating;
use Arcanesoft\Blog\Events\Categories\CategorySaved;
use Arcanesoft\Blog\Events\Categories\CategorySaving;
use Arcanesoft\Blog\Events\Categories\CategoryUpdated;
use Arcanesoft\Blog\Events\Categories\CategoryUpdating;
use Arcanesoft\Blog\Models\Category;
use Arcanesoft\Blog\Tests\TestCase;
use Illuminate\Support\Facades\Event;

/**
 * Class     CategoryTest
 *
 * @package  Arcanesoft\Blog\Tests\Unit\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Using model factories ?
 */
class CategoryTest extends TestCase
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

        $category = Category::createOne(['name' => 'Laravel']);

        static::assertCategoryCreationEvents($category);

        static::assertDatabaseHas($category->getTable(), [
            'name' => 'Laravel', 'slug' => 'laravel',
        ]);

        $category = Category::createOne(['name' => 'ARCANEDEV', 'slug' => 'Software Company']);

        static::assertDatabaseHas($category->getTable(), [
            'name' => 'ARCANEDEV', 'slug' => 'software-company',
        ]);

        static::assertCategoryCreationEvents($category);
    }

    /** @test */
    public function it_can_update_without_translations()
    {
        static::assertFalse(Blog::isTranslatable());

        $category = Category::createOne(['name' => 'Laravel']);

        static::assertCategoryCreationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        $category->updateOne(['name' => 'Zonda']);

        static::assertCategoryModificationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => 'Zonda', 'slug' => 'laravel',
        ]);

        $category->updateOne(['slug' => 'Zonda']);

        static::assertCategoryModificationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => 'Zonda', 'slug' => 'zonda',
        ]);
    }

    /** @test */
    public function it_can_create_with_translations()
    {
        $this->enableTranslations();

        $category = Category::createOne([
            'name' => ['en' => 'Tutorials', 'fr' => 'Tutoriaux']
        ]);

        static::assertCategoryCreationEvents($category);

        static::assertDatabaseHas($category->getTable(), [
            'name' => json_encode(['en' => 'Tutorials', 'fr' => 'Tutoriaux']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);

        $category = Category::createOne([
            'name' => ['en' => 'News', 'fr' => 'Actualités'],
            'slug' => ['en' => 'Our latest news', 'fr' => 'Nos dernières nouvelles'],
        ]);

        static::assertDatabaseHas($category->getTable(), [
            'name' => json_encode(['en' => 'News', 'fr' => 'Actualités']),
            'slug' => json_encode(['en' => 'our-latest-news', 'fr' => 'nos-dernieres-nouvelles']),
        ]);

        static::assertCategoryCreationEvents($category);
    }

    /** @test */
    public function it_can_update_with_translations()
    {
        $this->enableTranslations();

        static::assertTrue(Blog::isTranslatable());

        $category = Category::createOne([
            'name' => ['en' => 'Tutorials', 'fr' => 'Tutoriaux'],
        ]);

        static::assertCategoryCreationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => json_encode(['en' => 'Tutorials', 'fr' => 'Tutoriaux']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);

        $category->updateOne([
            'name' => ['en' => 'Formation', 'fr' => 'Formations']
        ]);

        static::assertCategoryModificationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => json_encode(['en' => 'Formation', 'fr' => 'Formations']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);

        $category->updateOne([
            'slug' => ['en' => 'tutorials', 'fr' => 'tutoriaux'],
        ]);

        static::assertCategoryModificationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => json_encode(['en' => 'Formation', 'fr' => 'Formations']),
            'slug' => json_encode(['en' => 'tutorials', 'fr' => 'tutoriaux']),
        ]);
    }

    /** @test */
    public function it_can_get_data_for_select_input_without_translations()
    {
        static::assertFalse(Blog::isTranslatable());

        $categories = Category::createMany([
            ['name' => 'News'],
            ['name' => 'Tutorials'],
            ['name' => 'Videos'],
        ]);

        static::assertCount(3, $categories);

        // Test with placeholder
        $selectData = Category::getSelectData();

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $selectData);
        static::assertCount(4, $selectData);
        static::assertSame([
            0 => '-- Select a category --',
            1 => 'News',
            2 => 'Tutorials',
            3 => 'Videos',
        ], $selectData->toArray());

        // Test without placeholder
        $selectData = Category::getSelectData(false);
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
        $category = Category::createOne(['name' => 'Laravel']);

        static::assertCategoryCreationEvents($category);
        static::assertDatabaseHas($category->getTable(), [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        static::assertCount(0, $category->posts);
        static::assertFalse($category->hasPosts());
        static::assertTrue($category->isDeletable());

        /** @var  \Arcanesoft\Blog\Models\Post  $post */
        $post = $category->posts()->create([
            'author_id'    => 1,
            'locale'       => 'en',
            'title'        => 'Learn how to zonda !',
            'slug'         => 'Learn how to zonda !',
            'excerpt'      => 'Learn how to zonda !',
            'thumbnail'    => 'https://i2.wp.com/wp.laravel-news.com/wp-content/uploads/2016/12/valet-2.0.jpg?resize=2200%2C1125',
            'content'      => '# Zonda FTW !',
            'published_at' => \Carbon\Carbon::now(),
        ]);

        $category->load('posts');

        static::assertCount(1, $category->posts);
        static::assertTrue($category->hasPosts());
        static::assertFalse($category->isDeletable());

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

    protected function assertCategoryCreationEvents(Category $category)
    {
        static::assertCategoryEvents([
            CategoryCreating::class, CategoryCreated::class, CategorySaving::class, CategorySaved::class
        ], function (AbstractCategoryEvent $e) use ($category) {
            return $e->category->id === $category->id;
        });
    }

    protected function assertCategoryModificationEvents(Category $category)
    {
        static::assertCategoryEvents([
            CategoryUpdating::class, CategoryUpdated::class, CategorySaving::class, CategorySaved::class
        ], function (AbstractCategoryEvent $e) use ($category) {
            return $e->category->id === $category->id;
        });
    }

    /**
     * @param  array          $events
     * @param  \Closure|null  $callback
     */
    protected function assertCategoryEvents(array $events, $callback = null)
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
