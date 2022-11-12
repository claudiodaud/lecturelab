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
    public $cart;
    public $codCart;
    public $methods;
    public $method;
    public $codMethod;
    public $samples; 
    public $registers = null; 
    public $aliquot = 25;
    public $colorimetricFactor = 0.125359884;
    public $dilutionFactor = 2;


    public function render()
    {
        
        $this->captureSamples();

        return view('livewire.lectures.phosphorous');
    }

    
    public function captureSamples()
    {
       if ($this->co != null) {
            $query = "SELECT * FROM dbo.CONTROL WHERE CODIGO = $this->co";
            $this->control = DB::connection('sqlsrv')->select($query);
            if ($this->control) {
                $this->codControl = $this->control[0]->COD_CONTROL;
            }
            
        }

        if ($this->codControl) {
            $query = "SELECT * FROM CARTA WHERE COD_CONTROL = $this->codControl";
            $this->cart = DB::connection('sqlsrv')->select($query);
            if ($this->cart[0]) {
                $this->codCart = $this->cart[0]->CODCARTA;
            }
            
            //dd($this->codCart);
        }

        if ($this->codCart) {
            $query = "SELECT * FROM METODOSGEO WHERE CODCARTA = $this->codCart AND (ELEMENTO = 'P' OR ELEMENTO = 'P DTT')";
            $this->methods = DB::connection('sqlsrv')->select($query);
            //dd($this->methods);
        }

        if($this->method === null){
            $this->registers = null;
            $this->samples = null;
            //eliminamos las muestras existentes
            Presample::where('co','=',$this->co)->where('cod_carta','=',$this->codCart)->delete();
            
        }

        //buscamos las muestras 
        if ($this->codCart and $this->method != null) {

            //eliminamos las muestras existentes
            Presample::where('co','=',$this->co)->where('cod_carta','=',$this->codCart)->delete();

            //buscamos las muestras actualizadas 
            $query = "SELECT * FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = $this->method";     
            $this->samples = DB::connection('sqlsrv')->select($query);
            


            //validamos que las muestras existen en plus manager 
            if ($this->samples) {


            //asignamos las muestras a una tabla momentanea para analizar manipular la informacion.     
            foreach ($this->samples as $key => $sample) {                
                    
                    Presample::updateOrCreate([
                        'number' => $sample->numero,
                    ],[ 
                        'co' => $this->co,    
                        'cod_carta' => $this->codCart, 
                        'method' => $this->method,    
                        'number' => $sample->numero,
                        'name' => $sample->muestra,
                        'absorbance' => null,
                        'weight' => $sample->peso,
                        'aliquot' => null,
                        'colorimetric_factor' => null,
                        'dilution_factor' => null,
                        'phosphorous' => 0,
                    ]);              
                
            }

            $query = "SELECT * FROM presamples ORDER BY presamples.number ASC";     
            $this->registers = DB::connection('mysql')->select($query);

        }

        

            

        }

        
    }

    
}
