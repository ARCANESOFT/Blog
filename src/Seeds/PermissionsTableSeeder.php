<?php namespace Arcanesoft\Blog\Seeds;

use Arcanesoft\Auth\Seeds\PermissionsSeeder;

/**
 * Class     PermissionsTableSeeder
 *
 * @package  Arcanesoft\Blog\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsTableSeeder extends PermissionsSeeder
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->seed([
            [
                'group'       => [
                    'name'        => 'Blog',
                    'slug'        => 'blog',
                    'description' => 'Blog permissions group',
                ],
                'permissions' => array_merge(
                    $this->getPostsSeeds(),
                    $this->getCategoriesSeeds(),
                    $this->getTagsSeeds()
                ),
            ],
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the Posts permissions.
     *
     * @return array
     */
    private function getPostsSeeds()
    {
        return [
            [
                'name'        => 'Posts - List all posts',
                'description' => 'Allow to list all posts.',
                'slug'        => 'blog.posts.list',
            ],[
                'name'        => 'Posts - View a post',
                'description' => 'Allow to display a post.',
                'slug'        => 'blog.posts.show',
            ],[
                'name'        => 'Posts - Create a post',
                'description' => 'Allow to create a post.',
                'slug'        => 'blog.posts.create',
            ],[
                'name'        => 'Posts - Update a post',
                'description' => 'Allow to update a post.',
                'slug'        => 'blog.posts.update',
            ],[
                'name'        => 'Posts - Delete a post',
                'description' => 'Allow to delete a post.',
                'slug'        => 'blog.posts.delete',
            ]
        ];
    }

    /**
     * Get the Categories permissions.
     *
     * @return array
     */
    private function getCategoriesSeeds()
    {
        return [
            [
                'name'        => 'Categories - List all posts',
                'description' => 'Allow to list all categories.',
                'slug'        => 'blog.categories.list',
            ],[
                'name'        => 'Categories - View a category',
                'description' => 'Allow to display a category.',
                'slug'        => 'blog.categories.show',
            ],[
                'name'        => 'Categories - Create a category',
                'description' => 'Allow to create a category.',
                'slug'        => 'blog.categories.create',
            ],[
                'name'        => 'Categories - Update a category',
                'description' => 'Allow to update a category.',
                'slug'        => 'blog.categories.update',
            ],[
                'name'        => 'Categories - Delete a category',
                'description' => 'Allow to delete a category.',
                'slug'        => 'blog.categories.delete',
            ]
        ];
    }

    /**
     * Get the Tags permissions.
     *
     * @return array
     */
    private function getTagsSeeds()
    {
        return [
            [
                'name'        => 'Tags - List all tags',
                'description' => 'Allow to list all tags.',
                'slug'        => 'blog.tags.list',
            ],[
                'name'        => 'Tags - View a tag',
                'description' => 'Allow to display a tag.',
                'slug'        => 'blog.tags.show',
            ],[
                'name'        => 'Tags - Create a tag',
                'description' => 'Allow to create a tag.',
                'slug'        => 'blog.tags.create',
            ],[
                'name'        => 'Tags - Update a tag',
                'description' => 'Allow to update a tag.',
                'slug'        => 'blog.tags.update',
            ],[
                'name'        => 'Tags - Delete a tag',
                'description' => 'Allow to delete a tag.',
                'slug'        => 'blog.tags.delete',
            ]
        ];
    }
}
