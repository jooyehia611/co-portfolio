<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage Settings', 'slug' => 'manage_settings', 'group' => 'settings'],
            ['name' => 'Manage Homepage', 'slug' => 'manage_homepage', 'group' => 'content'],
            ['name' => 'Manage Services', 'slug' => 'manage_services', 'group' => 'content'],
            ['name' => 'Manage Projects', 'slug' => 'manage_projects', 'group' => 'content'],
            ['name' => 'Manage Team', 'slug' => 'manage_team', 'group' => 'content'],
            ['name' => 'Manage Leads', 'slug' => 'manage_leads', 'group' => 'leads'],
            ['name' => 'Manage Users', 'slug' => 'manage_users', 'group' => 'users'],
            ['name' => 'Manage Media', 'slug' => 'manage_media', 'group' => 'media'],
            ['name' => 'Manage SEO', 'slug' => 'manage_seo', 'group' => 'seo'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        $allPermissions = Permission::all();

        $superAdmin = Role::firstOrCreate(['slug' => 'super_admin'], [
            'name' => 'Super Admin',
            'description' => 'Full system access',
        ]);
        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        $admin = Role::firstOrCreate(['slug' => 'admin'], [
            'name' => 'Admin',
            'description' => 'Administrative access except user management',
        ]);
        $admin->permissions()->sync(
            $allPermissions->whereNotIn('slug', ['manage_users'])->pluck('id')
        );

        $editor = Role::firstOrCreate(['slug' => 'editor'], [
            'name' => 'Editor',
            'description' => 'Content editing access',
        ]);
        $editor->permissions()->sync(
            $allPermissions->whereIn('slug', [
                'manage_homepage', 'manage_services', 'manage_projects', 'manage_team', 'manage_media',
            ])->pluck('id')
        );

        User::updateOrCreate(['email' => 'admin@ytech.com'], [
            'name' => 'Ytech Admin',
            'password' => Hash::make('password'),
            'role_id' => $superAdmin->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
