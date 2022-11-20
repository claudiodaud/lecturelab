<?php

namespace App\Http\Livewire\Lectures;

use App\Models\Presample;
use App\Models\Role;
use App\Models\User;
use DB;
use Livewire\Component;

class Table extends Component
{
    public $co; 
    
    public $coControl;
   
    public $codCart;
   
    public $methode;
    
    public $registers; 
    

     //fields
    public $editAliquot;
    public $editColorimetric;
    public $editAbsorbance;
    
    Public $aliquotField;
    public $absorbanceField;
    public $colorimetricField;
    
    public $keyIdAliquot;
    public $keyIdColorimetric;
    public $keyIdAbsorbance;
    
    public $listeners = ['getRegisters','change_params','hideRegisters'];

    public $permissions; 

    public function mount()
    {
        $this->getPermissions();
    }

    
    public function render()
    {
        //esta linea debe estar aqui paraq la actualizacion de registros es para mantener la carga directa 
        
        $this->getRegisters();

        return view('livewire.lectures.table');
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

        $this->keyIdAliquot = null;
        $this->keyIdAbsorbance = null; 
        $this->keyIdColorimetric = null;
        $this->editAliquot = null; 
        $this->editAbsorbance = null; 
        $this->editColorimetric = null; 
        
        //dd([$this->co ,$this->coControl, $this->methode , $this->codCart, $value]);

        $this->getRegisters();
    }



    
    public function getRegisters()
    {
        //dd($this->method);
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
                 
            $this->registers = DB::table('presamples')->where('co', $this->co)->where('cod_carta', $this->codCart)->where('method', $this->methode)->get();
        }  

        
    }

    public function updatedKeyIdAliquot($keyIdAliquot)
    {
        $this->keyIdAliquot = $keyIdAliquot;
        $this->dispatchBrowserEvent('focus-aliquot', ['key' => $this->keyIdAliquot]);
    }

    public function updatedKeyIdColorimetric($keyIdColorimetric)
    {
        $this->keyIdColorimetric = $keyIdColorimetric;
        $this->dispatchBrowserEvent('focus-colorimetric', ['key' => $this->keyIdColorimetric]);
    }

    public function updatedKeyIdAbsorbance($keyIdAbsorbance)
    {
        $this->keyIdAbsorbance = $keyIdAbsorbance;
        $this->dispatchBrowserEvent('focus-absorbance', ['key' => $this->keyIdAbsorbance]);
    }

    public function moveToAliquot($key)
    {
        $this->keyIdColorimetric = null;
        $this->keyIdAbsorbance = null;
        $this->editColorimetric = false;
        $this->editAbsorbance = false;
        $this->keyIdAliquot= $key;
        $this->editAliquot = true;
        $this->dispatchBrowserEvent('focus-aliquot', ['key' => $this->keyIdAliquot]);
    }

    public function moveToAbsorbance($key)
    {
        $this->keyIdColorimetric = null;
        $this->keyIdAliquot = null;
        $this->editColorimetric = false;
        $this->editAliquot = false;        
        $this->keyIdAbsorbance = $key;
        $this->editAbsorbance = true;
        $this->dispatchBrowserEvent('focus-absorbance', ['key' => $this->keyIdAbsorbance]);
    }

    public function moveToColorimetric($key)
    {
        $this->keyIdAliquot = null;
        $this->keyIdAbsorbance = null;
        $this->editAliquot= false;
        $this->editAbsorbance = false;
        $this->keyIdColorimetric = $key;
        $this->editColorimetric = true;
        $this->dispatchBrowserEvent('focus-colorimetric', ['key' => $this->keyIdColorimetric]);
    }

    

    public function updatingKeyIdAbsorbance($key)
    {
            $this->keyIdAbsorbance = null;
            $this->editAbsorbance = false;
            $this->keyIdAbsorbance = $key;
            $this->editAbsorbance = true;


    }

    public function updatingKeyIdAliquot($key)
    {
            $this->keyIdAliquot = null;
            $this->editAliquot = false;
            $this->keyIdAliquot = $key;
            $this->editAliquot = true;

    }

    public function updatingKeyIdColorimetric($key)
    {
            $this->keyIdColorimetric = null;
            $this->editColorimetric = false;
            $this->keyIdColorimetric= $key;
            $this->editColorimetric = true;

    }

     

    public function updateAliquot($id)
    {
        

        if ($this->aliquotField != null) {
            $sample = Presample::updateOrCreate([
                'id' => $id,
            ],[
                'aliquot' => $this->aliquotField,
            ]);

            //factor de dilucion = (1/((PESO/250)*(ALICUOTA/100)))/1000
            $dilutionFactor = (1/(($sample->weight/250)*($sample->aliquot/100)))/1000;

            $sample = Presample::updateOrCreate([
                'id' => $id,
            ],[
                'dilution_factor' => $dilutionFactor,                
            ]);

            //% fosforo = factor colorimetrico * factor de dilucion * absorbancia
            $FC = $sample->colorimetric_factor;
            $FD = $sample->dilution_factor;
            $A  = $sample->absorbance;
            $phosphorous = $FC * $FD * $A; 
            //dd($phosphorous);
            Presample::updateOrCreate([
                'id' => $id,
            ],[
                'phosphorous' => $phosphorous,                
            ]);
        }

        $this->aliquotField = null;
        if (count($this->registers) > $this->keyIdAliquot + 1) {
            
            $this->keyIdAliquot = $this->keyIdAliquot + 1;
            $this->editAliquot = true;
            $this->dispatchBrowserEvent('focus-aliquot', ['key' => $this->keyIdAliquot]);
            
            
        }else{
            $this->closeAliquot();
           
        }
        

        

    }

    public function closeAliquot()
    {
        $this->keyIdAliquot = null;
        $this->editAliquot = false;
    }

    

    public function updateColorimetric($id)
    {
        if ($this->colorimetricField != null) {       
            $sample = Presample::updateOrCreate([
                'id' => $id,
            ],[
                'colorimetric_factor' => $this->colorimetricField,
            ]);

            //factor de dilucion = (1/((PESO/250)*(ALICUOTA/100)))/1000
            $dilutionFactor = (1/(($sample->weight/250)*($sample->aliquot/100)))/1000;

            $sample = Presample::updateOrCreate([
                'id' => $id,
            ],[
                'dilution_factor' => $dilutionFactor,                
            ]);

            //% fosforo = factor colorimetrico * factor de dilucion * absorbancia
            $FC = $sample->colorimetric_factor;
            $FD = $sample->dilution_factor;
            $A  = $sample->absorbance;
            $phosphorous = $FC * $FD * $A; 
            //dd($phosphorous);
            Presample::updateOrCreate([
                'id' => $id,
            ],[
                'phosphorous' => $phosphorous,                
            ]);
        }

        $this->colorimetricField = null;
        if (count($this->registers) > $this->keyIdColorimetric + 1) {
            $this->keyIdColorimetric = $this->keyIdColorimetric + 1;
            $this->editColorimetric = true;
            $this->dispatchBrowserEvent('focus-colorimetric', ['key' => $this->keyIdColorimetric]);
            
        }else{
            $this->closeColorimetric();
            
        }
    }

    public function closeColorimetric()
    {
        $this->keyIdColorimetric = null;
        $this->editColorimetric = false;
    }

    

    public function updateAbsorbance($id)
    {
        //dd($id);
        if ($this->absorbanceField != null) {       
            $sample = Presample::updateOrCreate([
                'id' => $id,
            ],[
                'absorbance' => $this->absorbanceField,
            ]);
            
            //factor de dilucion = (1/((PESO/250)*(ALICUOTA/100)))/1000
            $dilutionFactor = (1/(($sample->weight/250)*($sample->aliquot/100)))/1000;

            $sample = Presample::updateOrCreate([
                'id' => $id,
            ],[
                'dilution_factor' => $dilutionFactor,                
            ]);

            //% fosforo = factor colorimetrico * factor de dilucion * absorbancia
            $FC = $sample->colorimetric_factor;
            $FD = $sample->dilution_factor;
            $A  = $sample->absorbance;
            $phosphorous = $FC * $FD * $A; 
            //dd($phosphorous);
            Presample::updateOrCreate([
                'id' => $id,
            ],[
                'phosphorous' => $phosphorous,                
            ]);
        }

        $this->absorbanceField = null;
        if (count($this->registers) > $this->keyIdAbsorbance + 1) {
            $this->keyIdAbsorbance = $this->keyIdAbsorbance + 1;
            $this->editAbsorbance = true;
            $this->dispatchBrowserEvent('focus-absorbance', ['key' => $this->keyIdAbsorbance]);
            
        }else{
            $this->closeAbsorbance();

        }
       
    }

    public function closeAbsorbance()
    {
        $this->keyIdAbsorbance = null;
        $this->editAbsorbance = false;
    }

    
}
