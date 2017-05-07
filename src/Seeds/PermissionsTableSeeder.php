<?php namespace Arcanesoft\Blog\Seeds;

use Arcanesoft\Auth\Seeds\PermissionsSeeder;
use Arcanesoft\Blog\Policies\CategoriesPolicy;
use Arcanesoft\Blog\Policies\DashboardPolicy;
use Arcanesoft\Blog\Policies\PostsPolicy;
use Arcanesoft\Blog\Policies\TagsPolicy;

/**
 * Class     PermissionsTableSeeder
 *
 * @package  Arcanesoft\Blog\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsTableSeeder extends PermissionsSeeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
                    $this->getDashboardPermissions(),
                    $this->getPostsPermissions(),
                    $this->getCategoriesPermissions(),
                    $this->getTagsPermissions()
                ),
            ],
        ]);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the dashboard permissions
     *
     * @return array
     */
    private function getDashboardPermissions()
    {
        return [
            [
                'name'        => 'Statistics - Show all the stats',
                'description' => 'Show all the blog stats.',
                'slug'        => DashboardPolicy::PERMISSION_STATS,
            ],
        ];
    }

    /**
     * Get the Posts permissions.
     *
     * @return array
     */
    private function getPostsPermissions()
    {
        return [
            [
                'name'        => 'Posts - List all posts',
                'description' => 'Allow to list all posts.',
                'slug'        => PostsPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Posts - View a post',
                'description' => 'Allow to display a post.',
                'slug'        => PostsPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Posts - Create a post',
                'description' => 'Allow to create a post.',
                'slug'        => PostsPolicy::PERMISSION_CREATE,
            ],
            [
                'name'        => 'Posts - Update a post',
                'description' => 'Allow to update a post.',
                'slug'        => PostsPolicy::PERMISSION_UPDATE,
            ],
            [
                'name'        => 'Posts - Delete a post',
                'description' => 'Allow to delete a post.',
                'slug'        => PostsPolicy::PERMISSION_DELETE,
            ],
        ];
    }

    /**
     * Get the Categories permissions.
     *
     * @return array
     */
    private function getCategoriesPermissions()
    {
        return [
            [
                'name'        => 'Categories - List all categories',
                'description' => 'Allow to list all categories.',
                'slug'        => CategoriesPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Categories - View a category',
                'description' => 'Allow to display a category.',
                'slug'        => CategoriesPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Categories - Create a category',
                'description' => 'Allow to create a category.',
                'slug'        => CategoriesPolicy::PERMISSION_CREATE,
            ],
            [
                'name'        => 'Categories - Update a category',
                'description' => 'Allow to update a category.',
                'slug'        => CategoriesPolicy::PERMISSION_UPDATE,
            ],
            [
                'name'        => 'Categories - Delete a category',
                'description' => 'Allow to delete a category.',
                'slug'        => CategoriesPolicy::PERMISSION_DELETE,
            ],
        ];
    }

    /**
     * Get the Tags permissions.
     *
     * @return array
     */
    private function getTagsPermissions()
    {
        return [
            [
                'name'        => 'Tags - List all tags',
                'description' => 'Allow to list all tags.',
                'slug'        => TagsPolicy::PERMISSION_LIST,
            ],
            [
                'name'        => 'Tags - View a tag',
                'description' => 'Allow to display a tag.',
                'slug'        => TagsPolicy::PERMISSION_SHOW,
            ],
            [
                'name'        => 'Tags - Create a tag',
                'description' => 'Allow to create a tag.',
                'slug'        => TagsPolicy::PERMISSION_CREATE,
            ],
            [
                'name'        => 'Tags - Update a tag',
                'description' => 'Allow to update a tag.',
                'slug'        => TagsPolicy::PERMISSION_UPDATE,
            ],
            [
                'name'        => 'Tags - Delete a tag',
                'description' => 'Allow to delete a tag.',
                'slug'        => TagsPolicy::PERMISSION_DELETE,
            ],
        ];
    }
}
