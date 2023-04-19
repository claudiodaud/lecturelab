<?php

namespace App\Http\Livewire\Volumetries;

use App\Models\Parameter;
use App\Models\Role;
use App\Models\User;
use App\Models\Volumetry;
use DB;
use Livewire\Component;

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
    public $methode = null;
    public $element; 
    
    public $title; 
   
    //permissions
    public $permissions;

    //modal
    public $showUpdateModal;


    public function mount()
    {
        
        $this->getPermissions();

        $this->getParameters();
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

    public function updatingCo()
    {
        if ($this->coControl != strval($this->co)) {
            
            $this->samples= null;  
            $this->control= null;
            $this->codControl= null;
            $this->coControl= null;
            $this->cart= null;
            $this->codCart= null;
            
            $this->methods= null;
            $this->methode= null;
        }

        if ($this->coControl != strval($this->co) and $this->methode == null) {
          $this->dispatchBrowserEvent('focus-geo-select');  
        }

        $this->getParameters();           
        
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

                $query = "SELECT ELEMENTO FROM METODOSGEO WHERE codcarta = $this->codCart AND  GEO = '".$this->methode."' ";
                $method = DB::connection('sqlsrv')->select($query);
                $this->element = $method[0]->ELEMENTO;

                $query = "SELECT numero, muestra, peso FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = '".$this->methode."' ";      
                $this->samples = DB::connection('sqlsrv')->select($query);
                
                if ($this->samples) {
                    $this->syncSamples();
                }

                                      

            }

        }
    }

    public function syncSamples()
    {
        // traer el array de muestras en mysql y revisar que exista en el array de sqlserver si existe, no hago nada, si no existe lo elimino de mysql, significaria que la muestra fue eliminada.
        //traemos las muestras 
        $samplesMySQL = DB::table('volumetries')->where('co', $this->co)->where('method', $this->methode)->where('cod_carta', $this->codCart)->get('number');
        
        $arrayMySQL = [];

        $arraySQLServer = [];
        
        foreach ($samplesMySQL as $key => $sample) {
            array_push($arrayMySQL, $sample->number);
        }   

        foreach ($this->samples as $key => $sample) {
            array_push($arraySQLServer, $sample->numero);
        }


        //dd([$arrayMySQL,$arraySQLServer]);    

        $diffArrayToDelete = array_diff($arrayMySQL, $arraySQLServer);    
        $diffArrayToCreate = array_diff($arraySQLServer, $arrayMySQL);   
        $diffArrayToUpdate = array_intersect($arraySQLServer, $arrayMySQL);      
        
        //dd([$diffArrayToDelete, $diffArrayToCreate, $diffArrayToUpdate]);    
        // para eliminar 
        foreach ($diffArrayToDelete as $key => $r) {
            
            Volumetry::where('co',$this->co)
                    ->where('method',$this->methode)
                    ->where('cod_carta', $this->codCart)
                    ->where('number',$r)->forceDelete();        
        }

        // para crear     
        foreach ($diffArrayToCreate as $key => $r) {
            
            $query = "SELECT numero, muestra, peso  FROM pesajevolumen WHERE codcarta = $this->codCart and numero = $r AND  METODO = '".$this->methode."' ";      
                $sample = DB::connection('sqlsrv')->select($query);
            
            

            Volumetry::create([ 
                    
                'co' => $this->co,    
                'cod_carta' => $this->codCart, 
                'method' => $this->methode,  
                'element' => $this->element,  
                'number' => $sample[0]->numero,
                'name' => $sample[0]->muestra,
                'weight' => $sample[0]->peso,                            
                
                'spent' => null,
                'grade' => null,
                'title' => null,
                
            ]);         
        }

        // para actualizar 
        //asignamos las muestras a una tabla momentanea para analizar manipular la informacion.     
        // foreach ($this->samples as $key => $sample) {    
            
        //     // VOY A BUSCAR LA MUeSTRA, LA TRAIGO, SI EXISTE ACTUALIZO EL PESO Y RECALCULO LOS VALORES EN BASE A LOS VALORES GUARDADOS INICIALES  
        //     $samplex = Presample::where('co',$this->co)
        //             ->where('method',$this->methode)
        //             ->where('cod_carta', $this->codCart)
        //             ->where('number',$sample->numero)->first();
            
        //     //guardamos el peso 
        //     $samplex->weight = $sample->peso;
        //     $samplex->save();

            
                
        //     // ACTUALIZAMOS LOS CALCULOS BASADOS EN EL PESO del resgitro traido desde plusmanager
        //     if($sample->peso == 0 or $samplex->aliquot == 0){
        //         $dilutionFactor = 0; 
        //     }else{                        
        //         $dilutionFactor = (1/(($sample->peso/250)*($samplex->aliquot/100)))/1000;
        //     }    
            
        //     $FC = $samplex->colorimetric_factor;
        //     $FD = $dilutionFactor;
        //     $A  = $samplex->absorbance;

        //     if ($FC == 0 or $FD == 0 or $A == 0) {
        //         $phosphorous = 0;
        //     }else{
        //         $phosphorous = $FC * $FD * $A;   
        //     }    

        //     //guardamos el nombre, peso y los recalculos.
        //     $samplex->name = $sample->muestra;                      
        //     $samplex->weight = $sample->peso;                           
        //     $samplex->absorbance = $samplex->absorbance;
        //     $samplex->aliquot = $samplex->aliquot;
        //     $samplex->colorimetric_factor = $samplex->colorimetric_factor;
        //     $samplex->dilution_factor = $dilutionFactor;
        //     $samplex->phosphorous = $phosphorous;
        //     $samplex->save();

                
                       
        

        // }       

                  
        
     
    }

    public function getParameters()
    {
        $title = DB::table('parameters')->where('control', 'volumetries')->where('type_var', 'title')->first('value');

        $this->title = $title->value ?? 0;
         
    }


    public function applyTitle()
    {
        if ($this->title == null) {
            
        }else{

            Parameter::where('control', 'volumetries')->where('type_var', 'title')->update(['value' => $this->title]);
        }

        $this->emit('success');          
           
    }

    public function updatedMethode()
    {

        $standart = DB::connection('sqlsrv')->select('SELECT standart FROM standar_co WHERE co = ? and metodo = ?',[$this->co, $this->methode]);
            $this->standart = $standart[0]->standart;

        $LdeD = DB::connection('sqlsrv')->select('SELECT LdeD FROM anmuestra WHERE cod_control = ? and analisis = ?',[$this->codControl, $this->methode]);
            $this->LdeD = $LdeD[0]->LdeD ?? null;

        $this->emit('change_params',[
                'co' => $this->co,
                'coControl' => $this->coControl,
                'methode' => $this->methode,
                'codCart' => $this->codCart,
                'standart' => $this->standart,
                ]);
    }

}
