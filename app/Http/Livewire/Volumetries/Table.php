<?php

namespace App\Http\Livewire\Volumetries;

use App\Models\Role;
use App\Models\User;
use App\Models\Volumetry;
use DB;
use Livewire\Component;

class Table extends Component
{

    public $registers;
    public $co;
    public $coControl;
    public $codCart;
    public $methode;
    public $standart;

    public $keyIdSpent;
    public $spentField;
    public $editSpent;


    public $listeners = ['change_params'];


    public function mount()
    {
        $this->getPermissions();
    }

    
    public function render()
    {
        //esta linea debe estar aqui paraq la actualizacion de registros es para mantener la carga directa 


        $this->getRegisters();
        

        return view('livewire.volumetries.table');
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

    
    public function change_params($value)
    {
        //dd($value);
        $this->co = $value['co'];
        $this->coControl = $value['coControl'];
        $this->methode = $value['methode'];
        $this->codCart = $value['codCart'];
        $this->standart = $value['standart'];
        

        $this->keyIdSpent = null;        
        $this->editSpent = null; 
        $this->spentField = null;
       
        $this->getRegisters();
    }


    public function getRegisters()
    {
        
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
                 
            $this->registers = DB::table('volumetries')->where('co', $this->co)
                                                    ->where('cod_carta', $this->codCart)
                                                    ->where('method', $this->methode)
                                                    ->orderBy('number', 'ASC')->get();
        }  
        
        
    }


     public function updatedKeyIdSpent($keyIdSpent)
    {
        $this->keyIdSpent = $keyIdSpent;
        $this->dispatchBrowserEvent('spent', ['key' => $this->keyIdSpent]);
    }

   
    
    public function updatingKeyIdSpent($key)
    {
            $this->keyIdSpent = null;
            $this->editSpent = false;
            $this->keyIdSpent = $key;
            $this->editSpent = true;

    }

    public function updateSpent($id)
    {
        

        if ($this->spentField != null) {
           //buscamos el registro a actualizar
           $register = Volumetry::find($id);

           $register->spent = $this->spentField;
          
           // realizar calculos sobre el titulante y calculo de la ley  
          
           $register->written_by = auth()->user()->id;
           $register->save();

           $this->getRegisters();


        }

        $this->spentField = null;
        if (count($this->registers) > $this->keyIdSpent + 1) {
            
            $this->keyIdSpent = $this->keyIdSpent + 1;
            $this->editSpent = true;
            $this->dispatchBrowserEvent('spent', ['key' => $this->keyIdSpent]);
            
            
        }else{
            $this->closeSpent();
           
        }        

    }

    public function closeSpent()
    {
        $this->keyIdSpent = null;
        $this->editSpent = false;
    }
}
