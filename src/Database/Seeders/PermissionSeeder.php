<?php declare(strict_types=1);

namespace Arcanesoft\Blog\Database\Seeders;

use Arcanesoft\Foundation\Core\Database\PermissionsSeeder as Seeder;

/**
 * Class     PermissionSeeder
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionSeeder extends Seeder
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
        $this->seed([
            'name'        => 'Blog',
            'slug'        => 'blog',
            'description' => 'Blog permissions group',
        ], $this->getPermissionsFromPolicyManager('admin::blog.'));
    }
}
