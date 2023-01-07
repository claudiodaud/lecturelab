<?php

namespace App\Exports;

use App\Models\Presample;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class SamplesExport implements FromView
{
    use Exportable;

    protected $co;
    
    protected $method;

    public function __construct($co,$method)
    {

        $this->co = $co['co'];
        
        $this->method = $method['method'];
        


    }
    public function view(): View
    {     

        $samples = Presample::where('co', $this->co)->where('method', $this->method)->orderBy('id', 'ASC')->get();  
            
        return view('exports.SamplesExport', [

        'samples' => $samples,
        
        ]); 
        
    }
}