<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesPermisosSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $managerRol = Role::create(['guard_name' => 'api', 'name' => 'manager']);
    $agentRol = Role::create(['guard_name' => 'api', 'name' => 'agent']);
    Permission::create(['guard_name' => 'api', 'name' => 'api.leads.index'])->syncRoles([$managerRol, $agentRol]);
    Permission::create(['guard_name' => 'api', 'name' => 'api.lead.show'])->syncRoles([$managerRol, $agentRol]);
    Permission::create(['guard_name' => 'api', 'name' => 'api.lead.create'])->syncRoles([$managerRol]);
  }
}
