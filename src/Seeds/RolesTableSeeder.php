<?php namespace Arcanesoft\Blog\Seeds;

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Seeds\RolesSeeder;
use Illuminate\Support\Str;

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

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Sync the roles.
     * @todo: Refactor this method
     *
     * @param  array  $roles
     */
    protected function syncRoles(array $roles)
    {
        $permissions = Permission::all();

        foreach ($roles as $roleSlug => $permissionSlug) {
            $ids  = $permissions->filter(function (Permission $permission) use ($permissionSlug) {
                return Str::startsWith($permission->slug, $permissionSlug);
            })->pluck('id');

            /** @var  \Arcanesoft\Auth\Models\Role  $role */
            if ($role = Role::where('slug', $roleSlug)->first()) {
                $role->permissions()->sync($ids);
            }
        }
    }
}
