<div>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Irons Module') }}
    </h2>
    </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">                
        


          {{--Component Table--}}

          <div class=" shadow-md sm:rounded-lg">
            <div class="p-4 ">
              <div class="block sm:flex sm:justify-between">
                <div wire:offline>
                    {{ __('You are now offline.') }}
                </div>


                @if(in_array("volumetries.find", $permissions))
                <div class="block sm:flex justify-start ">
                    
                    <div class="relative">
                  
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                  
                      <input type="text" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 py-4  sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60 
                      " 
                      placeholder="{{__('Search Your Control')}}" wire:model="co" wire:keydown.enter="getCo" autocomplete="off"  />
                  
                    </div>

                    @if($methods and $control)
                   
                    <select id="focus-geo-select" wire:model="methode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-4 py-3  sm:mx-0 mt-2 sm:mt-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60">
                            
                            <option value="0" selected>{{__('Select your method')}}</option>
                            
                        @foreach ($methods as $methodr)
                            
                            <option value="{{$methodr->GEO}}">{{$methodr->GEO}} - {{$methodr->ELEMENTO}}</option>
                            
                        @endforeach            
                    </select> 

                    @else
                    <div class="pt-4 pl-4 text-gray-300">
                       {{ __('This CO dont have methods')}} 
                    </div>                   
                    @endif 
                    
                        
                   
                    
                </div> 
                @endif
              
              
                <div class="flex sm:justify-end">
                    @if($samples and $control)
                       
                        @if(in_array("volumetries.upload", $permissions))
                        <a wire:click.prevent="showModalUpdate" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full py-3 sm:py-0 sm:mt-0 sm:ml-2 ml-1'>
                            {{__('Upload')}}
                            
                            <div class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            </div>
                        </a> 
                        @endif
                        @if(in_array("volumetries.download", $permissions))
                        <a wire:click="downloadSamples" type='button' class='inline-flex items-center bg-black px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition w-full py-3 sm:py-0 mt-2 sm:mt-0 sm:ml-2 ml-1 mr-4'>
                            {{__('Download')}}
                            
                            <div class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            </div>
                        </a> 
                        @endif
                    @endif

                        
                    
                </div>

                </div>

                <div class="pt-4">
                @if ($control == null and $this->co)
                    <div class="h4 text-sm text-gray-300 py-2" wire:loading >
                        <strong>{{ __('Wait a minute, Searching and synchronizing data...')}} </strong>
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
                           
                        </div>
                        
                    </div>
                @endif
                </div> 
            </div>
            <div class="mx-4">

              {{--Flash Messages--}}
              <x-jet-action-message class="pb-6" on="deleted">{{-- pendiente para deleted--}}
                <div class="text-xl font-normal  max-w-full flex-initial bg-red-100 p-4 my-4 rounded-lg border border-red-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-red-800 ">{{ __('Company register successfull deleted') }}</div>  
                </div>        
              </x-jet-action-message> 

              {{-- <x-jet-action-message class="" on="aliquot">
                <div class="text-xl font-normal  max-w-full flex-initial bg-fuchsia-100 p-4 my-4 rounded-lg border border-fuchsia-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-fuchsia-900 ">{{ __('Company register successfull force deleted') }}</div>  
                </div>        
              </x-jet-action-message> --}}

              <x-jet-action-message class="pb-6" on="updatedSamplesToPlusManager">
                <div class="text-xl font-normal  max-w-full flex-initial bg-blue-100 p-4 my-4 rounded-lg border border-blue-800 flex justify-start">
                  <div class="text-sm font-base px-4 text-blue-900 ">{{ __('Company register successfull restored') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="pb-6" on="success">
                <div class="text-xl font-normal  max-w-full flex-initial bg-green-100 p-4 rounded-lg border border-green-800 ">
                  <div class="text-sm font-base px-4 text-green-800 ">
                  {{ __('creating records, wait ...') }}</div>  
                </div>        
              </x-jet-action-message>  

              <x-jet-action-message class="pb-6" on="samples">
                <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
                  <div class="text-sm font-base px-4 text-indigo-800 ">
                  {{ __('Loading samples registers ...') }}</div>  
                </div>        
              </x-jet-action-message> 

              <x-jet-action-message class="pb-6" on="dontExits">
                <div class="text-xl font-normal  max-w-full flex-initial bg-red-100 p-4 rounded-lg border border-red-800 "> 
                  <div class="text-sm font-base px-4 text-green-800 ">
                  {{ __('Dont exists method GEO-644 for this CO') }}</div>  
                </div>        
              </x-jet-action-message> 

              {{--Table--}}

              @if($control and $samples) 
              
              <div class="relative overflow-x-auto">
                
                <livewire:irons.table />
              
              </div>
              @endif 
            </div>
            
          </div>

         
        
      </div>
    </div>
  </div>


 





  <!-- Confirmacion Update Modal -->
  <x-jet-dialog-modal wire:model="showUpdateModal"> 
      <x-slot name="title">
          {{ __('¿Do you really want to upload the information to plus manager?') }}
      </x-slot>

      <x-slot name="content">         
            <div wire:loading wire:target="updateSampleToPlusManager">
                <span class="mt-10"><strong>{{__('Loading files in Plus Manager, please wait a moment...')}}</strong></span>
            </div>
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('showUpdateModal')" wire:loading.attr="disabled" >
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="updateSampleToPlusManager" wire:loading.attr="disabled">
              {{ __('Update Samples To Plus Manager') }}
          </x-jet-danger-button>
          
      </x-slot>
  </x-jet-dialog-modal> 


 
  
    
<script>
    window.addEventListener('focus-iron-grade', event => {
        
        document.getElementById('iron-'+ event.detail.key).focus();
    })

   
</script>
</div>