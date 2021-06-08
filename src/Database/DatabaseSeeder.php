<?php

declare(strict_types=1);

namespace Arcanesoft\Blog\Database;

use Arcanesoft\Blog\Database\Seeders\{PermissionSeeder, RoleSeeder};
use Arcanesoft\Foundation\Support\Database\Seeder;

/**
 * Class     DatabaseSeeder
 *
 * @package  Arcanesoft\Blog\Database
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DatabaseSeeder extends Seeder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the seeders.
     *
     * @return array
     */
    public function seeders(): array
    {
        return [
            PermissionSeeder::class,
            RoleSeeder::class,
        ];
    }
}
