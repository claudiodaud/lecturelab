<div>
    
      <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Phosphorous Module') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                
        


          {{--Component Table--}}

          <div class=" shadow-md sm:rounded-lg">
            <div class="p-4 ">
              <div class="block sm:flex sm:justify-between">
                @if(in_array("phosphorous.find", $permissions))
                <div class="block sm:flex justify-start ">
                    
                    <div class="relative">
                  
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                  
                      <input type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 py-4  sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60" placeholder="{{__('Search Your Control')}}" wire:model="co" wire:keydown.enter="getCo" autocomplete="off">
                  
                    </div>
                    
                   
                    @if($methodsRegisters and $control)
                   
                    <select id="focus-geo-select" wire:model="methode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-4 py-3  sm:mx-0 mt-2 sm:mt-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60">
                            
                            <option value="null" selected>{{__('Select your method')}}</option>
                            
                        @foreach ($methodsRegisters as $methodr)
                            
                            <option value="{{$methodr->GEO}}">{{$methodr->GEO}}</option>
                            
                        @endforeach            
                    </select> 

                    
                    
                    @endif 
                    
                </div> 
                @endif
              
              
                <div class="flex sm:justify-end">
                    @if($samples)
                        @if(in_array("phosphorous.upload", $permissions))
                        <a wire:click="UploadSamples" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full py-3 sm:py-0 sm:mt-0 sm:ml-2 ml-1'>
                            {{__('Download')}}
                            <div class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            </div>
                        </a> 
                        @endif
                        @if(in_array("phosphorous.download", $permissions))
                        <a wire:click="downloadSamples" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full py-3 sm:py-0 mt-2 sm:mt-0 sm:ml-2 ml-1 mr-4'>
                            {{__('Upload')}}
                            <div class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </div>
                        </a> 
                        @endif
                    @endif
                    <a wire:click.prevent="info" class="focus:ring-blue-500 focus:border-blue-500 block ml-2 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-pointer mt-2">  
                        
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    </a>
                </div>

                </div>

                <div class="pt-4">
                @if ($control == null and $this->co)
                    <div class="h4 text-sm text-gray-500 py-2">
                        <strong>{{ __('no records found!')}} </strong>
                    </div>
                @endif    

                @if ($control)
                    <div class="block sm:flex sm:justify-between ">
                        <div>
                            
                                
                            
                                <div class="h4 text-sm text-gray-500 py-2">{{ __('CO')}} : <strong>{{$control[0]->CODIGO}} </strong> 
                                    
                                </div>
                                <div class="h4 text-sm text-gray-500 py-2">{{ __('Customer')}} : <strong>{{$control[0]->CLIENTE}} </strong>
                                </div>
                            
                            
                            @if ($samples)
                                <div class="h4 text-sm text-gray-500 py-2">{{ __('Quantity')}} :<strong> {{count($samples)
                                }} </strong></div>
                            @endif
                            
                        </div>
                        <div>
                            @if ($samples)
                                @if(in_array("phosphorous.parameters", $permissions))
                                <div>
                                    <div class="flex justify-start"> 
                                        <div class="h4 text-sm text-gray-500 mt-2 mr-4 w-32">{{ __('Absorbance')}} :
                                            
                                        </div>
                                        <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-16 sm:w-16" placeholder="{{__('Insert value')}}" wire:model="absorbance">
                                        <span wire:click.prevent="applyAbsorbance" class="rounded rounded-lg bg-black text-center text-sm text-white py-0.5 my-1 px-2 hover:bg-gray-700 focus:bg-gray-700 cursor-pointer">{{__('Apply')}}</span>
                                    </div>
   
                                    <div class="flex justify-start">                                 
                                        <div class="h4 text-sm text-gray-500 mt-2 mr-4 w-32">{{ __('Aliquot')}} :
                                            
                                        </div>
                                        
                                        <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-16 sm:w-16" placeholder="{{__('Insert value')}}" wire:model="aliquot">    
                                        <span wire:click.prevent="applyAliquot" wire:loading.attr="disabled" class="rounded rounded-lg bg-black text-center text-sm text-white py-0.5 my-1 px-2 hover:bg-gray-700 focus:bg-gray-700 cursor-pointer disabled:bg-gray-400 disabled:border-blue-500 ">{{__('Apply')}}</span> 

                                                             
                                    </div>
                                    <div class="flex justify-start"> 
                                        <div class="h4 text-sm text-gray-500 mt-2 mr-4 w-32">{{ __('Colorimetric Factor')}} :
                                            
                                        </div>
                                        <input type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32" placeholder="{{__('Insert value')}}" wire:model="colorimetricFactor">
                                        <span wire:click.prevent="applyColorimetric" class="rounded rounded-lg bg-black text-center text-sm text-white py-0.5 my-1 px-2 hover:bg-gray-700 focus:bg-gray-700 cursor-pointer">{{__('Apply')}}</span>
                                    </div>
                                    
                                                        
                                </div>
                                @endif
                            @endif
                            
                            
                        </div>
                    </div>
                @endif
                </div> 
            </div>
            <div class="mx-4">

              {{--Flash Messages--}}
              <x-jet-action-message class="" on="deleted">{{-- pendiente para deleted--}}
                <div class="text-xl font-normal  max-w-full flex-initial bg-red-100 p-4 my-4 rounded-lg border border-red-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-red-800 ">{{ __('Company register successfull deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              {{-- <x-jet-action-message class="" on="aliquot">
                <div class="text-xl font-normal  max-w-full flex-initial bg-fuchsia-100 p-4 my-4 rounded-lg border border-fuchsia-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-fuchsia-900 ">{{ __('Company register successfull force deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="" on="colorimetricFactor">
                <div class="text-xl font-normal  max-w-full flex-initial bg-blue-100 p-4 my-4 rounded-lg border border-blue-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-blue-900 ">{{ __('Company register successfull restored') }}</div>  
                </div>        
              </x-jet-action-message>  --}}

              <x-jet-action-message class="" on="success">
                <div class="text-xl font-normal  max-w-full flex-initial bg-green-100 p-4 my-4 rounded-lg border border-green-800 ">
                  <div class="text-sm font-base px-4 text-green-800 ">
                  {{ __('Records changed successfully!') }}</div>  
                </div>        
              </x-jet-action-message>  

              <x-jet-action-message class="" on="methode">
                <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
                  <div class="text-sm font-base px-4 text-indigo-800 ">
                  {{ __('Loading method registers ...') }}</div>  
                </div>        
              </x-jet-action-message> 

              {{--Table--}}

              @if($samples != null   and $control and $samples)
              
              <div class="relative overflow-x-auto">
                
                <livewire:lectures.table />
              
              </div>
              @endif
            </div>
            
          </div>

         
        
      </div>
    </div>
  </div>


 



  <!-- Info Company Modal -->
  <x-jet-dialog-modal wire:model="info"> 
      <x-slot name="title">
          {{ __('Update Company Account Data') }}
      </x-slot>

      <x-slot name="content">
          
        <div class="col-span-6 sm:col-span-4 py-2">
            <x-jet-label for="name" value="{{ __('Social name') }}" />
            <x-jet-input  class="block mt-1 w-full" type="text"  required autofocus wire:model="social_name"/>
            <x-jet-input-error for="social_name" class="mt-2" />
        </div>   
        
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('editCompany')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="updateCompany" wire:loading.attr="disabled">
              {{ __('Update Company Account Data') }}
          </x-jet-danger-button>
      </x-slot>
  </x-jet-dialog-modal> 


 
  
    
<script>
    window.addEventListener('focus-aliquot', event => {
        
        document.getElementById('aliquot-'+ event.detail.key).focus();
    })

    window.addEventListener('focus-colorimetric', event => {
        
        document.getElementById('colorimetric-'+ event.detail.key).focus();
    })

    window.addEventListener('focus-absorbance', event => {
        
        document.getElementById('absorbance-'+ event.detail.key).focus();
    })

    window.addEventListener('focus-geo-select', event => {
        
        document.getElementById('focus-geo-select').focus();
    })
</script>
    

   

</div>


