<?php

namespace App\Exports;

use App\Models\Iron;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class IronsExport implements FromView
{
    use Exportable;

    protected $co;
    
    protected $element;
    protected $methode;

    protected $quantity;

    public function __construct($co,$element,$methode,$quantity)
    {

        $this->co = $co['co'];
        
        $this->element = $element['element'];
        
        $this->methode = $methode['methode'];

        $this->quantity = $quantity['quantity'];
        
    }
    public function view(): View
    {     

        $samples = Iron::where('co', $this->co)->orderBy('id', 'ASC')->get();  
            
        return view('exports.IronsExport', [

        'co' => $this->co,
        'samples' => $samples,
        'element' => $this->element,
        'methode' => $this->methode,
        'quantity' => $this->quantity,
        'date' => Carbon::now()
        
        ]); 
        
    }
}