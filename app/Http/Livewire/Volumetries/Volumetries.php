<?php

namespace App\Http\Livewire\Volumetries;

use App\Exports\VolumetriesExport;
use App\Models\Parameter;
use App\Models\Role;
use App\Models\User;
use App\Models\Volumetry;
use Carbon\Carbon;
use DB;
use Livewire\Component;

class Volumetries extends Component
{
    public $co;    
    public $samples;  
    public $control;
    public $codControl;
    public $coControl;
    public $cart;
    public $codCart;
    public $standart;
    public $methods;
    public $methode;
    public $element; 
    
    public $title; 
   
    //permissions
    public $permissions;

    //modal
    public $showUpdateModal;

    //close 
    public $close = false; 


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
                    $query = "SELECT CODCARTA, CERRADA FROM CARTA WHERE COD_CONTROL = $this->codControl";
                    $this->cart = DB::connection('sqlsrv')->select($query);
                    if ($this->cart) {
                        $this->codCart = $this->cart[0]->CODCARTA;
                        $this->close   = $this->cart[0]->CERRADA;

                        $this->getMethods();
                        
                    }
                }
                
            }
        }    
    }

    public function getMethods()
    {
        if ($this->codCart != null) {
            $query = "SELECT GEO, ELEMENTO FROM METODOSGEO WHERE CODCARTA = $this->codCart and (ELEMENTO LIKE '%Vol%' or ELEMENTO LIKE '%Fe DTT%') ";
            $this->methods = DB::connection('sqlsrv')->select($query);

           
            if ($this->coControl == $this->co and $this->codCart != null and $this->methode != 0) {

                $query = "SELECT ELEMENTO FROM METODOSGEO WHERE codcarta = $this->codCart AND  GEO = '".$this->methode."' ";
                $method = DB::connection('sqlsrv')->select($query);
               
                    $this->element = $method[0]->ELEMENTO;

                    $query = "SELECT numero, muestra, peso FROM pesajevolumen WHERE codcarta = $this->codCart AND  METODO = '".$this->methode."' ";      
                    $this->samples = DB::connection('sqlsrv')->select($query);
                    
                    if ($this->samples) {
                        $this->syncSamples();
                    }
    

            }else{

                    $this->emit('change_params',[
                    'co' => null,
                    'coControl' => null,
                    'methode' => null,
                    'codCart' => null,
                    'standart' => null,
                    'title' => null,
                    ]);
                    
                    $this->emit('render');

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


    public function saveTitle()
    {
        if ($this->title == null) {
            
        }else{

            Parameter::where('control', 'volumetries')->where('type_var', 'title')->update(['value' => $this->title]);
        }

        $this->emit('success');          
           
    }

    public function applyTitle()
    {
        if ($this->title == null) {
            
        }else{

            $this->saveTitle();

            Volumetry::where('co',$this->co)->where('method', $this->methode)->update(['title' => $this->title]);

            $this->emit('change_params',[
                    'co' => $this->co,
                    'coControl' => $this->coControl,
                    'methode' => $this->methode,
                    'codCart' => $this->codCart,
                    'standart' => $this->standart,
                    'title' => $this->title,
                    ]);
            
            
        }

        $this->emit('success');          
           
    }

    public function updatedMethode()
    {
        if ($this->methode != 0) {

            $standart = DB::connection('sqlsrv')->select('SELECT standart FROM standar_co WHERE co = ? and metodo = ?',[$this->co, $this->methode]);
                $this->standart = $standart[0]->standart ?? null;

            $LdeD = DB::connection('sqlsrv')->select('SELECT LdeD FROM anmuestra WHERE cod_control = ? and analisis = ?',[$this->codControl, $this->methode]);
                $this->LdeD = $LdeD[0]->LdeD ?? null;

            $this->emit('change_params',[
                    'co' => $this->co,
                    'coControl' => $this->coControl,
                    'methode' => $this->methode,
                    'codCart' => $this->codCart,
                    'standart' => $this->standart,
                    'title' => $this->title,
                    ]);
            $this->emit('render');
        }

        if ($this->methode == 0) {
            $this->emit('methode');
        }   

    }

    public function downloadSamples()
    {
       
       return (new VolumetriesExport(['co' => $this->co], ['method' => $this->methode], ['quantity' => count($this->samples)]))
       ->download('co-'.$this->co.'-cant-'.count($this->samples).'-method-'.$this->methode.'-'.Carbon::today().'.xlsx'); 
       
    }

    public function showModalUpdate()
    {
        $this->showUpdateModal = true;
    }


    public function updateSampleToPlusManager()
    {
        // buscamos las muestras por los parametros establecidos y solo subiremos las que tengan ley filtrando por la insersion del parametro de absorbance y por el calculo de la ley de fosforo  
        $samples = Volumetry::where('co',$this->co)                            
                            ->where('cod_carta', $this->codCart)
                            ->where('method', $this->methode)
                            ->where('grade','>=',0)
                            ->where('grade','!=',null)
                            ->get();
        
        // element encontrar crear query o sacar de method
        // LdeD = buscar limite de deteccion de standart 

        // capturamos la fecha del disparador                     
        $now = Carbon::now();  

        //capturamos las variables que no cambiaran durante el update 
        $CODCARTA        = $this->codCart;
        $CO              = $this->co;    
        $RESULTADO       = null;     
        $METODO          = $this->methode;
        $UNIDAD1         = '%';
        $UNIDAD2         = '%';
        $LdeD            = $this->LdeD;
        $LEIDOPOR        = auth()->user()->name;
        $FECHAHORA       = $now;        
        $volumen         = null; 

        //dd(number_format($this->LdeD,3));
        
        $provisorio      = 'SI';        
        $Oculta          = 0;
        $FechaCreacion   = $now;             

        foreach($samples as $sample){
            

            $validate = DB::connection('sqlsrv')
                        ->select('SELECT NUMERO FROM AAS400 WHERE CO = ? and METODO = ? and NUMERO = ?',
                            [$this->co,$this->methode,$sample->number]);
            if ($validate) {

                //dd('aqui');
                //variables dinamicas que dependen de la muestra
                $grade = round($sample->grade,3); // two parameters is long of LdeD 
                $writtenBy = User::where('id',$sample->written_by)->first('name');
                    
                //
                    $NUMERO          = $sample->number;
                    $MUESTRA         = $sample->name;            
                    $RESULTADOREAL   = number_format($sample->grade,3, ",", ".");
                    $ELEMENTO        = $sample->element; 
                    if ($grade <= $this->LdeD) {
                        $Ley= '<'.number_format($this->LdeD,3, ",", ".");           
                    }elseif($grade > $this->LdeD){
                        $Ley= number_format($grade ,3, ",", "."); 
                    }           
                               
                    $peso            = $sample->weight;
                    $dilucion        = null;

                    if ($sample->name == 'STD') {
                         $estandar = $this->standart;
                    }else{
                        $estandar = null;
                    }           
                    
                    if ($writtenBy) {
                        $modificadopor   = $writtenBy->name;                
                    }else{
                        $modificadopor   = null;
                    }
                
                

                // las actualizamos ;)
                DB::connection('sqlsrv')->update('UPDATE AAS400 
                            SET 
                            CODCARTA        = ?, 
                            CO              = ?,
                            NUMERO          = ?,
                            MUESTRA         = ?,
                            RESULTADO       = ?,
                            RESULTADOREAL   = ?,
                            ELEMENTO        = ?, 
                            METODO          = ?,
                            UNIDAD1         = ?,
                            UNIDAD2         = ?,
                            LdeD            = ?,
                            LEIDOPOR        = ?,
                            FECHAHORA       = ?,
                            Ley             = ?,
                            volumen         = ?,
                            peso            = ?,
                            dilucion        = ?,
                            estandar        = ?,
                            provisorio      = ?,
                            modificadopor   = ?,
                            Oculta          = ?,
                            FechaCreacion   = ?
                            WHERE 
                            CO = ? and 
                            METODO = ? And  
                            NUMERO = ? 
                            '
                            ,[
                                
                                $CODCARTA,
                                $CO,
                                $NUMERO,
                                $MUESTRA,
                                $RESULTADO,
                                $RESULTADOREAL,
                                $ELEMENTO, 
                                $METODO,
                                $UNIDAD1,
                                $UNIDAD2,
                                $LdeD,
                                $LEIDOPOR,
                                $FECHAHORA,
                                $Ley,
                                $volumen,
                                $peso,
                                $dilucion,
                                $estandar,
                                $provisorio,
                                $modificadopor,
                                $Oculta,
                                $FechaCreacion,
                                $CO,
                                $METODO,
                                $NUMERO,
                                
                                
                                                    
                             
                            ]); 

                


                Volumetry::find($sample->id)->update(['updated_by' => auth()->user()->id , 'updated_date' => date_format(now(),"Y/m/d H:i:s")]);

            }else{
       
                 
                //creamos las muestras ;)
                DB::connection('sqlsrv')
                ->insert('INSERT INTO AAS400 (CO,METODO,NUMERO) VALUES (?,?,?)',
                    [$this->co,$this->methode,$sample->number]);

                //variables dinamicas que dependen de la muestra
                $grade = round($sample->grade,3); // two parameters is long of LdeD 
                $writtenBy = User::where('id',$sample->written_by)->first('name');
                    
                //
                    $NUMERO          = $sample->number;
                    $MUESTRA         = $sample->name;            
                    $RESULTADOREAL   = number_format($sample->grade,3, ",", ".");
                    $ELEMENTO        = $sample->element; 
                    if ($grade <= $this->LdeD) {
                        $Ley= '<'.number_format($this->LdeD,3, ",", ".");           
                    }elseif($grade > $this->LdeD){
                        $Ley= number_format($grade ,3, ",", "."); 
                    }         
                               
                    $peso            = $sample->weight;
                    $dilucion        = null;

                    if ($sample->name == 'STD') {
                         $estandar = $this->standart;
                    }else{
                        $estandar = null;
                    }           
                    
                    if ($writtenBy) {
                        $modificadopor   = $writtenBy->name;                
                    }else{
                        $modificadopor   = null;
                    }
                
                

                // las actualizamos ;)
                DB::connection('sqlsrv')->update('UPDATE AAS400 
                            SET 
                            CODCARTA        = ?, 
                            CO              = ?,
                            NUMERO          = ?,
                            MUESTRA         = ?,
                            RESULTADO       = ?,
                            RESULTADOREAL   = ?,
                            ELEMENTO        = ?, 
                            METODO          = ?,
                            UNIDAD1         = ?,
                            UNIDAD2         = ?,
                            LdeD            = ?,
                            LEIDOPOR        = ?,
                            FECHAHORA       = ?,
                            Ley             = ?,
                            volumen         = ?,
                            peso            = ?,
                            dilucion        = ?,
                            estandar        = ?,
                            provisorio      = ?,
                            modificadopor   = ?,
                            Oculta          = ?,
                            FechaCreacion   = ?
                            WHERE 
                            CO = ? and 
                            METODO = ? And  
                            NUMERO = ? 
                            '
                            ,[
                                
                                $CODCARTA,
                                $CO,
                                $NUMERO,
                                $MUESTRA,
                                $RESULTADO,
                                $RESULTADOREAL,
                                $ELEMENTO, 
                                $METODO,
                                $UNIDAD1,
                                $UNIDAD2,
                                $LdeD,
                                $LEIDOPOR,
                                $FECHAHORA,
                                $Ley,
                                $volumen,
                                $peso,
                                $dilucion,
                                $estandar,
                                $provisorio,
                                $modificadopor,
                                $Oculta,
                                $FechaCreacion,
                                $CO,
                                $METODO,
                                $NUMERO,
                                
                                
                                                    
                             
                            ]); 

                


                Volumetry::find($sample->id)->update(['updated_by' => auth()->user()->id , 'updated_date' => date_format(now(),"Y/m/d H:i:s")]);
            }
        }
            
        $this->showUpdateModal = false;
        $this->emit('updatedSamplesToPlusManager');
        $this->emit('change_params',[
                    'co' => $this->co,
                    'coControl' => $this->coControl,
                    'methode' => $this->methode,
                    'codCart' => $this->codCart,
                    'standart' => $this->standart,
                    'title' => $this->title,
                    ]);
    }
    


}
