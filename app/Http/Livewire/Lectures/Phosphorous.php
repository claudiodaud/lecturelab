<?php

namespace App\Http\Livewire\Lectures;

use App\Models\Presample;
use DB;
use Livewire\Component;

class Phosphorous extends Component
{
    public $co = 71242; 
    public $control; 
    public $codControl; 
    public $coControl;
    public $cart;
    public $codCart;
    public $methods;
    public $method = 'GEO-517';
    public $codMethod;
    public $samples; 
    public $registers = null; 
    public $aliquot = 25;
    public $colorimetricFactor = 0.125359884;
    public $absorbance = 0;


    //modales
    public $info = false;

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

    public $focusAliquot;



    public function render()
    {
        $this->getCo();
        
        return view('livewire.lectures.phosphorous');
    }

    public function updatingCo()
    {
        if ($this->coControl != strval($this->co)) {
            $this->method = null;
            $this->registers = null;
        }
    }

    public function getCo()
    {
        //verificamos que la variable co no sea null
        if ($this->co != null) {
            //realizamos la busqueda en plusmanager
            $query = "SELECT * FROM dbo.CONTROL WHERE CODIGO = $this->co";
            $this->control = DB::connection('sqlsrv')->select($query);
            
            //verificamos lo que encontramos 
            if ($this->control != null) {
                // si la variable control tiene algo asignamos el cod control que debe ser igual al co 
                $this->codControl = $this->control[0]->COD_CONTROL;
                $this->coControl = $this->control[0]->CODIGO;

                //si el codControl es igual co buscamos la carta 
                if($this->coControl != strval($this->co)){
                    $this->method = null; 
                }elseif ($this->coControl == strval($this->co)) {
                    $query = "SELECT * FROM CARTA WHERE COD_CONTROL = $this->codControl";
                    $this->cart = DB::connection('sqlsrv')->select($query);
                    if ($this->cart) {
                        $this->codCart = $this->cart[0]->CODCARTA;

                        if ($this->codCart != null) {
                        $query = "SELECT * FROM METODOSGEO WHERE CODCARTA = $this->codCart AND (ELEMENTO = 'P' OR ELEMENTO = 'P DTT')";
                        $this->methods = DB::connection('sqlsrv')->select($query);


                            if ($this->coControl == $this->co and $this->codCart != null and $this->method != null) {
                                $query = "SELECT * FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = '".$this->method."' ";      
                                $this->samples = DB::connection('sqlsrv')->select($query);

                                $this->getSamples();
                            }
                            
                        }
                    }
                }
                
            }
        }    
    }

    
    public function getSamples()
    {
        //validamos que las muestras existen en plus manager 
        if ($this->samples != null and $this->codControl != null and $this->codCart != null and $this->method != null) {


            //asignamos las muestras a una tabla momentanea para analizar manipular la informacion.     
            foreach ($this->samples as $key => $sample) {                
                    
                    Presample::updateOrCreate([
                        
                        'co' => $this->co,    
                        'cod_carta' => $this->codCart, 
                        'method' => $this->method,
                        'number' => $sample->numero,

                    ],[ 
                        'co' => $this->co,    
                        'cod_carta' => $this->codCart, 
                        'method' => $this->method,    
                        'number' => $sample->numero,
                        'name' => $sample->muestra,
                        
                        'weight' => $sample->peso,
                        
                        
                    ]);              
                
            }

            $this->getRegisters();
        }
    }

    public function getRegisters()
    {
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->method != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->method."' ORDER BY presamples.number ASC";     
            $this->registers = DB::connection('mysql')->select($query);
        }   
    }

   

    public function info()
    {        

        $this->info = true;
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
        if (count($this->samples) > $this->keyIdAliquot + 1) {
            
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

    public function applyAliquot()
    {
        //buscamos las muestras 
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->method != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->method."' ORDER BY presamples.number ASC";     
            $samples = DB::connection('mysql')->select($query);
        }

        foreach ($samples as $key => $sample) {
            Presample::find($sample->id)->update(['aliquot' => $this->aliquot]);
        }       
           
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
        if (count($this->samples) > $this->keyIdColorimetric + 1) {
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

    public function applyColorimetric()
    {
        //buscamos las muestras 
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->method != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->method."' ORDER BY presamples.number ASC";     
            $samples = DB::connection('mysql')->select($query);
        }
        
        foreach ($samples as $key => $sample) {
            Presample::find($sample->id)->update(['colorimetric_factor' => $this->colorimetricFactor]);
        }        
           
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
        if (count($this->samples) > $this->keyIdAbsorbance + 1) {
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

    public function applyAbsorbance()
    {
        //buscamos las muestras 
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->method != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->method."' ORDER BY presamples.number ASC";     
            $samples = DB::connection('mysql')->select($query);
        }
        
        foreach ($samples as $key => $sample) {
            Presample::find($sample->id)->update(['absorbance' => $this->absorbance]);
        }        
           
    }

    
    
}
