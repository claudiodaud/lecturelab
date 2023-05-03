<?php

namespace App\Exports;

use App\Models\Volumetry;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class VolumetriesExport implements FromView
{
    use Exportable;

    protected $co;
    
    protected $method;

    protected $quantity;

    public function __construct($co,$method,$quantity)
    {

        $this->co = $co['co'];
        
        $this->method = $method['method'];

        $this->quantity = $quantity['quantity'];
        
    }
    public function view(): View
    {     

        $samples = Volumetry::where('co', $this->co)->where('method', $this->method)->orderBy('id', 'ASC')->get();  
            
        return view('exports.VolumetriesExport', [

        'co' => $this->co,
        'method' => $this->method,
        'samples' => $samples,
        'quantity' => $this->quantity,
        'date' => Carbon::now()
        
        ]); 
        
    }
}