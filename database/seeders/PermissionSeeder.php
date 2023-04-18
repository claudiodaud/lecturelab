<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //View Modules
        Permission::create(['name' => 'viewUsers','guard_name' => 'web']);
        Permission::create(['name' => 'viewRoles','guard_name' => 'web']);
        Permission::create(['name' => 'viewPermissions','guard_name' => 'web']);
        Permission::create(['name' => 'viewPhosphorous','guard_name' => 'web']);
        Permission::create(['name' => 'viewIrons','guard_name' => 'web']);
        Permission::create(['name' => 'viewVolumetries','guard_name' => 'web']);
        

        //User permissions
        Permission::create(['name' => 'user.deleted','guard_name' => 'web']);
        Permission::create(['name' => 'user.filter','guard_name' => 'web']);
        Permission::create(['name' => 'user.create','guard_name' => 'web']);
        Permission::create(['name' => 'user.download','guard_name' => 'web']);
        Permission::create(['name' => 'user.show','guard_name' => 'web']);
        Permission::create(['name' => 'user.edit','guard_name' => 'web']);
        Permission::create(['name' => 'user.delete','guard_name' => 'web']);
        Permission::create(['name' => 'user.restore','guard_name' => 'web']);
        Permission::create(['name' => 'user.forceDelete','guard_name' => 'web']);
        Permission::create(['name' => 'user.addRoles','guard_name' => 'web']);
        Permission::create(['name' => 'user.removeRoles','guard_name' => 'web']);
        Permission::create(['name' => 'user.addDirectPermissions','guard_name' => 'web']);
        Permission::create(['name' => 'user.removeDirectPermissions','guard_name' => 'web']);

        //Roles Permissions
        Permission::create(['name' => 'role.deleted','guard_name' => 'web']);
        Permission::create(['name' => 'role.filter','guard_name' => 'web']);
        Permission::create(['name' => 'role.create','guard_name' => 'web']);
        Permission::create(['name' => 'role.download','guard_name' => 'web']);
        Permission::create(['name' => 'role.show','guard_name' => 'web']);
        Permission::create(['name' => 'role.edit','guard_name' => 'web']);
        Permission::create(['name' => 'role.delete','guard_name' => 'web']);
        Permission::create(['name' => 'role.restore','guard_name' => 'web']);
        Permission::create(['name' => 'role.forceDelete','guard_name' => 'web']);
        Permission::create(['name' => 'role.addPermissions','guard_name' => 'web']);
        Permission::create(['name' => 'role.removePermissions','guard_name' => 'web']);

        //Phosphorous Permissions
        Permission::create(['name' => 'phosphorous.find','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.upload','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.parameters','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.download','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.absorbance','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.aliquot','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.colorimetric','guard_name' => 'web']);
        Permission::create(['name' => 'phosphorous.dilution','guard_name' => 'web']);


        //Irons Permissions
        Permission::create(['name' => 'irons.find','guard_name' => 'web']);
        Permission::create(['name' => 'irons.grade','guard_name' => 'web']);
        Permission::create(['name' => 'irons.upload','guard_name' => 'web']);
        Permission::create(['name' => 'irons.download','guard_name' => 'web']);


        //Irons Permissions
        Permission::create(['name' => 'volumetries.find','guard_name' => 'web']);
        Permission::create(['name' => 'volumetries.grade','guard_name' => 'web']);
        Permission::create(['name' => 'volumetries.upload','guard_name' => 'web']);
        Permission::create(['name' => 'volumetries.download','guard_name' => 'web']);
        Permission::create(['name' => 'volumetries.title','guard_name' => 'web']);
        
        

    }
}
