@if(Auth::user())




   <!-- Right Sidebar -->
   <div
        x-show="$store.global.isRightSidebarExpanded"
        @keydown.window.escape="$store.global.isRightSidebarExpanded = false"
      >
        <div
          class="fixed inset-0 z-[150] bg-slate-900/60 transition-opacity duration-200"
          @click="$store.global.isRightSidebarExpanded = false"
          x-show="$store.global.isRightSidebarExpanded"
          x-transition:enter="ease-out"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="ease-in"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        ></div>
        <div class="fixed right-0 top-0 z-[151] h-full w-full sm:w-80">
          <div
            x-data="{activeTab:'tabHome'}"
            class="relative flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-750"
            x-show="$store.global.isRightSidebarExpanded"
            x-transition:enter="ease-out"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="ease-in"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
          >
            <div class="flex items-center justify-between py-2 px-4">
              <p
                x-show="activeTab === 'tabHome'"
                class="flex shrink-0 items-center space-x-1.5"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
                <span class="text-xs">Recent Activities</span>
              </p>
            

           
            </div>

            <div
              x-show="activeTab === 'tabHome'"
              x-transition:enter="transition-all duration-500 easy-in-out"
              x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
              x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              class="is-scrollbar-hidden overflow-y-auto overscroll-contain pt-1"
            >
        
              <div class="mt-3">
                <h2
                  class="px-3 text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100"
                >
                  Recent Used Tools
                </h2>
                <div
                  class="swiper mt-3 px-3"
                  x-init="$nextTick(()=>new Swiper($el,{  slidesPerView: 'auto', spaceBetween: 16,autoplay: {delay: 2000}}))"
                >
                  
                <div class="swiper-wrapper">
                  @if (Session::get('recenttool')->count() > 0)
<style>
  .df{
    display: flex;
    justify-content: space-between;
  }
</style>
                    @foreach (Session::get('recenttool') as $tool)

                    
                    <div
                      class="swiper-slide relative flex h-28 flex-col  rounded-xl  p-3"
                    >
                    <div class="card border border-slate-150 px-4 py-4 shadow-none hover:bg-slate-100 dark:hover:bg-navy-600 dark:border-navy-600 sm:px-5 text-center">
                        <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}">
            <div class="text-left df">
              <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
              <i class="an-duotone an-{{ $tool->icon_class }} mr-2"  ></i>
              </h2>
              <div class="badge bg-success/10 h-5 text-success dark:bg-success/15">{{ $tool->used_count }}</div>
            </div>
            <div class="text-left">
              <p class="pt-2">
              {{ $tool->name }}
              </p>
              
            </div>
            </a>
          </div>
                    </div>
                  
                
                    @endforeach
 @else

      
 <div
                      class="swiper-slide relative flex h-28 flex-col  rounded-xl  p-3"
                    >
                    <div class="card border border-slate-150 px-4 py-4 shadow-none hover:bg-slate-100 dark:hover:bg-navy-600 dark:border-navy-600 sm:px-5 text-center">
                        <a href="#">
           
            <div class="text-left">
              <p class="pt-2">
             No Recent Tools Found
              </p>
              
            </div>
            </a>
          </div>
                    </div>
                  
@endif
</div>
                </div>
              </div>

              <div class="mt-4 px-3">
                <h2
                  class="text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100"
                >
                  Pinned Tools
                </h2>
                <div class="mt-3 flex space-x-3">
                    
                     @php
    $favourites = Auth::check() ? Auth::user()->favorite_tools : null;
@endphp
@if ($favourites && $favourites->count() > 0)

                    @foreach ($favourites as $tool)

              <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}" class="w-12 text-center">
                    <div class="avatar h-10 w-10">
                      <div
                        class="is-initial mask is-squircle"
                      >
                         @if ($tool->icon_type == 'class')
                                <i class="an-duotone an-{{ $tool->icon_class }} "></i>
                            @elseif ($tool->getFirstMediaUrl('tool-icon'))
                                <img src="{{ $tool->getFirstMediaUrl('tool-icon') }}" alt="{{ $tool->name }}">
                            @endif
                      </div>
                    </div>
                    <p
                      class="mt-1.5 overflow-hidden text-ellipsis whitespace-nowrap text-xs text-slate-700 dark:text-navy-100"
                    >
                     {{ $tool->name }}
                    </p>
                  </a>
                     
                    @endforeach
 
@endif

                 
                 
                </div>
              </div>


             

              <div class="mt-4">
                <h2
                  class="px-3 text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100"
                >
                  Recent Reports
                </h2>
                <div class="mt-3 space-y-3 px-2 max-h-64 overflow-y-auto scrollbar-sm">
                    
                     @if (Session::get('reports')->count() > 0)

                    @foreach (Session::get('reports') as $report)

                <div class="flex justify-between space-x-2 rounded-lg bg-slate-100 p-2.5 dark:bg-navy-700"
                  >
                    <div class="flex flex-1 flex-col justify-between">
                      <div class="line-clamp-2 overflow-x-hidden max-w-44">
                       <form action="{{ route('files.show', ['filename' => $report->report_link]) }}" method="POST">
                           @CSRF
                            <button
                          type="submit" target="_blank"
                          class="font-medium  text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light"
                          >{{$report->Site_name}} <input type="hidden" value="{{$report->Site_name}}"></button>
                       </form>
                      </div>
                      <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                          
                          <div>
                            <p class="text-xs font-medium line-clamp-1">
                                 <i class="fa fa-history text-tiny"></i>
                             {{$report->created_at}}
                            </p>
                          
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <img
                      src="{{$report->site_screen}}"
                      class="h-20 w-20 rounded-lg object-cover object-center"
                      alt="image"
                    />
                  </div>
                  
                
                    @endforeach
 @else

      
 <div
                      class="swiper-slide relative flex h-28 flex-col  rounded-xl  p-3"
                    >
                    <div class="card border border-slate-150 px-4 py-4 shadow-none hover:bg-slate-100 dark:hover:bg-navy-600 dark:border-navy-600 sm:px-5 text-center">
                        <a href="#">
           
            <div class="text-left">
              <p class="pt-2">
             No Recent Reports Found
              </p>
              
            </div>
            </a>
          </div>
                    </div>
                  
@endif
                    
                

                
                </div>
              </div>

              <div class="mt-3 px-3">
                <h2
                  class="text-xs+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100"
                >
                  Settings
                </h2>
                <div class="mt-2 flex flex-col space-y-2">
                  <label class="inline-flex items-center space-x-2">
                    <input
                      x-model="$store.global.isDarkModeEnabled"
                      class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-slate-500 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-navy-400 dark:checked:before:bg-white"
                      type="checkbox"
                    />
                    <span>Dark Mode</span>
                  </label>
                  <label class="inline-flex items-center space-x-2">
                    <input
                      x-model="$store.global.isMonochromeModeEnabled"
                      class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-slate-500 checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-navy-400 dark:checked:before:bg-white"
                      type="checkbox"
                    />
                    <span>Monochrome Mode</span>
                  </label>
                </div>
              </div>

              
             
            </div>

           

            <div
              class="pointer-events-none absolute bottom-4 flex w-full justify-center"
            >
             
            </div>
          </div>
        </div>
      </div>












@endif