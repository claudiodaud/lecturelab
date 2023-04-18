<?php

namespace App\Http\Livewire\Volumetries;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Volumetries extends Component
{
    public $co;    
    public $samples;  
    public $control;
    public $codControl;
    public $coControl;
    public $cart;
    public $codCart;
    public $standart;
    public $methode;
    public $LdeD615;
    public $LdeD618; 
   
    //permissions
    public $permissions;

    //modal
    public $showUpdateModal;


    public function mount()
    {
        
        $this->getPermissions();
    }
   
    public function render()
    {
        
        if(in_array("viewPhosphorous", $this->permissions)){
            

            //$this->getCo(); 
            
            
            return view('livewire.volumetries.volumetries');

        }else{

            throw UnauthorizedException::forPermissions($this->permissions);

        }

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

    }
}
