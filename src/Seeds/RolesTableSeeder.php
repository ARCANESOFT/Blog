<?php namespace Arcanesoft\Blog\Seeds;

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Seeds\RolesSeeder;

/**
 * Class     RolesTableSeeder
 *
 * @package  Arcanesoft\Blog\Seeds
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesTableSeeder extends RolesSeeder
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
                'name'        => 'Blog Moderators',
                'description' => 'The Blog moderators role.',
                'is_locked'   => true,
            ],[
                'name'        => 'Blog Authors',
                'description' => 'The Blog authors role.',
                'is_locked'   => true,
            ]
        ]);

        $this->syncAdminRole();
        $this->syncRoles();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sync the roles.
     *
     * @todo: Refactor this method
     */
    private function syncRoles()
    {
        $permissions = Permission::all();
        $roles       = [
            'blog-moderators' => 'blog.',
            'blog-authors'    => 'blog.posts.',
        ];

        foreach ($roles as $roleSlug => $permissionSlug) {
            /** @var  \Arcanesoft\Auth\Models\Role  $role */
            $role = Role::where('slug', $roleSlug)->first();
            $ids  = $permissions->filter(function (Permission $permission) use ($permissionSlug) {
                return starts_with($permission->slug, $permissionSlug);
            })->lists('id')->toArray();

            $role->permissions()->sync($ids);
        }
    }
}
