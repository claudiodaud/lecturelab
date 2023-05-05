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
    public $methodeComparative;

    public $methodsRegisters;
    
    public $registers; 
    

     //fields
    public $editAliquot;
    public $editColorimetric;
    public $editAbsorbance;
    public $editDilution;
    
    Public $aliquotField;
    public $absorbanceField;
    public $colorimetricField;
    public $dilutionField;
    
    public $keyIdAliquot;
    public $keyIdColorimetric;
    public $keyIdAbsorbance;
    public $keyIdDilution;
    
    public $listeners = ['getRegisters','change_params','hideRegisters'];

    public $permissions; 

    public $standart;

    // modal
    public $showComparativeModal;

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
        $this->standart = $value['standart'];

        $this->keyIdAliquot = null;
        $this->keyIdAbsorbance = null; 
        $this->keyIdColorimetric = null;
        $this->keyIdDilution = null;
        $this->editAliquot = null; 
        $this->editAbsorbance = null; 
        $this->editColorimetric = null; 
        $this->editDilution = null; 

        $this->methodsRegisters = null;
        
        //dd([$this->co ,$this->coControl, $this->methode , $this->codCart, $value]);

        $this->getRegisters();
    }



    
    public function getRegisters()
    {
        //dd($this->method);
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
                 
            $this->registers = Presample::where('co', $this->co)
                                    ->where('cod_carta', $this->codCart)
                                    ->where('method', $this->methode)
                                    ->with('writtenUser','updatedUser')
                                    ->orderBy('number', 'ASC')->get();
        }  

        if ($this->codCart != null) {
            $query = "SELECT CODMETODO, GEO, ELEMENTO FROM METODOSGEO WHERE CODCARTA = $this->codCart AND (ELEMENTO = 'P' OR ELEMENTO = 'P DTT')";
            $this->methodsRegisters = DB::connection('sqlsrv')->select($query);
            
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

    public function updatedKeyIdDilution($keyIdDilution)
    {
        $this->keyIdDilution = $keyIdDilution;
        $this->dispatchBrowserEvent('focus-dilution', ['key' => $this->keyIdDilution]);
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

    public function updatingKeyIdDilution($key)
    {
            $this->keyIdDilution = null;
            $this->editDilution = false;
            $this->keyIdDilution= $key;
            $this->editDilution = true;

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
                'written_by' => auth()->user()->id              
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
                'written_by' => auth()->user()->id                
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
                'written_by' => auth()->user()->id                
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


    public function updateDilution($id)
    {
    
        //BUSCAR EL REGISTRO 
        $register = Presample::find($id);
        $register->dilution = floatval($this->dilutionField);
        
        $register->save();

        
        $register->phosphorous = $register->phosphorous * $register->dilution;
        $register->save();

        

        //con el fosforo cargado revisamos si es mayor al registro geo de comparación 
        if ($register->phosphorous >= $register->geo_comparative) {
           $register->comparative = 1;
           $register->save();
           
        }elseif($register->phosphorous < $register->geo_comparative){
           $register->comparative = 0;
           $register->save(); 
        }
        
        $register->written_by = auth()->user()->id;
        $register->save();
        

        $this->dilutionField = null;
        if (count($this->registers) > $this->keyIdDilution + 1) {
            $this->keyIdDilution = $this->keyIdDilution + 1;
            $this->editDilution = true;
            $this->dispatchBrowserEvent('focus-dilution', ['key' => $this->keyIdDilution]);
            
        }else{
            $this->closeAbsorbance();

        }
        

        $this->dilutionField = null;


       
       
    }

    public function closeDilution()
    {
        $this->keyIdDilution = null;
        $this->editDilution = false;
    }


    public function getGeo()
    {
        $this->showComparativeModal = true ;

        
    }


    public function updateGeoComparative()
    {
        
        $query = "SELECT id, number , name, phosphorous FROM presamples WHERE co = $this->co and cod_carta = $this->codCart and method = '".$this->methodeComparative."' ";
        $comparativeValues = DB::connection('mysql')->select($query);

        foreach ($comparativeValues as $value) {
            
            // //dd($value);
            $r = Presample::where('name', $value->name)->where('number', $value->number)->where('co',$this->co)->where('method',$this->methode)->first();
            
            if ($r) {
                $r->geo = $this->methodeComparative; 
                $r->geo_comparative = $value->phosphorous;
                if ($r->phosphorous >= $value->phosphorous) {
                    $r->comparative = 1;
                }
                $r->save();



            }
            


            // $query = 'UPDATE presamples SET geo = ?, geo_comparative = ? WHERE number = ? and co = ? and method = ?'[$value->phosphorous,$this->methodeComparative,$value->number,$this->co,$this->methode];
            
            // DB::connection('mysql')->select($query);

            // Presample::where('number', $value->number)->where('co',$this->co)->where('method',$this->methode)
            //    ->update([
            //        'geo' => $this->methodeComparative,
            //        'geo_comparative' => $value->phosphorous
            //     ]);
           
        }

        $this->showComparativeModal = false ;
        $this->methodeComparative = false ;

        $this->emit('update');
    }


   

    
}
