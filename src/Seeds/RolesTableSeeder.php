<?php namespace Arcanesoft\Blog\Seeds;

use Arcanesoft\Auth\Seeds\RolesSeeder;

/**
 * Class     RolesTableSeeder
 *
 * @package  Arcanesoft\Blog\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesTableSeeder extends RolesSeeder
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
                'name'        => 'Blog Moderators',
                'description' => 'The Blog moderators role.',
                'is_locked'   => true,
            ],
            [
                'name'        => 'Blog Authors',
                'description' => 'The Blog authors role.',
                'is_locked'   => true,
            ],
        ]);

        $this->syncAdminRole();
        $this->syncRoles([
            'blog-moderators' => 'blog.',
            'blog-authors'    => 'blog.posts.',
        ]);
    }
}
