<?php

namespace App\Http\Livewire\Volumetries;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use DB;

class Volumetries extends Component
{
    public $co = 72326;    
    public $samples;  
    public $control;
    public $codControl;
    public $coControl;
    public $cart;
    public $codCart;
    public $standart;
    public $methods;
    public $methode;
     
   
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
            

            $this->getCo(); 
            
            
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

    public function getCo()
    {
        //verificamos que la variable co no sea null
        if ($this->co != null) {

            //realizamos la busqueda en plusmanager
            $query = "SELECT COD_CONTROL, CODIGO, CLIENTE FROM dbo.CONTROL WHERE CODIGO = $this->co";
            $this->control = DB::connection('sqlsrv')->select($query);

            
            
            
            //verificamos lo que encontramos 
            if ($this->control != null) {
                // si la variable control tiene algo asignamos el cod control que debe ser igual al co 
                $this->codControl = $this->control[0]->COD_CONTROL;
                $this->coControl = $this->control[0]->CODIGO;



                //si el codControl es igual co buscamos la carta 
                if ($this->coControl == strval($this->co)) {
                    $query = "SELECT CODCARTA FROM CARTA WHERE COD_CONTROL = $this->codControl";
                    $this->cart = DB::connection('sqlsrv')->select($query);
                    if ($this->cart) {
                        $this->codCart = $this->cart[0]->CODCARTA;


                        $this->getMethods();
                        
                    }
                }
                
            }
        }    
    }

    public function getMethods()
    {
        if ($this->codCart != null) {
            $query = "SELECT GEO, ELEMENTO FROM METODOSGEO WHERE CODCARTA = $this->codCart";
            $this->methods = DB::connection('sqlsrv')->select($query);
           
            if ($this->coControl == $this->co and $this->codCart != null and $this->methode != null) {
                $query = "SELECT * FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = '".$this->methode."' ";      
                    $this->samples = DB::connection('sqlsrv')->select($query);
                                        

            }

        }
    }
}
