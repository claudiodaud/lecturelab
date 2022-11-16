<div>
   
    <div class="flex justify-start">                                 
        <div class="h4 text-sm text-gray-500 mt-2 mr-4 w-32">{{ __('Aliquot')}} :
            
        </div>
        
        <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-14 sm:w-14" placeholder="{{__('Insert value')}}" wire:model="aliquot">    
        <span wire:click.prevent="applyAliquot" class="rounded rounded-lg bg-black text-center text-sm text-white py-0.5 my-1 px-2 hover:bg-gray-700 focus:bg-gray-700 cursor-pointer">{{__('Apply')}}</span>                       
    </div>
    <div class="flex justify-start"> 
        <div class="h4 text-sm text-gray-500 mt-2 mr-4 w-32">{{ __('Colorimetric Factor')}} :
            
        </div>
        <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32" placeholder="{{__('Insert value')}}" wire:model="colorimetricFactor">
        <span wire:click.prevent="applyColorimetric" class="rounded rounded-lg bg-black text-center text-sm text-white py-0.5 my-1 px-2 hover:bg-gray-700 focus:bg-gray-700 cursor-pointer">{{__('Apply')}}</span>
    </div>
    <div class="flex justify-start"> 
        <div class="h4 text-sm text-gray-500 mt-2 mr-4 w-32">{{ __('Absorbance')}} :
            
        </div>
        <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-14 sm:w-14" placeholder="{{__('Insert value')}}" wire:model="absorbance">
        <span wire:click.prevent="applyAbsorbance" class="rounded rounded-lg bg-black text-center text-sm text-white py-0.5 my-1 px-2 hover:bg-gray-700 focus:bg-gray-700 cursor-pointer">{{__('Apply')}}</span>
    </div>
                        
</div>
