<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::query()->insertOrIgnore([
            /*Admin Roles Permissions*/
            [
                'name' => 'roles',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'roles_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'roles_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'roles_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'roles_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],[
                'name' => 'admin',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'company',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'incubator',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            /*Admin Users Permissions*/
            [
                'name' => 'web',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'users_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'users_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'users_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'users_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            /*Admin Users Permissions*/
            [
                'name' => 'permissions',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'permissions_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'permissions_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'permissions_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'permissions_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'companies',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'companies_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'companies_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'companies_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'companies_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'incubators',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'incubators_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'incubators_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'incubators_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'incubators_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'jobs',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'jobs_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'jobs_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'jobs_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'jobs_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'plans',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'plans_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'plans_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'plans_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'plans_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'features',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'features_create',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'features_read',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'features_write',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'name' => 'features_delete',
                'guard_name'=> 'web',
                'created_at'=> Carbon::now(),
                'updated_at'=> Carbon::now(),
            ]
        ]);
    }
}
