<?php

namespace App\Http\Livewire\Lectures;

use App\Exports\SamplesExport;
use App\Models\Parameter;
use App\Models\Presample;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Phosphorous extends Component
{
    public $co; 
    public $control; 
    public $codControl; 
    public $coControl;
    public $cart;
    public $codCart;
    public $methodsRegisters;
    public $methode;
    public $codMethod;
    public $samples; 
     
    public $aliquot;
    public $colorimetricFactor;
    public $absorbance;

    public $listeners = ['applyAliquot','applyAbsorbance','applyColorimetric'];


    //modales
    public $info = false;

    //permissions
    public $permissions; 


    public function mount()
    {
        $aliquot = DB::table('parameters')->where('control', 'phosphorous')->where('type_var', 'aliquot')->first('value');
        $this->aliquot = $aliquot->value;

        $colorimetricFactor = Parameter::where('control', 'phosphorous')->where('type_var', 'colorimetric_factor')->first('value');
        $this->colorimetricFactor = $colorimetricFactor->value;
       
        $absorbance = Parameter::where('control', 'phosphorous')->where('type_var', 'absorbance')->first('value');
        $this->absorbance = $absorbance->value;

        $this->getPermissions();
    }
   
    public function render()
    {
        
        if(in_array("viewPhosphorous", $this->permissions)){
            
            $this->getCo(); 
            return view('livewire.lectures.phosphorous');

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

        //dd($this->permissions);
    }

    public function updatingCo()
    {
        if ($this->coControl != strval($this->co)) {
            $this->methode = null;
            $this->control = null;
            $this->coControl = null;
            $this->samples = null;
        }

        if ($this->coControl != strval($this->co) and $this->methode == null) {
          $this->dispatchBrowserEvent('focus-geo-select');  
        }
            
        
    }

    public function updatedMethode()
    {
        
        $this->emit('change_params',[
            'co' => $this->co,
            'coControl' => $this->coControl,
            'methode' => $this->methode,
            'codCart' => $this->codCart 
        ]);

        $this->emit('render');
        if ($this->methode != null) {
            $this->emit('methode');
        }

        // limpiar las variables de kei alicuota y edit alicuota 
        
           
    }

    public function updatedAliquot()
    {
        Parameter::where('control', 'phosphorous')->where('type_var', 'aliquot')->update(['value' => $this->aliquot]);
    }

    public function updatedColorimetric()
    {
        Parameter::where('control', 'phosphorous')->where('type_var', 'colorimetric_factor')->update(['value' => $this->colorimetricFactor]);
    }

    public function updatedAbsorbance()
    {
        Parameter::where('control', 'phosphorous')->where('type_var', 'absorbance')->update(['value' => $this->absorbance]);
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
                if ($this->coControl == strval($this->co)) {
                    $query = "SELECT * FROM CARTA WHERE COD_CONTROL = $this->codControl";
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
            $query = "SELECT * FROM METODOSGEO WHERE CODCARTA = $this->codCart AND (ELEMENTO = 'P' OR ELEMENTO = 'P DTT')";
            $this->methodsRegisters = DB::connection('sqlsrv')->select($query);
            if ($this->coControl == $this->co and $this->codCart != null and $this->methode != null) {
                $query = "SELECT * FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = '".$this->methode."' ";      
                    $this->samples = DB::connection('sqlsrv')->select($query);

                    $this->getSamples();

            }

        }
    }

       
    public function getSamples()
    {   
        if ($this->coControl == $this->co and $this->codCart != null and $this->methode != null) {
                $query = "SELECT * FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = '".$this->methode."' ";      
                $this->samples = DB::connection('sqlsrv')->select($query);

                //$this->getSamples();
        }

        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
            $samplesMySQL = DB::connection('mysql')->select($query);
        

            //validamos que las muestras existen en plus manager 
            if ($samplesMySQL == null) {


                //asignamos las muestras a una tabla momentanea para analizar manipular la informacion.     
                foreach ($this->samples as $key => $sample) {                
                        
                    $dilutionFactor = (1/(($sample->peso/250)*($this->aliquot/100)))/1000;

                    $FC = $this->colorimetricFactor;
                    $FD = $dilutionFactor;
                    $A  = $this->absorbance;

                    $phosphorous = $FC * $FD * $A; 

                        Presample::updateOrCreate([
                            
                            'co' => $this->co,    
                            'cod_carta' => $this->codCart, 
                            'method' => $this->methode,
                            'number' => $sample->numero,

                        ],[ 
                            'co' => $this->co,    
                            'cod_carta' => $this->codCart, 
                            'method' => $this->methode,    
                            'number' => $sample->numero,
                            'name' => $sample->muestra,
                            'weight' => $sample->peso,
                            'absorbance' => $this->absorbance,
                            'aliquot' => $this->aliquot,
                            'colorimetric_factor' => $this->colorimetricFactor,
                            'dilution_factor' => $dilutionFactor,
                            'phosphorous' => $phosphorous,

                        ]);              
                    
                }

                
            }

            //$this->emit('getRegisters');

        }   
        
        
    }

     

    public function info()
    {        

        $this->info = true;
    }

    public function applyAliquot()
    {
        $this->emit('success'); 
        //buscamos las muestras 
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
            $samples = DB::connection('mysql')->select($query);
        }

        foreach ($samples as $key => $sample) {
            Presample::find($sample->id)->update(['aliquot' => $this->aliquot]);
            $this->updateDilutionAndPhosphorous($sample);
        } 
        $this->emit('getRegisters');       
           
    }

    
    public function applyColorimetric()
    {
        $this->emit('success');
        //buscamos las muestras 
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
            $samples = DB::connection('mysql')->select($query);
        }
        
        foreach ($samples as $key => $sample) {
            Presample::find($sample->id)->update(['colorimetric_factor' => $this->colorimetricFactor]);
            $this->updateDilutionAndPhosphorous($sample);
        } 
        $this->emit('getRegisters');        
           
    }

   

    public function applyAbsorbance()
    {
        $this->emit('success');
        //buscamos las muestras 
        if ($this->coControl != null and $this->co != null and $this->coControl == strval($this->co) and $this->methode != null and $this->codCart != null) {
            $query = "SELECT * FROM presamples WHERE CO = $this->co and cod_carta = $this->codCart and method = '".$this->methode."' ORDER BY presamples.number ASC";     
            $samples = DB::connection('mysql')->select($query);
        }
        
        foreach ($samples as $key => $sample) {
            // actualizamos para todas la absorbancia 
            Presample::find($sample->id)->update(['absorbance' => $this->absorbance]);
                                
            $this->updateDilutionAndPhosphorous($sample);
                        
        }
        $this->emit('getRegisters');      
           
    }

    public function updateDilutionAndPhosphorous($sample)
    {
        
        //CALCULAMOS EL factor de dilucion = (1/((PESO/250)*(ALICUOTA/100)))/1000
        if ($sample->weight > 0 and $sample->aliquot > 0) {
            $dilutionFactor = (1/(($sample->weight/250)*($sample->aliquot/100)))/1000;
            //actualizamos para la muestra su factor de dilucion.
            //actualizamos la variable sample
            
            $sample = Presample::updateOrCreate([
                'id' => $sample->id,
            ],[
                'dilution_factor' => $dilutionFactor,                
            ]);

            //CALCULAMOS % fosforo = factor colorimetrico * factor de dilucion * absorbancia
            $FC = $sample->colorimetric_factor;
            $FD = $sample->dilution_factor;
            $A  = $sample->absorbance;

            //evaluamos si alguna de las variables anteriores es null,
            //si todas son variables calculamos el % de fosforo si no, no hacemos nada 
            if ($FC != null and $FD != null and $A != null and $FC > 0 and $FD > 0 and $A > 0) {
                //calculamos el fosforo 
                $phosphorous = $FC * $FD * $A; 
                //insertamos en la base de datos                 
                Presample::find($sample->id)->update(['phosphorous' => $phosphorous]);
            }
        }
    }


    public function downloadSamples()
    {
       
       return (new SamplesExport(['co' => $this->co], ['method' => $this->methode]))
       ->download('co-'.$this->co.'-cant-'.count($this->samples).'-method-'.$this->methode.'-'.Carbon::today().'.xlsx'); 
       
    }

    
    
}
