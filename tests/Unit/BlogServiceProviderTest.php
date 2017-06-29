<?php namespace Arcanesoft\Blog\Tests\Unit;

use Arcanesoft\Blog\BlogServiceProvider;
use Arcanesoft\Blog\Tests\TestCase;

/**
 * Class     BlogServiceProviderTest
 *
 * @package  Arcanesoft\Auth\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BlogServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Arcanesoft\Blog\BlogServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(BlogServiceProvider::class);
    }

    public function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanesoft\Blog\BlogServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provider()
    {
        $expected = [
            //
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }
}
