<?php

namespace App\Http\Livewire\Irons;

use App\Models\Iron;
use App\Models\Role;
use App\Models\User;
use DB;
use Livewire\Component;

class Table extends Component
{
    public $co;
    public $codCart;
    public $coControl;
    public $registers;
    public $standart;

    public $keyIdIronGrade;
    public $ironGradeField;

    public $listeners = ['change_params','getRegisters'];


    //permissions
    public $permissions;
    
    public function mount()
    {
        
        $this->getPermissions();
    }

    public function render()
    {   
        $this->getRegisters();        
        
        return view('livewire.irons.table');
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

    public function getRegisters()
    {
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->codCart != null) {
            if (!$this->registers) {
               $this->emit('samples');
            }
            $this->registers = Iron::where('co',$this->co)->where('cod_carta',$this->codCart)->get();
            
            
        }      
            
    }

    public function change_params($value){


        $this->co = $value['co'];
        $this->coControl = $value['coControl'];
        $this->codCart = $value['codCart'];
        $this->standart = $value['standart'];
        
        if ($this->co != $this->coControl) {
            $this->registers = null;
        }

        $this->getRegisters();


    }


     public function updatedKeyIdIronGrade($keyIdIronGrade)
    {
        $this->keyIdIronGrade = $keyIdIronGrade;
        $this->dispatchBrowserEvent('focus-iron-grade', ['key' => $this->keyIdIronGrade]);
    }

   
    
    public function updatingKeyIdIronGrade($key)
    {
            $this->keyIdIronGrade = null;
            $this->editIronGrade = false;
            $this->keyIdIronGrade = $key;
            $this->editIronGrade = true;

    }

    public function updateIronGrade($id)
    {
        

        if ($this->ironGradeField != null) {
           //buscamos el registro a actualizar
           $register = Iron::find($id);

           $register->iron_grade = $this->ironGradeField;
           $register->geo615 = $this->ironGradeField * 10;
           $register->geo618 = $this->ironGradeField * 10 * 0.72;
           if ($register->geo644 > $register->geo618 ) {
                $register->comparative = true;
            }else{
                    $register->comparative = false;
            } 
          
           $register->written_by = auth()->user()->id;
           $register->save();

           $this->getRegisters();


        }

        $this->ironGradeField = null;
        if (count($this->registers) > $this->keyIdIronGrade + 1) {
            
            $this->keyIdIronGrade = $this->keyIdIronGrade + 1;
            $this->editIronGrade = true;
            $this->dispatchBrowserEvent('focus-iron-grade', ['key' => $this->keyIdIronGrade]);
            
            
        }else{
            $this->closeIronGrade();
           
        }        

    }

    public function closeIronGrade()
    {
        $this->keyIdIronGrade = null;
        $this->editIronGrade = false;
    }

    public function getGeo644()
    {
        $query_aas400 = "SELECT numero, ley, LdeD  FROM aas400 WHERE aas400.co=$this->co and aas400.metodo='GEO-644' and aas400.ELEMENTO='Fe'";
        $AASregisters = DB::connection('sqlsrv')->select($query_aas400);

        foreach ($AASregisters as $key => $r) {
            $samplex = Iron::where('co',$this->co)
                    ->where('number',$r->numero)->first();
            $samplex->geo644 = $this->tofloat($r->ley);
            $samplex->save();

        } 

        // para recalcular los registros en el componente tabla 
        if ($this->coControl == strval($this->co)) {
        $this->emit('change_params',[
                'co' => $this->co,
                'coControl' => $this->coControl,
                'codCart' => $this->codCart, 
                'standart' => $this->standart,
               ]);

        $this->emit('update');    

       }
    }

    function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
      
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }

        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }

}
