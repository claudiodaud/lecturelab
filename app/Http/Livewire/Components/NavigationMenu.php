<?php

namespace App\Http\Livewire\Components;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class NavigationMenu extends Component
{
    public $permissions;

    public function mount()
    {
        $this->getPermissions();
    }
    
    public function render()
    {
        $this->getPermissions();
        return view('livewire.components.navigation-menu');
    }

    public function getPermissions()
    {
        $userWithRolesAndPermissions = User::where('id',auth()->user()->id)->with('roles')->first();
        $userWithDirectsPermissions = User::where('id',auth()->user()->id)->with('permissions')->first();
        
        
        $permissions = [];

        //find permissions for roles
        foreach ($userWithRolesAndPermissions->roles as $key => $role) {
           
            $role = Role::where('id',$role->id)->with('permissions')->first();
                
                foreach ($role->permissions as $key => $permission) {
                    array_push($permissions,$permission->name);
                }                
        }

        //find directs permissions
        foreach ($userWithDirectsPermissions->permissions as $key => $permission) {
        
            array_push($permissions,$permission->name);
                         
        }

        $this->permissions = array_unique($permissions);

        //dd($this->permissions);
    }
}
