<?php namespace Arcanesoft\Blog\Tests\Unit\Entities;

use Arcanesoft\Blog\Entities\PostStatus;
use Arcanesoft\Blog\Tests\TestCase;

/**
 * Class     PostStatusTest
 *
 * @package  Arcanesoft\Blog\Tests\Unit\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostStatusTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_get_all()
    {
        $statuses = PostStatus::all();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $statuses);

        $expected = [
            PostStatus::STATUS_DRAFT     => 'Draft',
            PostStatus::STATUS_PUBLISHED => 'Published',
        ];

        $this->assertEquals($expected, $statuses->toArray());
    }

    /** @test */
    public function it_can_get_all_translated()
    {
        $statuses = PostStatus::all('fr');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $statuses);

        $expected = [
            PostStatus::STATUS_DRAFT     => 'Brouillon',
            PostStatus::STATUS_PUBLISHED => 'Publié',
        ];

        $this->assertEquals($expected, $statuses->toArray());
    }

    /** @test */
    public function it_can_get_keys()
    {
        $statuses = PostStatus::keys();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $statuses);

        $this->assertEquals([PostStatus::STATUS_DRAFT, PostStatus::STATUS_PUBLISHED], $statuses->toArray());
    }

    /** @test */
    public function it_can_get_one()
    {
        $expectations = [
            PostStatus::STATUS_DRAFT     => 'Draft',
            PostStatus::STATUS_PUBLISHED => 'Published',
            'unknown'                    => null,
        ];

        foreach ($expectations as $key => $expected) {
            $this->assertSame($expected, PostStatus::get($key));
        }
    }

    /**
     * @test
     *
     * @dataProvider provideStatusTranslations
     *
     * @param  string  $locale
     * @param  string  $key
     * @param  mixed   $expected
     */
    public function it_can_get_one_translated($locale, $key, $expected)
    {
        $this->assertSame($expected, PostStatus::get($key, null, $locale));
    }

    /**
     * Provide the status translations.
     *
     * @return array
     */
    public function provideStatusTranslations()
    {
        return [
            ['en', PostStatus::STATUS_DRAFT, 'Draft'],
            ['en', PostStatus::STATUS_PUBLISHED, 'Published'],
            ['en', 'unknown', null],
            ['fr', PostStatus::STATUS_DRAFT, 'Brouillon'],
            ['fr', PostStatus::STATUS_PUBLISHED, 'Publié'],
            ['fr', 'unknown', null],
        ];
    }

    /** @test */
    public function it_can_get_default_value_if_status_not_available()
    {
        $this->assertNull(PostStatus::get('pending'));
        $this->assertSame('Pending', PostStatus::get('pending', 'Pending'));
    }
}
