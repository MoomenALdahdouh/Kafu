<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permissions = Permission::query()->pluck('id', 'id')->all();
        $admin_role = Role::query()->firstOrCreate(['name' => 'Admin'], ['guard_name' => 'web']);
        $admin_role->syncPermissions($admin_permissions);

        $company_permissions = Permission::query()
            ->where('name', 'like', '%jobs%')
            ->orWhere('name', 'like', '%company%')
            ->pluck('id', 'id')
            ->all();
        $company_role = Role::query()->firstOrCreate(['name' => 'Company'], ['guard_name' => 'web']);
        $company_role->syncPermissions($company_permissions);

        $incubator_permissions = Permission::query()
            ->where('name', 'like', '%jobs%')
            ->orWhere('name', 'like', '%companies%')
            ->orWhere('name', 'like', '%incubators%')
            ->pluck('id', 'id')
            ->all();
        $incubator_role = Role::query()->firstOrCreate(['name' => 'Incubator'], ['guard_name' => 'web']);
        $incubator_role->syncPermissions($incubator_permissions);
    }
}
