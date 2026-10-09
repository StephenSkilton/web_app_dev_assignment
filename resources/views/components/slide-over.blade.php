@props(['name', 'title' => null])

<div x-data="{ show: false }"
     x-show="show"
     x-on:open-slide-over.window="if ($event.detail.name === '{{ $name }}') show = true"
     x-on:close-slide-over.window="show = false"
     x-on:keydown.escape.window="show = false"
     style="display: none;"
     class="fixed inset-0 z-50 overflow-hidden"
     role="dialog" 
     aria-modal="true">
    
    <div class="absolute inset-0 overflow-hidden">
        <!-- Backdrop Backdrop -->
        <div x-show="show" 
             x-transition:enter="ease-in-out duration-500" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in-out duration-500" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             x-on:click="show = false" 
             class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Panel container -->
        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="show" 
                 x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                 x-transition:enter-start="translate-x-full" 
                 x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                 x-transition:leave-start="translate-x-0" 
                 x-transition:leave-end="translate-x-full" 
                 class="pointer-events-auto w-screen max-w-md">
                
                <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                    <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-base font-semibold leading-6 text-gray-900">{{ $title }}</h2>
                            <div class="ml-3 flex h-7 items-center">
                              
   
                            </div>
                        </div>
                    </div>
                    <div class="relative mt-6 flex-1 px-4 sm:px-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
