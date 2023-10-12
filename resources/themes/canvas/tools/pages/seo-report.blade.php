
@if(!empty(Session::get('tool')))
<x-canvas-layout>
 <div
          class="mt-4 grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6"
        >
    <div class="col-span-12 lg:col-span-12 xl:col-span-12">
        @if(Auth::user())
        
          
            <div
              :class="$store.breakpoints.smAndUp && 'via-purple-300'"
              class="card mt-12 bg-gradient-to-l from-pink-300 to-indigo-400 p-5 sm:mt-0 sm:flex-row"
            >
              <div class="flex justify-center sm:order-last">
                <img
                  class="-mt-16 h-40 sm:mt-0"
                  src="images/illustrations/teacher.svg"
                  alt=""
                />
              </div>
              <div
                class="mt-2 flex-1 pt-2 text-center text-white sm:mt-0 sm:text-left"
              > 
                <h3 class="text-xl">
                  Welcome Back, <span class="font-semibold"> {{isset(Auth::user()->name) != null ? Auth::user()->name : '' }}</span>
                </h3>
                <p class="mt-2 leading-relaxed">
               {{isset(Auth::user()->about) != null ? Auth::user()->about : '' }}
               </p>

           
                </button>
              </div>
            </div>
        
        
        @endif
        <br>
  @php
    $favourites = Auth::check() ? Auth::user()->favorite_tools : null;
    @endphp
    <x-favorite-tools :tools="$favourites" />
  
      @if(Session::Get('tool'))
       
         @foreach (Session::Get('tool') as $item)
                <h2 class="text-lg" style="margin: 2rem 0;font-size:2rem">{{$item->name}}</h2>
                <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                @foreach ($item->tools as $tool)
                       <div class="card border border-slate-150 px-4 py-4 shadow-none hover:bg-slate-100 dark:hover:bg-navy-600 dark:border-navy-600 sm:px-5 text-center">
                        <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}">
            <div>
              <h2 class="text-lg font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
              <i class="an-duotone an-{{ $tool->icon_class }} mr-2"  ></i>
              </h2>
            </div>
            <div class="pt-2">
              <p>
              {{ $tool->name }}
              </p>
            </div>
            </a>
          </div>
                                               @endforeach
   
             
                
              
                
                </div>









                                 
                                    @endforeach
       
       @endif

       

         
        </div>
        <script>
        var Wu = {
            
            workingHourss: {
              colors: ["#0EA5E9"],
              series: [20],
              chart: { height: 210, type: "radialBar" },
              plotOptions: {
                radialBar: {
                  hollow: { margin: 0, size: "70%" },
                  dataLabels: {
                    name: { show: !1 },
                    value: {
                      show: !0,
                      color: "#333",
                      offsetY: 10,
                      fontSize: "24px",
                      fontWeight: 600,
                    },
                  },
                },
              },
              grid: {
                show: !1,
                padding: { left: 0, right: 0, top: 0, bottom: 0 },
              },
              stroke: { lineCap: "round" },
            },
          
          }
        </script>
        </div>
         
        <x-slot name="sidebar">
            <x-application-sidebar>
                @widgetGroup('tools-sidebar')
            </x-application-sidebar>
        </x-slot>
   
</x-canvas-layout>



 
  
  
  @else
  <x-tool-home-layout>
   {!! $tool->index_content !!}
    @if (setting('display_plan_homepage', 1) == 1)
        <x-plans-tools :plans="$plans ?? null" :properties="$properties" />
    @endif
    @if (setting('display_faq_homepage', 1) == 1)
        <x-faqs-tools :faqs="$faqs" />
    @endif
    <x-relevant-tools :relevant_tools="$relevant_tools" />
    @if (isset($results))
        @push('page_scripts')
        <link rel="stylesheet" href="/public/front/assets/css/main.css">
            <script>
                const APP = function() {
                    const resources =
                        '<link rel="stylesheet" href="{{ Vite::asset('resources/themes/canvas/assets/sass/app.scss') }}" />';
                    const printReport = function() {
                            let printable = document.querySelector('.printable-container').cloneNode(true)

                            printable.querySelectorAll('.col-auto').forEach(element => {
                                element.remove()
                            });
                            printable.querySelectorAll('.collapse').forEach(element => {
                                element.classList.remove('collapse')
                            });
                            printable.querySelectorAll('.an-light').forEach(element => {
                                element.classList.remove('an-light')
                            });

                            let wrapper = document.createElement('div')
                            let children = document.createElement('div')
                            children.className = 'report-result container'
                            children.appendChild(printable)
                            wrapper.appendChild(children)
                            ArtisanApp.printResult(wrapper, {
                                title: '{{ __('seo.seoReportForDomain', ['domain' => $results['result']['domainname']]) }}',
                                header_code: resources
                            })
                            // document.querySelector('body').appendChild(wrapper)
                        },
                        attachEvents = function() {
                            document.querySelector('#printReport').addEventListener('click', elem => {
                                printReport()
                            })
                        };

                    return {
                        init: function() {
                            attachEvents();
                        }
                    }
                }();

                document.addEventListener("DOMContentLoaded", function(event) {
                    APP.init();
                });
            </script>
        @endpush
    @endif
    
    
</x-tool-home-layout>
  @endif
   


