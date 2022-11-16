<?php

namespace App\Http\Livewire\Lectures;

use Livewire\Component;

class Parameters extends Component
{
    public $aliquot = 25;
    public $colorimetricFactor = 0.125359884;
    public $absorbance = 0;

    public $listeners = ['render'];

    public function render()
    {
        
        return view('livewire.lectures.parameters');
               
    }

    public function applyAliquot()
    {
        //buscamos las muestras 
        // if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
        //     $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
        //     $samples = DB::connection('mysql')->select($query);
        // }

        // foreach ($samples as $key => $sample) {
        //     Presample::find($sample->id)->update(['aliquot' => $this->aliquot]);
        //     $this->updateDilutionAndPhosphorous($sample);
        // }      

        $this->emit('applyAliquot',$this->aliquot); 
           
    }

    
    public function applyColorimetric()
    {
        //buscamos las muestras 
        // if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
        //     $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
        //     $samples = DB::connection('mysql')->select($query);
        // }
        
        // foreach ($samples as $key => $sample) {
        //     Presample::find($sample->id)->update(['colorimetric_factor' => $this->colorimetricFactor]);
        //     $this->updateDilutionAndPhosphorous($sample);
        // }  
        $this->emit('applyColorimetric',$this->colorimetricFactor);       
           
    }

   

    public function applyAbsorbance()
    {
        //buscamos las muestras 
        // if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
        //     $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
        //     $samples = DB::connection('mysql')->select($query);
        // }
        
        // foreach ($samples as $key => $sample) {
        //     // actualizamos para todas la absorbancia 
        //     Presample::find($sample->id)->update(['absorbance' => $this->absorbance]);
                                
        //     $this->updateDilutionAndPhosphorous($sample);
                        
        // }
        $this->emit('applyAbsorbance',$this->absorbance);      
           
    }

    // public function updateDilutionAndPhosphorous($sample)
    // {
        
    //     //CALCULAMOS EL factor de dilucion = (1/((PESO/250)*(ALICUOTA/100)))/1000
    //     if ($sample->weight > 0 and $sample->aliquot > 0) {
    //         $dilutionFactor = (1/(($sample->weight/250)*($sample->aliquot/100)))/1000;
    //         //actualizamos para la muestra su factor de dilucion.
    //         //actualizamos la variable sample
            
    //         $sample = Presample::updateOrCreate([
    //             'id' => $sample->id,
    //         ],[
    //             'dilution_factor' => $dilutionFactor,                
    //         ]);

    //         //CALCULAMOS % fosforo = factor colorimetrico * factor de dilucion * absorbancia
    //         $FC = $sample->colorimetric_factor;
    //         $FD = $sample->dilution_factor;
    //         $A  = $sample->absorbance;

    //         //evaluamos si alguna de las variables anteriores es null,
    //         //si todas son variables calculamos el % de fosforo si no, no hacemos nada 
    //         if ($FC != null and $FD != null and $A != null and $FC > 0 and $FD > 0 and $A > 0) {
    //             //calculamos el fosforo 
    //             $phosphorous = $FC * $FD * $A; 
    //             //insertamos en la base de datos                 
    //             Presample::find($sample->id)->update(['phosphorous' => $phosphorous]);
    //         }
    //     }
    // }

}
