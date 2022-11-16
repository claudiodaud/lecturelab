<?php

namespace App\Http\Livewire\Lectures;

use App\Models\Presample;
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

    
    public function render()
    {
        //esta linea debe estar aqui paraq la actualizacion de registros es para mantener la carga directa 
        $this->getRegisters();

        return view('livewire.lectures.table');
    }

    
    public function change_params($value)
    {
        //dd($value);
        $this->co = $value['co'];
        $this->coControl = $value['coControl'];
        $this->methode = $value['methode'];
        $this->codCart = $value['codCart'];
        
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

    public function updatingKeyIdAbsorbance($key)
    {
            $this->keyIdAbsorbance = null;
            $this->editAbsorbance= false;
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

    public function hideRegisters()
    {
        $this->registers = null;
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
