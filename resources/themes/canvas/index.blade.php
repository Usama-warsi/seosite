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
    @foreach ($tools as $item)
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
<x-front-layout>

<section
  class="breadcrumb-area breadcrumb-overlay p-relative pb-115 pt-195 jarallax"
  data-background="public/front/assets/img/bg-1.jpg"
  style="
    background-image: none;
    background-attachment: scroll;
    background-size: cover;
    background-repeat: no-repeat;
  "
>

  <div class="container">
    <div class="row">
      <div class="col-xxl-12">
        <div
          class="breadcrumb__content breadcrumb__content-2 text-center p-relative z-index-1"
        >
          <h3 class="breadcrumb__title">All Tools</h3>
          <x-application-breadcrumbs />
        </div>
      </div>
    </div>
  </div>
  <div class="inner-shape-dots">
    <img src="/public/front/assets/img/shape/inner-dots-shape.png" alt="" />
  </div>
</section>


   
       @php
    $toolss = Auth::check() ? Auth::user()->favorite_tools : null;
    @endphp
    <section class="banner__area py-5 scene tpbanner-shape-wrapper fix" >
         <div class="tpbanner-shape-wrappers">
            <div class="container">
                <div class="row">
               <div class="col-lg-12">
                  <div class="tpsection__wrapper text-center mb-70">
                     
                     <h2 class="tpsection__title">Your Favorite Tools</h2>
                  </div>
               </div>
            </div>
              <div class="row">
                  @guest
                  <div class="col-lg-12">
                  <div class="blog-item-2 d-flex align-items-center mb-30 text-center">
                   
                     <div class="blog-content m-auto">
                       
                        <h4 class="blog-title">@lang('tools.favoriteToolsGuestDesc')</h4>
                        <a class="btn btn-primary rounded-pill ps-5 pe-5 mt-3" href="{{ route('login') }}">@lang('auth.login')</a>
                     </div>
                  </div>
               </div>
           
        @elseif($toolss)
          
              
                @foreach ($toolss as $tool)
                 
                                                                                 
                                                                                 <div class="col-lg-3">
                  <div class="blog-item-2 text-center mb-30">
                     <div class="blog-thumb">
                        <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}">  <i class="an-duotone an-{{ $tool->icon_class }} mr-2"  ></i></a>
                     </div>
                     <div class="blog-content">
                       
                        <h4 class="blog-title"><a href="{{ route('tool.show', ['tool' => $tool->slug]) }}"> {{ $tool->name }}</a></h4>
                     </div>
                  </div>
               </div>
                                                                                  @endforeach
                               

        @else
         <div class="col-lg-12">
                  <div class="blog-item-2 d-flex align-items-center mb-30 text-center">
                   
                     <div class="blog-content m-auto">
                       
                        <h4 class="blog-title">@lang('tools.favoriteToolsAuthDesc')</h4>
                       
                     </div>
                  </div>
               </div>
           
         
        @endguest
               

           
            </div>
            
         </div>
        </div>
</section>


       <section class="banner__area py-5 scene tpbanner-shape-wrapper fix" data-background="/public/front/assets/img/banner/banner-1.png" style="background-image: url(&quot;/public/front/assets/img/banner/banner-1.png&quot;); transform: translate3d(0px, 0px, 0px); transform-style: preserve-3d; backface-visibility: hidden; background-repeat:no-repeat;">
         <div class="tpbanner-shape-wrappers">
            <div class="container">
               
              
               @foreach ($tools as $item)
                <div class="row">
               <div class="col-lg-12">
                  <div class="tpsection__wrapper text-center mb-70">
                     
                     <h2 class="tpsection__title">{{$item->name}}</h2>
                  </div>
               </div>
            </div>
             <div class="row">
                @foreach ($item->tools as $tool)
                 <div class="col-lg-3">
                  <div class="blog-item-2 text-center mb-30">
                     <div class="blog-thumb">
                        <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}">   <i class="an-duotone an-{{ $tool->icon_class }} mr-2"  ></i></a>
                     </div>
                     <div class="blog-content">
                       
                        <h4 class="blog-title"><a href="{{ route('tool.show', ['tool' => $tool->slug]) }}"> {{ $tool->name }}</a></h4>
                     </div>
                  </div>
               </div>
                       
                                               @endforeach
   
            </div>
              @endforeach
         </div>
        </div>
      </section>
  @if (!Widget::group('tools-sidebar')->isEmpty())
        <x-slot name="sidebar">
            <x-application-sidebar>
                @widgetGroup('tools-sidebar')
            </x-application-sidebar>
        </x-slot>
    @endif
      @push('page_scripts')
  <script>
      
      $(document).ready(function(){
        $('#header-sticky').addClass('tp-white-menu');  
      })
  </script>
    @endpush

</x-front-layout>



@endif
