<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Database\Seeders;

use Arcanesoft\Foundation\Core\Database\RolesSeeder as Seeder;

/**
 * Class     RoleSeeder
 *
 * @package  Arcanesoft\Blog\Database\Seeders
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RoleSeeder extends Seeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedMany([
            [
                'name'        => 'Blog Moderator',
                'key'         => 'blog-moderator',
                'description' => 'The blog moderator role',
                'is_locked'   => true,
            ],
            [
                'name'        => 'Blog Author',
                'key'         => 'blog-author',
                'description' => 'The blog author role',
                'is_locked'   => true,
            ],
        ]);

        $this->syncRolesWithPermissions([
            'blog-moderator' => [
                'admin::dashboard.index',
                'admin::blog.*',
            ],
            'blog-author'    => [
                'admin::dashboard.index',
                'admin::blog.posts.*',
                'admin::blog.tags.*',
            ],
        ]);
    }
}
