<div>
    <x-jet-action-message class="" on="update">
      <div class="text-xl font-normal  max-w-full flex-initial bg-indigo-100 p-4 my-4 rounded-lg border border-indigo-800 ">
        <div class="text-sm font-base px-4 text-indigo-800 ">
        {{ __('Update comparative samples registers and sync...') }}</div>  
      </div>        
    </x-jet-action-message>
    
    @if($registers)
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                   
                    <th scope="col" class="px-6 py-3 w-max rounded-tl-lg rounded-bl-lg">
                      {{ __('Number')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Name')}}
                    </th>                    
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Weight')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Spent')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max">
                      {{ __('Grade')}}
                    </th>
                    <th scope="col" class="px-6 py-2 w-max rounded-tr-lg rounded-br-lg">
                      {{ __('Title')}}
                    </th>                   
                    
                  </tr>
                </thead>
                <tbody>
                  {{--dd($registers)--}}
                  @forelse ($registers as $key => $register)
                    <tr class="bg-white border-b hover:bg-gray-100 even:bg-gray-50">
                    <td class="px-6 py-2 w-max">

                      {{$register->number}}
                    </td>
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      @if($register->name == "STD")
                        {{$register->name}} - {{$this->standart}}
                      @else
                        {{$register->name}}
                      @endif
                    </td>

                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{round($register->weight,5)}}
                    </td>

                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                       
                        
                        @if($key !== $keyIdSpent)  
                            @if(in_array("volumetries.spent", $permissions)) {{--actualizar el permiso a irons.grade--}}
                              <div class="cursor-pointer"                            
                              wire:click.prevent="$set('keyIdSpent',{{$key}})">
                              {{$register->spent}} <i class="fa-solid fa-pen fa-2xs pl-4"></i>
                              </div>
                            @else
                              <div>                            
                              {{$register->spent}} <i class="fa-solid fa-pen fa-2xs pl-4"></i>
                              </div>                            
                            @endif
                            

                        @elseif($editSpent === true and $key === $keyIdSpent)
                        <div class="flex justify-center w-32">
                        <input type="text" id="spent-{{$key}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ml-2 pl-4 py-0.5 sm:mx-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 my-1 w-32 sm:w-32 focus autofocus" placeholder="{{$register->spent}}" value="{{$register->spent}}" 
                            wire:model="spentField"
                            wire:keydown.enter="updateSpent({{$register->id}})" 
                            wire:keydown.arrow-up="$set('keyIdSpent',{{$keyIdSpent - 1 }})"
                            wire:keydown.arrow-down="$set('keyIdSpent',{{$keyIdSpent + 1 }})"
                            autofocus="autofocus" wire:key="spentField-{{$key}}">

                        <a href="" class="pt-2" wire:click.prevent="closeSpent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="00 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        </div>
                        @endif

                    </td>
                    
                    
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">                     
                       {{round($register->grade,3)}}
                    </td>

                    
                    
                    <td scope="row" class="px-6 py-2 font-medium text-gray-900 dark:text-white whitespace-nowrap truncate ... w-max">
                      {{ round($register->title,3)}}
                    </td>
                    
                  </tr> 
                  @empty
                    {{-- empty expr --}}
                  @endforelse
                  
                  
                </tbody>
              </table>
    
    @endif

   {{--  <!-- Confirmacion Update Modal -->
  <x-jet-dialog-modal wire:model="showComparativeModal"> 
      <x-slot name="title">
          {{ __('¿Do you really want to upload the information to plus manager?') }}
      </x-slot>

      <x-slot name="content"> 

            <div>
                @if($methodsRegisters and $coControl)

                <select id="focus-geo-select" wire:model="methodeComparative" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-4 py-3  sm:mx-0 mt-2 sm:mt-0 sm:mr-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full sm:w-60">
                        
                        <option value="0" selected>{{__('Select your method')}}</option>
                        
                    @foreach ($methodsRegisters as $methodr)

                      @if($methodr->GEO == $methode)

                      @else
                         <option value="{{$methodr->GEO}}">{{$methodr->GEO}}</option>
                      @endif
                        
                        
                        
                    @endforeach            
                </select> 

                @else
                <div class="pt-4 pl-4 text-gray-300">
                   {{ __('This CO dont have methods')}} 
                </div>                   
                @endif
            </div>        
            
         
      </x-slot>

      <x-slot name="footer">
          <x-jet-secondary-button wire:click="$toggle('showComparativeModal')" wire:loading.attr="disabled">
              {{ __('Cancel') }}
          </x-jet-secondary-button>

          <x-jet-danger-button class="ml-3" wire:click="updateGeoComparative()" wire:loading.attr="disabled">
              {{ __('Update Comparative Data') }}
          </x-jet-danger-button>
          
      </x-slot>
  </x-jet-dialog-modal> --}}
    
</div>