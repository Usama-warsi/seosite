
<x-application-tools-wrapper>


      
@CSRF
   
    
           @if(!isset($results))
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            
              <div class="col-span-12 lg:col-span-12">
                <div class="card">
                  <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
                  >
                    <h2
                      class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100"
                    >   @if (!empty($tool->name))
              {{ $tool->name }}
            @endif
          
                    </h2>
                    <div class="flex justify-center space-x-2">
    
            <button data-id="{{ $tool->id }}" type="button" id="buttonlike" data-url="{{ route('tool.favouriteAction') }}" x-data="{isLiked:  @if (Auth::check() && $tool->hasBeenFavoritedBy(Auth::user())) true @else false @endif }" @click="isLiked = !isLiked" class="btn h-9 w-9 bg-slate-150 p-0 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                  
                    <i x-show="!isLiked" class="fa-regular fa-heart text-lg" style="display: none;"></i>
                          <i x-show="isLiked" class="fa-solid fa-heart text-lg text-error"></i>
            </button>
                
                    </div>
                  </div>
                  <div class="p-4 sm:p-5">
                  @if (!empty($tool->description))
                <p>{{ $tool->description ?? '' }}</p>
            @endif
                    <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
    <x-form method="post" :route="route('tool.handle', $tool->slug)">
                    <label class="p-2" for="">@lang('tools.enterWebsiteUrl')</label>
    
                    <div class="relative flex -space-x-px" style="margin-top: 0.6rem;" >
        <input
          class="form-input peer w-full rounded-l-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
          placeholder="Enter Url..."
          type="text"
          name="url" id="url" type="url" required
                                value="{{ $results['url'] ?? old('url') }}"  
        />
    
        <div
          class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
        >
        <i class="fas fa-globe"></i>
        </div>
    
        <input type="submit" style="min-width: fit-content;"
          class="btn rounded-l-none bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
        value="Generate Report"
          >
        
    
       
                        </div>
                        </x-form>
                        <x-input-error :messages="$errors->get('url')" /> 
                   
                  </div>
                </div>
              </div>
            </div>
           
           @endif
           
            <!--header-->
          
            @if (isset($results))
<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

  <div class="col-span-12 lg:col-span-12">
    <div class="card">
      <div
        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100"> Report Result
        </h2>
       @if(Auth()->user())
        <div class="flex justify-center space-x-2">



          <a href="{{route('tool.show', ['tool' => $tool->slug])}}"
            class="btn h-9 w-9 bg-slate-150 p-0 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <i class="an an-reload" style="font-size:1rem;color:#ff9800"></i>
          </a>
          <button onclick="printreport()"
            class="btn h-9 w-9 bg-slate-150 p-0 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <i class="an an-print" style="font-size:1rem;color:#10b981"></i>
          </button>

        </div>
        @endif
       
      </div>


      <div class="p-4 sm:p-5">


        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 printable-container">
          <div class="col-span-12 lg:col-span-8 printheader">
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
              <div class="col-span-12 lg:col-span-6 text-center half">
                <img src="{{ setting('website_logo') }}" alt="{{ config('app.name') }}" class="logo-light w-4/12">
              </div>

              <div class="col-span-12 lg:col-span-6 half text-right" style="    display: flex;
align-items: end;
justify-content: right;">

                <p class="mb-0" style="font-size:0.8rem">
                  @lang('seo.reportGeneratedDate', ['date' => now()->format(setting('datetime_format'))])
                </p>

              </div>
            </div>
          </div>
          <div class="col-span-12 @if(Auth()->user()) lg:col-span-7 @else lg:col-span-12 @endif " id="overview">
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 border-b border-slate-200 dark:border-navy-500">

              <div class="col-span-12 lg:col-span-6 text-center half">

                <h2 class="text-4xl font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left"> <i
                    class="an an-overview text-4xl"></i>
                  <span>@lang('seo.overview')</span>
                </h2>
              </div>

              <div class="col-span-12 lg:col-span-6 half text-right printhide">

                <p class="mb-0" style="font-size:0.8rem ">
                  @lang('seo.reportGeneratedDate', ['date' => now()->format(setting('datetime_format'))])
                </p>
 <!--<div class="totaltest">{{$results['result']['test_count']['total']}}</div>-->
 <!--<div class="totaltestpass">{{$results['result']['test_count']['passed']}}</div>-->
 <!--<div class="totaltestfail">{{$results['result']['test_count']['failed']}}</div>-->
 <!-- <div class="totaltestwarn">0</div>-->
              </div>
            </div>



            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

              <div class="col-span-12 lg:col-span-6 xl:col-span-6 half">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-5 lg:grid-cols-1 lg:gap-6">
                  <div class="card pb-5">
                    <div class="mt-3 flex items-center justify-between px-4">


                    </div>
                    <div>
                      <div id="chart"></div>
                    </div>

                  </div>


                </div>
              </div>




              <!-- <div class="col-span-12 lg:col-span-6 text-center" style="margin-top: 1rem;">-->
              <!--  <div class="screenshot ">-->
              <!--          <img class="w-100" src="{{ generateScreenshot($results['result']['baseUrl']) }}">-->
              <!--      </div>-->

              <!--</div>-->

              <div class="col-span-12 lg:col-span-6 half"
                style="display:flex; justify-content:center; align-items:center">
                 
                <div class="w-full">
                  <ol class="timeline max-w-sm [--size:1.5rem]">

                     <li class="timeline-item">
                      <div
                        class="timeline-item-point rounded-full border border-current bg-white text-primary dark:bg-navy-700">
                        <i class="fa-solid fa-table text-tiny"></i>
                      </div>
                      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                          <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                            Total
                          </p>
                          <span
                            class="text-xs text-slate-400 dark:text-navy-300 totaltest" id="totaltest">{{$results['result']['test_count']['total']}}</span>
                        </div>
                       
                        <div class="progress h-2 bg-primary/15 dark:bg-primary/25">
                          <div class=" rounded-full bg-primary"
                            style="width:100%">
                          </div>
                        </div>
                       


                      </div>
                    </li>

                    <li class="timeline-item">
                      <div
                        class="timeline-item-point rounded-full border border-current bg-white text-success dark:bg-navy-700">
                        <i class="fa-solid fa-check text-tiny"></i>
                      </div>
                      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                          <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                            Passed
                          </p>
                          <span
                            class="text-xs text-slate-400 dark:text-navy-300 totaltestpass" id="totaltestpass">{{$results['result']['test_count']['passed']}}</span>
                        </div>
                   
                        <div class="progress h-2 bg-success/15 dark:bg-success/25">
                          <div class=" rounded-full bg-success"  id="barpass"
                            style="width:{{$results['result']['test_count']['passed']/$results['result']['test_count']['total']*100}}%">
                          </div>
                        </div>
                      


                      </div>
                    </li>
                    <li class="timeline-item">
                      <div
                        class="timeline-item-point rounded-full border border-current bg-white text-warning dark:bg-navy-700">
                        <i class="fa-solid fa-triangle-exclamation text-tiny"></i>
                        <!--<i class="fa fa-project-diagram text-tiny"></i>-->
                      </div>
                      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                          <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                            Warning
                          </p>
                          <span class="text-xs text-slate-400 dark:text-navy-300 totaltestwarn" id="totaltestwarn">0</span>
                        </div>
                    
                        <div class="progress h-2 bg-warning/15 dark:bg-warning/25">
                          <div class="rounded-full bg-warning"  id="barwarn"
                          style="width:0%"></div>
                        </div>
                      

                      </div>
                    </li>
                    <li class="timeline-item">
                      <div
                        class="timeline-item-point rounded-full border border-current bg-white text-error dark:bg-navy-700">
                        <i class="fa-solid fa-xmark text-tiny"></i>
                      </div>
                      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                          <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                            Failed
                          </p>
                          <span
                            class="text-xs text-slate-400 dark:text-navy-300 totaltestfail" id="totaltestfail">{{$results['result']['test_count']['failed']}}</span>
                        </div>

                       
                        <div class="progress h-2 bg-error/15 dark:bg-error/25">
                          <div class="rounded-full bg-error" id="barfail"
                            style="width:{{$results['result']['test_count']['failed']/$results['result']['test_count']['total']*100}}%">
                          </div>
                        </div>
                        
                      </div>
                    </li>
                  </ol>
                </div>
                <!--<table class="w-full text-left">-->

                <!--  <tbody>-->
                <!--    <tr>-->
                <!--      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">-->
                <!--        Title-->
                <!--      </td>-->
                <!--      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">-->
                <!--        {{ $results['result']['title']['string'] ?? '' }}-->
                <!--      </td>-->
                <!--    </tr>-->
                <!--    <tr>-->
                <!--      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">-->
                <!--        Url      </td>-->
                <!--      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">-->
                <!--        {{ $results['result']['baseUrl'] ?? '' }}-->
                <!--      </td>-->
                <!--    </tr>-->
                <!--    <tr>-->
                <!--      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">-->
                <!--        Description-->
                <!--      </td>-->
                <!--      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">-->
                <!--        {{ $results['result']['description']['string'] ?? '' }}.-->
                <!--      </td>-->
                <!--    </tr>-->

                <!--  </tbody>-->
                <!--</table>-->

              </div>
            </div>


          </div>

        @if(Auth()->user())
          <div class="col-span-12 lg:col-span-5 fixeds printhide">
            <div class="p-4 sm:px-5">
              <ul class="space-y-1.5 font-inter font-medium">
                <li>
                  <a href="#overview"
                    class="group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide justify-between outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                    <span> <i class="an an-overview" style="font-size:1.25rem"></i>
                      <span>@lang('seo.overview')</span></span>

                    <span>

                      @if ($results['result']['test_count']['failed'] > 0)
                      <div class="badge bg-error/10 text-error dark:bg-error/15 totaltestfail" id="overviewf">
                        {{$results['result']['test_count']['failed']}}
                      </div>
                      @else
                      <div class="badge bg-error/10 text-error dark:bg-error/15 totaltestfail" id="overviewf">0</div>
                      @endif
                      <div class="badge bg-warning/10 text-warning dark:bg-warning/15 totaltestwarn" id="overvieww">0</div>
                      @if ($results['result']['test_count']['passed'] > 0)
                      <div class="badge bg-success/10 text-success dark:bg-success/15 totaltestpass" id="overviewp">
                        {{$results['result']['test_count']['passed']}}
                      </div>
                      @else
                      <div class="badge bg-success/10 text-success dark:bg-success/15 totaltestpass" id="overviewp">0</div>
                      @endif




                    </span>
                  </a>
                </li>
                <li>
                  <a class="group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide justify-between outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                    href="#seo">
                    <span>
                      <i class="an an-search" style="font-size:1.25rem"></i>
                      <span>@lang('seo.seo')</span>
                    </span>


                    <span>

                      @if ($results['result']['count_section']['seo']['failed'] > 0)
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="seof">
                        {{$results['result']['count_section']['seo']['failed']}}</div>
                      @else
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="seof">0</div>
                      @endif
                      <div class="badge bg-warning/10 text-warning dark:bg-warning/15" id="seow">0</div>
                      @if ($results['result']['count_section']['seo']['passed'] > 0)
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="seop">
                        {{$results['result']['count_section']['seo']['passed']}}</div>
                      @else
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="seop">0</div>
                      @endif

                    </span>
                  </a>
                </li>
                <li>
                  <a class="group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide justify-between outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                    href="#speed">
                    <span>
                      <i class="an an-performance" style="font-size:1.25rem"></i>
                      <span>@lang('seo.speedOptimizations')</span>
                    </span>
                    <span>

                      @if ($results['result']['count_section']['performance']['failed'] > 0)
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="speedf">
                        {{$results['result']['count_section']['performance']['failed']}}</div>
                      @else
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="speedf">0</div>
                      @endif
                      <div class="badge bg-warning/10 text-warning dark:bg-warning/15" id="speedw">0</div>
                      @if ($results['result']['count_section']['performance']['passed'] > 0)
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="speedp">
                        {{$results['result']['count_section']['performance']['passed']}}</div>
                      @else
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="speedp">0</div>
                      @endif

                    </span>
                  </a>
                </li>
                <li>
                  <a class="group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide justify-between outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                    href="#server">
                    <span>
                      <i class="an an-security" style="font-size:1.25rem"></i>
                      <span>@lang('seo.serverAndSecurity')</span>
                    </span>
                    <span>

                      @if ($results['result']['count_section']['security']['failed'] > 0)
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="serverf">
                        {{$results['result']['count_section']['security']['failed']}}</div>
                      @else
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="serverf">0</div>
                      @endif
                      <div class="badge bg-warning/10 text-warning dark:bg-warning/15" id="serverw">0</div>
                      @if ($results['result']['count_section']['security']['passed'] > 0)
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="serverp">
                        {{$results['result']['count_section']['security']['passed']}}</div>
                      @else
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="serverp">0</div>
                      @endif

                    </span>
                  </a>
                </li>
                <li>
                  <a class="group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide justify-between outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                    href="#advance">
                    <span>
                      <i class="an an-miscellaneous" style="font-size:1.25rem"></i>
                      <span>@lang('seo.advance')</span>

                    </span>
                    <span>

                      @if ($results['result']['count_section']['others']['failed'] > 0)
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="advancef">
                        {{$results['result']['count_section']['others']['failed']}}</div>
                      @else
                      <div class="badge bg-error/10 text-error dark:bg-error/15" id="advancef">0</div>
                      @endif
                      <div class="badge bg-warning/10 text-warning dark:bg-warning/15" id="advancew">0</div>
                      @if ($results['result']['count_section']['others']['passed'] > 0)
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="advancep">
                        {{$results['result']['count_section']['others']['passed']}}</div>
                      @else
                      <div class="badge bg-success/10 text-success dark:bg-success/15" id="advancep">0</div>
                      @endif

                    </span>
                  </a>
                </li>

              </ul>
            </div>
          </div>
        @endif


<!--main 12 col div start-->
          <div class="col-span-12 lg:col-span-12 ">
            <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

            <!--start-->
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

              <div class="col-span-12 lg:col-span-3 text-center quater">

                <div class="d-flex position-relative align-items-center">
                  <i class="an an-stopwatch an-2x an-light"></i>
                  <span class="me-2 ps-3">@lang('seo.secondCount', ['count' => $results['result']['loadtime']])</span>
                </div>
              </div>

              <div class="col-span-12 lg:col-span-3 quater"
                style="display:flex; justify-content:center; align-items:center">
                <div class="d-flex position-relative align-items-center">
                  <i class="an an-balance an-2x an-light"></i>
                  <span class="me-2 ps-3">{{ formatSizeUnits($results['result']['pagesize'] ?? 0) }}</span>
                </div>

              </div>

              <div class="col-span-12 lg:col-span-3 quater"
                style="display:flex; justify-content:center; align-items:center">
                <div class="d-flex position-relative align-items-center">
                  <i class="an an-resources an-2x an-light"></i>
                  <span class="me-2 ps-3">@lang('seo.resourcesCount', ['count' =>
                    $results['result']['httpRequests']['total_requests']])</span>
                </div>

              </div>


              <div class="col-span-12 lg:col-span-3 quater"
                style="display:flex; justify-content:center; align-items:center">
                <div class="d-flex position-relative align-items-center">
                  <i class="an an-lock an-2x an-light"></i>
                  <span class="me-2 ps-3">{{ $results['result']['ssl']['is_valid'] == true ? 'Secured' : 'Not Secured'
                    }}
                  </span>
                </div>
              </div>


            </div>
            <!--end-->

            <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

            <!--start-->

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

              <div class="col-span-12 lg:col-span-4 text-center half" style="margin-top: 1rem;">
                <div class="screenshot ">
                  <img class="w-100" id="deskss" src="{{ generateScreenshot($results['result']['baseUrl']) }}">
                </div>

              </div>

              <div class="col-span-12 lg:col-span-8 half"
                style="display:flex; justify-content:center; align-items:center">

                <table class="w-full text-left">

                  <tbody>
                    <tr>
                      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                        Title
                      </td>
                      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                        {{ $results['result']['title']['string'] ?? '' }}
                      </td>
                    </tr>
                    <tr>
                      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                        Url </td>
                      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                        {{ $results['result']['baseUrl'] ?? '' }}
                      </td>
                    </tr>
                    <tr>
                      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                        Description
                      </td>
                      <td class=" border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                        {{ $results['result']['description']['string'] ?? '' }}.
                      </td>
                    </tr>

                  </tbody>
                </table>

              </div>
              
            </div>
            <!--end-->


            <div class="my-5 h-px bg-slate-200 dark:bg-navy-500 pagebreak"></div>

@if(Auth()->user())

<!--============================================================================================seo report tab start here============================================================================================-->
            <!--start-->

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="seo">

              <div class="col-span-12 lg:col-span-6 text-center half">

                <h2 class="text-4xl font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                  <i class="an an-search text-4xl"></i>
                  <span>@lang('seo.seo')</span>
                </h2>
              </div>

            </div>
            <!--end-->
            <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
          
          <!--metatitle-->
          
            <!--start-->

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
              <!--title-->

              <div class="col-span-12 lg:col-span-3 text-center quater">
                <div
                  class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

                  @if ($results['result']['tests']['title']['status'] == true)
                  <!--success pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
                    <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
                  </div>
                  @else
                  <!--warning pass-->
                  <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
                  <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
                  <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
                  <!--</svg>-->
                  <!--</div>-->
                  <!--error pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
                    <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  @endif
                  <div class="font-inter">
                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                      @lang('seo.title')
                    </p>

                  </div>
                </div>
              </div>

              <!--description-->
              <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
                <div
                  class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.titleExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div>
                     </div>
                  <div class="font-inter">

                    @if ($results['result']['title']['passed'])
                    <p>
                       <strong class="text-success">Congratulations! </strong> {{ __('seo.perfectTitle') }}
                    </p>
                    @else
                    @foreach ($results['result']['title']['error'] as $type => $error)
                    <p>{!! __("seo.titleError{$type}", $error) !!}</p>
                    @endforeach
                    @endif
                  </div>

                  @if ($results['result']['title']['length'] != 0)

                  @if($results['result']['title']['passed'])

                  <!--success-->
                  <div class="alert flex overflow-hidden rounded-lg bg-success/10 text-success my-2 dark:bg-success/15">
                    <div class="flex flex-1 items-center space-x-3 p-4">
                      <i class="fa-solid fa-check text-success"></i>
                      <div class="flex-1">
                        <p class="mb-0">
                          <strong>@lang('seo.text'):</strong>
                          {{ $results['result']['title']['string'] ?? '' }}
                        </p>
                        <p class="mb-0">
                          <strong>@lang('seo.length'):</strong>
                          {{ __('seo.numberCharacters', ['count' => $results['result']['title']['length']]) }}
                        </p>
                      </div>
                    </div>

                    <div class="w-1.5 bg-success"></div>
                  </div>
                  @else
                  <!--warning-->
                  <!--<div class="alert flex overflow-hidden rounded-lg bg-warning/10 text-warning my-2 dark:bg-warning/15">-->
                  <!--    <div class="flex flex-1 items-center space-x-3 p-4">-->
                  <!--        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"-->
                  <!--            stroke="currentColor">-->
                  <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
                  <!--                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />-->
                  <!--        </svg>-->
                  <!--        <div class="flex-1">-->
                  <!--            <p class="mb-0">-->
                  <!--                <strong>@lang('seo.text'):</strong>-->
                  <!--                Book Writing Services | Professional Book Writers For hire-->
                  <!--            </p>-->
                  <!--            <p class="mb-0">-->
                  <!--                <strong>@lang('seo.length'):</strong>-->
                  <!--                {{ __('seo.numberCharacters', ['count' => 20]) }}-->
                  <!--            </p>-->
                  <!--        </div>-->
                  <!--    </div>-->

                  <!--    <div class="w-1.5 bg-warning"></div>-->
                  <!--</div>-->
                  <!--error-->
                  <div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
                    <div class="flex flex-1 items-center space-x-3 p-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <div class="flex-1">
                        <p class="mb-0">
                          <strong>@lang('seo.text'):</strong>
                          {{ $results['result']['title']['string'] ?? '' }}
                        </p>
                        <p class="mb-0">
                          <strong>@lang('seo.length'):</strong>
                          {{ __('seo.numberCharacters', ['count' => $results['result']['title']['length']]) }}
                        </p>
                      </div>
                    </div>

                    <div class="w-1.5 bg-error"></div>
                  </div>
                  @endif

                  @endif

                  @if ($results['result']['title']['passed'])

                  @else
                  <!--modal-->
                  <div x-data="{showModal:false}" class="printhide">
                    <button @click="showModal = true"
                      class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
                      How to Fix
                    </button>
                    <template x-teleport="#x-teleport-target">
                      <div
                        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                        x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                          @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                          x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"></div>
                        <div
                          class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                          x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                          <!--modal contnet-->
                          <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                            <div class="col-span-12 lg:col-span-6 text-center half">
                              <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                                How to Fix
                              </h2>
                            </div>
                          </div>
                          <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
                          <!--modal content end-->
                          @foreach($seotools as $content)
                          @if($content->seotool == 'title' )

                          @php echo $content->howtofix; @endphp

                          @endif

                          @endforeach
                          <button @click="showModal = false"
                            class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                            Close
                          </button>
                        </div>
                      </div>

                    </template>
                  </div>

                  @endif

                </div>

              </div>

            

            </div>
                <!--end-->

              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

            <!--metadescription-->
 <!--start-->

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
              <!--title-->

              <div class="col-span-12 lg:col-span-3 text-center quater">
                <div
                  class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

                   @if ($results['result']['tests']['description']['status'] == true)
                  <!--success pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
                    <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
                  </div>
                  @else
                  <!--warning pass-->
                  <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
                  <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
                  <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
                  <!--</svg>-->
                  <!--</div>-->
                  <!--error pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
                    <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  @endif
                  <div class="font-inter">
                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                     @lang('seo.metaDescription')
                    </p>

                  </div>
                </div>
              </div>

              <!--description-->
              <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
                <div
                  class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
              
<div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.metaDescrptionExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div>
                     </div>
                  <div class="font-inter">

                    @if ($results['result']['description']['passed'])
                    <p>
                       <strong class="text-success">Congratulations! </strong>    {{ __('seo.perfectDescription') }}
                    </p>
                    @else
                    @foreach ($results['result']['description']['error'] as $type => $error)
                    <p>{!! __("seo.descriptionError{$type}", $error) !!}</p>
                    @endforeach
                    @endif
                  </div>

                  @if ($results['result']['description']['length'] != 0)

                  @if($results['result']['description']['passed'])

                  <!--success-->
                  <div class="alert flex overflow-hidden rounded-lg bg-success/10 text-success my-2 dark:bg-success/15">
                    <div class="flex flex-1 items-center space-x-3 p-4">
                      <i class="fa-solid fa-check text-success"></i>
                      <div class="flex-1">
                        <p class="mb-0">
                          <strong>@lang('seo.text'):</strong>
                          {{ $results['result']['description']['string'] ?? '' }}
                        </p>
                        <p class="mb-0">
                          <strong>@lang('seo.length'):</strong>
                          {{ __('seo.numberCharacters', ['count' => $results['result']['description']['length']]) }}
                        </p>
                      </div>
                    </div>

                    <div class="w-1.5 bg-success"></div>
                  </div>
                  @else
                  <!--warning-->
                  <!--<div class="alert flex overflow-hidden rounded-lg bg-warning/10 text-warning my-2 dark:bg-warning/15">-->
                  <!--    <div class="flex flex-1 items-center space-x-3 p-4">-->
                  <!--        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"-->
                  <!--            stroke="currentColor">-->
                  <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
                  <!--                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />-->
                  <!--        </svg>-->
                  <!--        <div class="flex-1">-->
                  <!--            <p class="mb-0">-->
                  <!--                <strong>@lang('seo.text'):</strong>-->
                  <!--                Book Writing Services | Professional Book Writers For hire-->
                  <!--            </p>-->
                  <!--            <p class="mb-0">-->
                  <!--                <strong>@lang('seo.length'):</strong>-->
                  <!--                {{ __('seo.numberCharacters', ['count' => 20]) }}-->
                  <!--            </p>-->
                  <!--        </div>-->
                  <!--    </div>-->

                  <!--    <div class="w-1.5 bg-warning"></div>-->
                  <!--</div>-->
                  <!--error-->
                  <div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
                    <div class="flex flex-1 items-center space-x-3 p-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <div class="flex-1">
                        <p class="mb-0">
                          <strong>@lang('seo.text'):</strong>
                          {{ $results['result']['description']['string'] ?? '' }}
                        </p>
                        <p class="mb-0">
                          <strong>@lang('seo.length'):</strong>
                          {{ __('seo.numberCharacters', ['count' => $results['result']['description']['length']]) }}
                        </p>
                      </div>
                    </div>

                    <div class="w-1.5 bg-error"></div>
                  </div>
                  @endif

                  @endif

                  @if ($results['result']['description']['passed'])

                  @else
                  <!--modal-->
                  <div x-data="{showModal:false}" class="printhide">
                    <button @click="showModal = true"
                      class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
                      How to Fix
                    </button>
                    <template x-teleport="#x-teleport-target">
                      <div
                        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                        x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                          @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                          x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"></div>
                        <div
                          class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                          x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                          <!--modal contnet-->
                          <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                            <div class="col-span-12 lg:col-span-6 text-center half">
                              <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                                How to Fix
                              </h2>
                            </div>
                          </div>
                          <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
                          <!--modal content end-->
                          @foreach($seotools as $content)
                      @if($content->seotool == 'metaDescription' )
                      
                    @php echo $content->howtofix; @endphp
                    
                      @endif
                      
                      @endforeach
                          <button @click="showModal = false"
                            class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                            Close
                          </button>
                        </div>
                      </div>

                    </template>
                  </div>

                  @endif

                </div>

              </div>

            

            </div>
                <!--end-->

              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

         <!--google preview-->
 <!--start-->

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
              <!--title-->

              <div class="col-span-12 lg:col-span-3 text-center quater">
                <div
                  class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

                  
                  <div class="font-inter text-left">
                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                    @lang('seo.googleSearchPreview')
                    </p>

                  </div>
                </div>
              </div>

              <!--description-->
              <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
                <div
                  class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.googleSearchPreviewexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div>
                     </div>

                  <div class="font-inter">

                   
                    <p class="my-2"><strong>@lang('seo.desktopVersion')</strong></p>
                             <div class="google-search-preview desktop-version border shadow-sm px-3 py-2 my-4">
                                 <div class="site-url line-truncate line-1">
                                     {{ $results['result']['url'] }}</div>
                                 <div class="site-title line-truncate line-1">
                                     {{ Str::limit($results['result']['title']['string'], config('artisan.seo.page_title_max')) }}
                                 </div>
                                 <div class="site-description line-truncate line-2">
                                     {{ Str::limit($results['result']['description']['string'], config('artisan.seo.meta_description_max')) }}
                                 </div>
                             </div>
                             <p class="my-2"><strong>@lang('seo.mobileVersion')</strong></p>
                             <div class="google-search-preview  mobile-version border shadow-sm px-3 py-2 my-4">
                                 <div class="site-url line-truncate line-1">
                                     {{ $results['result']['url'] }}</div>
                                 <div class="site-title line-truncate line-2">
                                     {{ Str::limit($results['result']['title']['string'], config('artisan.seo.page_title_max')) }}
                                 </div>
                                 <div class="site-description line-truncate line-3">
                                     {{ Str::limit($results['result']['description']['string'], config('artisan.seo.meta_description_max')) }}
                                 </div>
                             </div>
                  </div>

              

                </div>

              </div>

            

            </div>
                <!--end-->

              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

          <!--socailmetatags-->
 <!--start-->

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
              <!--title-->

              <div class="col-span-12 lg:col-span-3 text-center quater">
                <div
                  class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

                 @if ($results['result']['tests']['socialTags']['status'] == true)
                  <!--success pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
                    <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
                  </div>
                  @else
                  <!--warning pass-->
                  <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
                  <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
                  <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
                  <!--</svg>-->
                  <!--</div>-->
                  <!--error pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
                    <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                    </svg>
                  </div>
                  @endif
                  <div class="font-inter">
                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                    @lang('seo.socialMediaMetaTags')
                    </p>

                  </div>
                </div>
              </div>

              <!--description-->
              <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
                <div
                  class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                
                       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.socialMediaMetaTagsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div>
                     </div>

                  <div class="font-inter">

                   
                    <p>
                         @if( $results['result']['tests']['socialTags']['status'])
                         
                         <strong class="text-success">Congratulations! </strong> {{__('seo.socialMediaMetaTagsPassed')}}
                         @else
                         
                         {{__('seo.socialMediaMetaTagsFailed') }}
                         @endif
                            
                    </p>
                     
                  </div>
 @if (count($results['result']['structuredData']['og'] ?? []) > 0)
 
  <!--collapse-->
                <div class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6  my-2">
                    <div x-data="{expanded:false}"
                        class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
                        <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
                            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">
        
        
                                <div class="flex">
                                    <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                                       @lang('seo.openGraph') <span><div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['structuredData']['og'] ?? []) ?? '0' }}</div></span>
                                    </p>
        
                                </div>
                            </div>
                            <button @click="expanded = !expanded"
                                class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <i :class="expanded && '-rotate-180'"
                                    class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 py-4 sm:px-5">
                                
                                 <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="is-hoverable w-full text-left">
        
                        <tbody>
                              @foreach ($results['result']['structuredData']['og'] as $key => $links)
                               <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <th class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $key }}</th>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $links }}</td>
                            
                            </tr>
                                                
                                                 @endforeach
                           
                           
                        </tbody>
                    </table>
                </div>
                                
        
                            </div>
                        </div>
                    </div>
        
                </div>
 
                                 @endif
  @if (count($results['result']['structuredData']['twitter'] ?? []) > 0)
  
  <!--collapse-->
                <div class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6  my-2">
                    <div x-data="{expanded:false}"
                        class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
                        <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
                            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">
        
        
                                <div class="flex">
                                    <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                                     @lang('seo.twitter') <span><div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['structuredData']['twitter'] ?? []) ?? '0' }}</div></span>
                                    </p>
        
                                </div>
                            </div>
                            <button @click="expanded = !expanded"
                                class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <i :class="expanded && '-rotate-180'"
                                    class="fas fa-chevron-down text-sm transition-transform"></i>
                            </button>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="px-4 py-4 sm:px-5">
                                
                                 <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="is-hoverable w-full text-left">
        
                        <tbody>
                              @foreach ($results['result']['structuredData']['twitter'] as $key => $links)
                               <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <th class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $key }}</th>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $links }}</td>
                            
                            </tr>
                                                
                                                 @endforeach
                           
                           
                        </tbody>
                    </table>
                </div>
                                
        
                            </div>
                        </div>
                    </div>
        
                </div>
                                 @endif
                                       
                  

                   @if ($results['result']['tests']['socialTags']['status'] == true)
                            
                         @else
                  <!--modal-->
                  <div x-data="{showModal:false}" class="printhide my-2">
                    <button @click="showModal = true"
                      class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
                      How to Fix
                    </button>
                    <template x-teleport="#x-teleport-target">
                      <div
                        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                        x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                          @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                          x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                          x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"></div>
                        <div
                          class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                          x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                          <!--modal contnet-->
                          <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                            <div class="col-span-12 lg:col-span-6 text-center half">
                              <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                                How to Fix
                              </h2>
                            </div>
                          </div>
                          <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
                          <!--modal content end-->
                          @foreach($seotools as $content)
                      @if($content->seotool == 'socialMediaMetaTags' )

                    @php echo $content->howtofix; @endphp

                    @endif

                    @endforeach
                          <button @click="showModal = false"
                            class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                            Close
                          </button>
                        </div>
                      </div>

                    </template>
                  </div>

                  @endif

                </div>

              </div>

            

            </div>
                <!--end-->

              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
   <!--commonkeywords-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['keywords']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.mostCommonKeywords')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
    
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.mostCommonKeywordsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div>
                     </div>
      <div class="font-inter my-2">


        <p>
          @lang('seo.mostCommonKeywordsHelp', ['count' => count($results['result']['full_page']['keywords'])])

        </p>

      </div>
      @if (count($results['result']['full_page']['keywords']) > 0)

      @foreach ($results['result']['full_page']['keywords'] as $keyword => $wordCount)

      <div class="badge rounded-full border border-info text-info my-0.5 mx-0.5">{{ $keyword }} ({{ $wordCount }})</div>
      @endforeach
      @endif



      @if ($results['result']['tests']['keywords']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'mostCommonKeywords' )

              @php echo $content->howtofix; @endphp

              @endif


              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->
   <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!--keyword usage-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['keywords_usage']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.keywordUsageTest')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
    
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsageTestExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div>
                     </div>
      <div class="font-inter my-2">



      </div>

      <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
        <table class="is-hoverable w-full text-left">
          <thead>
            <tr>
              <th
                class=" bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.keyword')
              </th>
              <th
                class=" bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.title')
              </th>
              <th
                class=" bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.description')
              </th>
              <th
                class=" bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.headings')
              </th>
            </tr>
          </thead>
          <tbody>

            @foreach ($results['result']['tests']['keywords_usage']['data'] as $key => $keyword)

            <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
              <td class=" px-4 py-3 sm:px-5">{{ $key }}
                ({{ $keyword['count'] }})</td>
              <td class="px-4 py-3 sm:px-5">{!! $keyword['title']
                ? '<i class="fa-solid fa-check text-success text-center"></i>'
                : '<i class="fa-solid fa-xmark text-error text-center"></i>' !!}</td>
              <td class=" px-4 py-3 sm:px-5">
                {!! $keyword['description']
                ? '<i class="fa-solid fa-check text-success text-center"></i>'
                : '<i class="fa-solid fa-xmark text-error text-center"></i>' !!}
              </td>
              <td class=" px-4 py-3 sm:px-5">{!! $keyword['headers']
                ? '<i class="fa-solid fa-check text-success text-center"></i>'
                : '<i class="fa-solid fa-xmark text-error text-center"></i>' !!}</td>
            </tr>


            @endforeach

          </tbody>
        </table>
      </div>


      @if ($results['result']['tests']['keywords_usage']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'keywordUsageTest' )

              @php echo $content->howtofix; @endphp

              @endif


              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
   
   



<!--long keyword usage-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['keywords_usage_long']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.keywordUsageTestLong')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsageTestLongExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter my-2">



      </div>

      <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
        <table class="is-hoverable w-full text-left">
          <thead>
            <tr>
              <th
                class="bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.keyword')
              </th>
              <th
                class=" bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.title')
              </th>
              <th
                class=" bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.description')
              </th>
              <th
                class="bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                @lang('seo.headings')
              </th>
            </tr>
          </thead>
          <tbody>

            @foreach ($results['result']['tests']['keywords_usage_long']['data'] as $key => $keyword)

            <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
              <td class=" px-4 py-3 sm:px-5">{{ $key }}
                ({{ $keyword['count'] }})</td>
              <td class=" px-4 py-3 sm:px-5">{!! $keyword['title']
                ? '<i class="fa-solid fa-check text-success text-center"></i>'
                : '<i class="fa-solid fa-xmark text-error text-center"></i>' !!}</td>
              <td class=" px-4 py-3 sm:px-5">
                {!! $keyword['description']
                ? '<i class="fa-solid fa-check text-success text-center"></i>'
                : '<i class="fa-solid fa-xmark text-error text-center"></i>' !!}
              </td>
              <td class=" px-4 py-3 sm:px-5">{!! $keyword['headers']
                ? '<i class="fa-solid fa-check text-success text-center"></i>'
                : '<i class="fa-solid fa-xmark text-error text-center"></i>' !!}</td>
            </tr>


            @endforeach

          </tbody>
        </table>
      </div>


      @if ($results['result']['tests']['keywords_usage_long']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'keywordUsageTestLong' )

              @php echo $content->howtofix; @endphp

              @endif


              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
   
<!--heading tags-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['heading']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.headings')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.headingsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                   

      <div class="font-inter my-2">


        <p>

          @if ($results['result']['full_page']['headers']['total'] > 0)
          <strong class="text-success">Congratulations! </strong> @lang('seo.hasHeadingsTag')

          @else
          @lang('seo.noHeadingsTag')
          @endif

        </p>

      </div>
      @if ($results['result']['full_page']['headers']['total'] > 0)
      <!--collapse-->
      @foreach ($results['result']['full_page']['headers']['tags'] as $key => $header)
      @if ($header['count'] > 0)

      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  {{ $key }} <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ $header['count'] ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                  @foreach ($header['headers'] as $head)
                  <li class="py-1 text-break">
                    {{ $head }}</li>
                  @endforeach
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>








      @endif
      @endforeach






      @endif



      @if ($results['result']['tests']['heading']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'headings' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
   

<!--robot txt-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['has_robots_txt']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.has_robots_txt')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsagerobotsTxtExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">

        @if ($results['result']['tests']['has_robots_txt']['status'])
        <p>
          <strong class="text-success">Congratulations! </strong> {{ __('seo.robotsTxtPassed') }}
        </p>
        @else

        <p>__('seo.robotsTxtFailed')</p>

        @endif
      </div>



      @if ($results['result']['tests']['has_robots_txt']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'has_robots_txt' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

   

<!--site map-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['sitemap']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.sitemaps')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.sitemapExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['sitemap']['status'])

          <strong class="text-success">Congratulations! </strong> {{__('seo.hasSitemap')}}
          @else

          {{__('seo.hasNotSitemap') }}
          @endif

        </p>

      </div>
      @if ($results['result']['tests']['sitemap']['status'])

      <!--collapse-->
      <div class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6  my-2">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  @lang('seo.sitemaps') <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{
                      count($results['result']['sitemaps']['sitemaps']) ?? '0' }}</div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>
                  @foreach ($results['result']['sitemaps']['sitemaps'] as $sitemap)
                  <li class="py-1 text-break">
                    <a href="{{ $sitemap }}" target="_blank" rel="noopener noreferrer" class="underline">
                      {{ $sitemap }}
                    </a>

                  </li>
                  @endforeach
                </ol>
              </div>


            </div>
          </div>
        </div>

      </div>

      @endif

      @if ($results['result']['tests']['sitemap']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'sitemaps' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- seo friendly -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['friendly']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.friendly')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.multiCollapsefriendlyExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                 

      <div class="font-inter">

        @if ($results['result']['tests']['friendly']['status'] === true)
        <p>
          <strong class="text-success">Congratulations! </strong> {{ __('seo.friendlyPassed') }}
        </p>
        @else

        <p>{{__('seo.friendlyFailed')}}</p>

        @endif
      </div>
      @if (!$results['result']['tests']['friendly']['status'])

      <!--collapse-->
      <div class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6  my-2">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  @lang('seo.unfriendlyUrl') <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{
                      $results['result']['full_page']['links']['friendly'] ?? '0'}}</div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>
                  @foreach ($results['result']['full_page']['links']['links'] as $links)
                  @if ($links['friendly'] == false)
                  <li class="py-1 text-break">
                    <a href="{{ $links['url'] }}" target="_blank" rel="noopener noreferrer" class="underline">
                      {{ !empty($links['content']) ? $links['content'] : $links['url'] }}
                    </a>

                  </li>
                  @endif
                  @endforeach
                </ol>
              </div>


            </div>
          </div>
        </div>

      </div>

      @endif


      @if ($results['result']['tests']['friendly']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'friendly' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--alt tags-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
      @php
      $total = $results['result']['full_page']['images']['count'];
      $withAlt = $results['result']['full_page']['images']['count_alt'];
      $missing = $total - $withAlt;
      
      @endphp
      
   
      @if(!empty($withAlt) && !empty($total) && $withAlt/$total*100 >= 80 && $withAlt/$total*100 <= 100) <!--warning pass-->
        <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
          <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
            </path>
          </svg>
        </div>


        @elseif ($results['result']['tests']['images']['status'] == true)
        <!--success pass-->
        <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
          <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
        </div>
        @else
        <!--warning pass-->
        <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
        <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
        <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
        <!--</svg>-->
        <!--</div>-->
        <!--error pass-->
        <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
          <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
            viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
              clip-rule="evenodd"></path>
          </svg>
        </div>
        @endif
        <div class="font-inter">
          <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
            @lang('seo.imageAltText')
          </p>

        </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.imageAltTextExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $missing == 0)

          <strong class="text-success">Congratulations! </strong> {{__('seo.imagesAltPassed', ['count' => $total,
          'count_alt' => $withAlt, 'missing' => $missing])}}
          @else

          {{__('seo.imagesAltMissingCount', ['count' => $total, 'count_alt' => $withAlt, 'missing' => $missing])}}
          @endif

        </p>

      </div>
      @if ($missing > 0)

      <!--collapse-->
      <div class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6  my-2">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  @lang('seo.imageWithoutAlt') <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ $missing }}</div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>
                  @if (count($results['result']['full_page']['images']['images']) > 0)
                  @foreach ($results['result']['full_page']['images']['images'] as $images)
                  @if (empty($images['alt']))
                  <li class="py-1 text-break">
                    <a href="{{ $images['src'] }}" target="_blank" rel="noopener noreferrer" class="underline">
                      {{ $images['src'] }}
                    </a>

                  </li>
                  @endif
                  @endforeach
                  @endif
                </ol>




              </div>


            </div>
          </div>
        </div>

      </div>

      @endif

    @if(!empty($withAlt) && !empty($total) && $withAlt/$total*100 >= 80 && $withAlt/$total*100 <= 100) <!--warning pass-->
        <div x-data="{showModal:false}" class="printhide my-2">
          <button @click="showModal = true"
            class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
            How to Fix
          </button>
          <template x-teleport="#x-teleport-target">
            <div
              class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
              x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
              <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
              <div
                class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <!--modal contnet-->
                <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                  <div class="col-span-12 lg:col-span-6 text-center half">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                      How to Fix
                    </h2>
                  </div>
                </div>
                <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
                <!--modal content end-->
                @foreach($seotools as $content)
                @if($content->seotool == 'imageAltText' )

                @php echo $content->howtofix; @endphp

                @endif


                @endforeach
                <button @click="showModal = false"
                  class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                  Close
                </button>
              </div>
            </div>

          </template>
        </div>

        @elseif ($results['result']['tests']['images']['status'] == true)

        @else
        <!--modal-->
        <div x-data="{showModal:false}" class="printhide my-2">
          <button @click="showModal = true"
            class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
            How to Fix
          </button>
          <template x-teleport="#x-teleport-target">
            <div
              class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
              x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
              <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
                @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
              <div
                class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <!--modal contnet-->
                <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                  <div class="col-span-12 lg:col-span-6 text-center half">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                      How to Fix
                    </h2>
                  </div>
                </div>
                <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
                <!--modal content end-->
                @foreach($seotools as $content)
                @if($content->seotool == 'imageAltText' )

                @php echo $content->howtofix; @endphp

                @endif


                @endforeach
                <button @click="showModal = false"
                  class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                  Close
                </button>
              </div>
            </div>

          </template>
        </div>

        @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>




<!--inline css-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['inlineCss']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.inlineCss')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.inlineCssExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if( count($results['result']['inlineCss']) == 0)

          <strong class="text-success">Congratulations! </strong> {{__('seo.hasNotValidCss')}}
          @else

          {{ __('seo.hasValidCss') }}
          @endif

        </p>

      </div>

      @if (count($results['result']['inlineCss']) > 0)

      <!--collapse-->
      <div class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6  my-2">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  @lang('seo.inlineCss') <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{
                      count($results['result']['inlineCss']) ?? '0' }}</div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>
                  @foreach ($results['result']['inlineCss'] as $links)
                  <li class="py-1 text-break">

                    <code>{{ $links }}</code>
                  </li>
                  @endforeach
                </ol>

              </div>


            </div>
          </div>
        </div>

      </div>

      @endif

      @if ($results['result']['tests']['inlineCss']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'inlineCss' )

              @php echo $content->howtofix; @endphp

              @endif


              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--Deprecated HTML Tags-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['depHtml']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.depHtml')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.depHtmlExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['depHtml']['status'])

          <strong class="text-success">Congratulations! </strong> {{ __('seo.depHtmlPassed', ['count' =>
          count($results['result']['depricatedtTags']['deprecatedTags']) ?? 0]) }}
          @else

          {{__('seo.depHtmlFailed', ['count' => count($results['result']['depricatedtTags']['deprecatedTags']) ?? 0]) }}
          @endif

        </p>

      </div>


      @if ($results['result']['depricatedtTags']['total'] > 0)
      <ul class="mt-1 space-y-1.5 px-2 font-inter text-xs+ font-medium">

        @foreach ($results['result']['depricatedtTags']['deprecatedTags'] as $tag => $count)
        <li
          class="group flex justify-between space-x-2 bg-slate-150 rounded-lg p-2 tracking-wide text-slate-800 outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:text-navy-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">

          <span class="text-slate-800 dark:text-navy-100">{{ "<{$tag}>" }}</span>

          <div class="badge bg-error/10 text-error dark:bg-error/15">{{ $count }}</div>

        </li>
        @endforeach
      </ul>

      @endif




      @if ($results['result']['tests']['depHtml']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'depHtml' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>




<!--Google Analytics-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['analytics']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.analytics')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.multiCollapseanalyticsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $results['result']['analytics'] != null)

          <strong class="text-success">Congratulations! </strong> {{ __('seo.analyticsPassed') }}
          @else

          {{__('seo.analyticsFailed') }}
          @endif

        </p>

      </div>

      @if ($results['result']['tests']['analytics']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'analytics' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- Favicon -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['favicon']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.favicon')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.faviconExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if(!empty($results['result']['favicon']) )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.faviconYes') }}
          @else

          {{__('seo.faviconNo') }}
          @endif

        </p>

      </div>

      @if (!empty($results['result']['favicon']))
      <div class="avatar h-16 w-16 my-4 bg-success/10">
        <a href="{{ $results['result']['favicon'] ?? '' }}" target="_blank" rel="noopener noreferrer">
          <img class="rounded-full" src="{{ $results['result']['favicon'] ?? '' }}" alt="{{ __('seo.faviconYes') }}" />
        </a>
      </div>

      @endif
      @if ($results['result']['tests']['favicon']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'favicon' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- charset -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['charset']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.charset')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.charsetExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">


        <p>
          @if( $results['result']['charset'] != null )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.hasCharset') }}
          @else

          {{ __('seo.hasNotCharset') }}
          @endif

        </p>

      </div>
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['charset'] }}</code></div>

      @if ($results['result']['tests']['charset']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'charset' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- Social Media Presence -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['social']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.socialLinks')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.socialExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['social']['status'])

          <strong class="text-success">Congratulations! </strong> {{ __('seo.hasSocial')}}
          @else

          {{ __('seo.hasNotSocial') }}
          @endif

        </p>

      </div>

      <!--collapse-->
      @if ($results['result']['tests']['social']['status'])

      <div class="flex flex-col my-2">
        @foreach ($results['result']['social'] as $key => $social)


        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  {{ $key }} <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($social) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>

                  @if (count($social) > 0)
                  @foreach ($social as $links)
                  <li class="py-1 text-break">
                    <a href=" {{ $links['url'] }}" target="_blank" rel="noopener noreferrer" class="underline">
                      {{ $links['url'] }}
                    </a>

                  </li>

                  @endforeach
                  @endif


                </ol>

              </div>


            </div>
          </div>
        </div>
        @endforeach
      </div>





      @endif



      @if ($results['result']['tests']['social']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'socialLinks' )

              @php echo $content->howtofix; @endphp

              @endif


              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- canonical tag -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['canonicaltag']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.metacanonical')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.metaCanonicalExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             
      <div class="font-inter">


        <p>
          @if( !empty($results['result']['canonicaltag']) )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.canonicaltagPassed') }}
          @else

          {{ __('seo.canonicaltagFailed') }}
          @endif

        </p>

      </div>
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['canonicaltag'] }}</code></div>

      @if ($results['result']['tests']['canonicaltag']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'canonicaltag' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- refresh tag -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['refreshtag']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.metarefresh')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.metaRefreshExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['refreshtag']['status'] == true )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.refreshPassed') }}
          @else

          {{ __('seo.refreshFailed') }}
          @endif

        </p>

      </div>
      @if($results['result']['refreshtag'])
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['refreshtag'] }}</code></div>
      @endif
      @if ($results['result']['tests']['refreshtag']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'metarefresh' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- 404 page -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['404page']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.404error')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.404errorExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if( $results['result']['has_404']['has_notfound'] == true )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.hasFound404') }}
          @else

          {{ __('seo.hasNotFound404') }}
          @endif

        </p>

      </div>


      @if ($results['result']['tests']['404page']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == '404error' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- In-page Links -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['links']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.inpageLinks')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.internalLinksExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @lang('seo.internalLinksCount', ['count' => $results['result']['full_page']['links']['internal']])


        </p>

      </div>

      <!--collapse-->
      @if ($results['result']['full_page']['links']['internal'] > 0)

      <div class="flex flex-col my-2">

        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  @lang('seo.internalLinks')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{
                      $results['result']['full_page']['links']['internal'] ?? '0' }}</div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>
                  @if (count($results['result']['full_page']['links']['links']) > 0)
                  @foreach ($results['result']['full_page']['links']['links'] as $links)
                  @if ($links['internal'] == true)

                  <li class="py-1 text-break">
                    <a href="{{ $links['url'] }}" target="_blank" rel="noopener noreferrer" class="underline">
                      {{ !empty($links['content']) ? $links['content'] : $links['url'] }}
                    </a>

                  </li>

                  @endif
                  @endforeach
                  @endif



                </ol>

              </div>


            </div>
          </div>
        </div>
      </div>

      @endif
      @if ($results['result']['full_page']['links']['external'] > 0)

      <div class="flex flex-col my-2">

        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  @lang('seo.externalLinks')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{
                      $results['result']['full_page']['links']['external'] ?? '0' }}</div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">


                <ol class='reportol'>
                  @if (count($results['result']['full_page']['links']['links']) > 0)
                  @foreach ($results['result']['full_page']['links']['links'] as $links)
                  @if ($links['internal'] == false)
                  <li class="py-1 text-break">
                    <a href="{{ $links['url'] }}" target="_blank" rel="noopener noreferrer" class="underline">
                      {{ !empty($links['content']) ? $links['content'] : $links['url'] }}
                    </a>

                  </li>

                  @endif
                  @endforeach
                  @endif



                </ol>

              </div>


            </div>
          </div>
        </div>
      </div>

      @endif



      @if ($results['result']['tests']['links']['status'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'inpageLinks' )

              @php echo $content->howtofix; @endphp

              @endif


              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- language -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['language']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.language')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.languageExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $results['result']['language'] != null )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.languageDeclared') }}
          @else

          {{ __('seo.languageNotDeclared') }}
          @endif

        </p>

      </div>
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['language'] }}</code></div>

      @if ($results['result']['tests']['language']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'language' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- nofollow tag -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['nofollow']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.nofollow')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.nofollowExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['nofollow']['status'] == true )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.nofollowPassed') }}
          @else

          {{ __('seo.nofollowFailed') }}
          @endif

        </p>

      </div>

      @if ($results['result']['tests']['nofollow']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'nofollow' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- noindex tag -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['noindex']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.noindex')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.noindexExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['nofollow']['status'] == true )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.noindexPassed') }}
          @else

          {{ __('seo.noindexFailed') }}
          @endif

        </p>

      </div>

      @if ($results['result']['tests']['nofollow']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'noindex' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- googlesiteverification  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['googlesiteverification']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.googlesiteverification')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.googlesiteverificationexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['googlesiteverification']['status'] == true )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.googlesiteverificationPassed') }}
          @else

          {{ __('seo.googlesiteverificationFailed') }}
          @endif

        </p>

      </div>

      @if ($results['result']['tests']['googlesiteverification']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'googlesiteverification' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>



<!-- spfRecord  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['spfRecord']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.spfRecord')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.multiCollapsespfRecordExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">


        <p>
          @if( $results['result']['tests']['spfRecord']['status'] == true )

          <strong class="text-success">Congratulations! </strong> {{ __('seo.spfRecordPassed') }}
          @else

          {{ __('seo.spfRecordFailed') }}
          @endif

        </p>

      </div>
      @if ($results['result']['tests']['spfRecord']['status'] == true)
      
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['spfRecord']['txt']}}</code></div>
         
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'spfRecord' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

   
<!--============================================================================================seo report tab end here============================================================================================-->

<!--============================================================================================Speed optimizations report tab start here============================================================================================-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="speed">

  <div class="col-span-12 lg:col-span-6 text-center half">

    <h2 class="text-4xl font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
      <i class="an an-performance text-4xl"></i>
      <span>@lang('seo.speedOptimizations')</span>
    </h2>
  </div>

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--pagesize-->

<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['pagesize']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.pageSize')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.pagesizeExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">
 <p>
         
        @if ($results['result']['tests']['pagesize']['status'])
        
         <strong class="text-success">Congratulations! </strong>   {!!__('seo.pagesizePassedCount', [
              'size' => formatSizeUnits($results['result']['pagesize'] ?? 0),
              'max' => formatSizeUnits(config('artisan.seo.page_size')),
              ])!!}



       

        @else

        <div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">

              {!!__('seo.pagesizeFailedCount', [
              'size' => formatSizeUnits($results['result']['pagesize'] ?? 0),
              'max' => formatSizeUnits(config('artisan.seo.page_size')),
              ])!!}


            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
          </p>
      </div>






      @if ($results['result']['tests']['pagesize']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'pageSize' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!--Dom Size-->

<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['domsize']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.domSize')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.domExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">
<p>
        @if ($results['result']['tests']['domsize']['status'] == true)
 <strong class="text-success">Congratulations! </strong>   {!! __('seo.domPassed', ['size' => $results['result']['domsize']['domsize'], 'max' =>
              config('artisan.seo.dom_size')])
              !!}
        @else

        <div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">

              {!! __('seo.domFailed', [
              'size' => $results['result']['domsize']['domsize'],
              'max' => config('artisan.seo.dom_size'),
              ]) !!}


            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        </p>
      </div>






      @if ($results['result']['tests']['domsize']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'domSize' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!--HTML Compression/GZIP-->
@php
$percentage = round(100 - ($results['result']['pagesize'] / $results['result']['contentsize']) * 100, 0);
$from = formatSizeUnits($results['result']['contentsize']);
$to = formatSizeUnits($results['result']['pagesize']);
$compression = $results['result']['encoding'][0] ?? null;
$langArray = compact('percentage', 'from', 'to', 'compression');
@endphp
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['text_compression']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.textCompression')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.textCompressionExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">
<p>
        @if ($results['result']['tests']['text_compression']['status'] == true)
 <strong class="text-success">Congratulations! </strong> {!! __('seo.textCompressionPassed', $langArray)
              !!}

        @else

        <div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">

              {!! __('seo.textCompressionFailed', $langArray) !!}
              <p class="mb-0">
                <strong>{{ $compression }}</strong>

              </p>
            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        </p>
      </div>






      @if ($results['result']['tests']['text_compression']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'textCompression' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--Load Time-->

<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['loadtime']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.loadTime')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
     <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.loadTimeExplainer', ['recommended' => config('artisan.seo.load_time')])" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
    

      <div class="font-inter">
<p>
        @if ($results['result']['loadtime'] > config('artisan.seo.load_time'))

        <div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">

              {!! __('seo.loadtimeFailedCount', [
              'time' => $results['result']['loadtime'],
              'recommended' => config('artisan.seo.load_time'),
              ]) !!}


            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @else
        
         <strong class="text-success">Congratulations! </strong>     {!!__('seo.loadtimePassedCount', [
              'time' => $results['result']['loadtime'],
              'recommended' => config('artisan.seo.load_time'),
              ]) !!}


        @endif
        </p>
      </div>






      @if ($results['result']['tests']['loadtime']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'loadTime' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- Http Requests-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['httpRequests']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.httpRequests')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.httpRequestExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">



        @if($results['result']['tests']['httpRequests']['status'])

        <strong class="text-success">Congratulations! </strong> {!!__('seo.httpRequestPassedCount', [
        'requests' => $results['result']['httpRequests']['total_requests'] ?? 0,
        'max' => config('artisan.seo.http_requests_limit'),
        ])!!}
        @else

        {!! __('seo.httpRequestFailedCount', [
        'requests' => $results['result']['httpRequests']['total_requests'] ?? 0,
        'max' => config('artisan.seo.http_requests_limit'),
        ]) !!}
        @endif



      </div>

     @if ($results['result']['httpRequests']['total_requests'] > 0)
     
     
      <!--collapse-->
       @foreach ($results['result']['httpRequests']['requests'] as $key => $rqts)
   

      <div class="flex flex-col space-y-4 my-2 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                  {{ $key }} <span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($rqts) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                    
                     @if (count($rqts) > 0)
                                                         @foreach ($rqts as $links)
                                                             <li class="py-1 text-break">
                                                                 <a target="_blank" href="{{ $links }}">{{ $links }}</a></A></li>
                                                         @endforeach
                                                     @endif
               
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>








      @endforeach






      @endif
     

                             
                           


      @if ($results['result']['tests']['httpRequests']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'httpRequests' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!--sitecaching -->

<!--flashobject -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if   ($results['result']['tests']['flashobject']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.flashobject')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
    
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.flashobjectExplainer', ['recommended' => config('artisan.seo.load_time')])" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter">
<p>
        @if   ($results['result']['tests']['flashobject']['status'] == true)
        
         <strong class="text-success">Congratulations! </strong>    {!!__('seo.flashobjectPassed', ['count' => count($results['result']['flashobject']) ?? 0]) !!}


        
        @else
        
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">

             {!! __('seo.flashobjectFailed', ['count' => count($results['result']['flashobject']) ?? 0])!!}
 

            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>






      @if   ($results['result']['tests']['flashobject']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'flashobject' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- imageFormats-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['imageFormats']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.imageFormats')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.imageFormatExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">



        @if($results['result']['tests']['imageFormats']['status'] == true)

        <strong class="text-success">Congratulations! </strong> {!!__('seo.imageFormatsPassedCount', ['count' => count($results['result']['imageFormats']) ?? 0])!!}
        @else

        {!! __('seo.imageFormatsFailedCount', ['count' => count($results['result']['imageFormats']) ?? 0]) !!}
        @endif

      </div>

     @if (count($results['result']['imageFormats']) > 0)
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                 @lang('seo.imagesWithoutWebp')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['imageFormats']) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                    
                     @if (count($results['result']['imageFormats']) > 0)
                                                 @foreach ($results['result']['imageFormats'] as $mages)
                                                             <li class="py-1 text-break">
                                                                 <a target="_blank" href="{{ $mages['url'] }}">{{ $mages['url'] }}</a></A></li>
                                                         @endforeach
                                                     @endif
               
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>
     
      @endif
     

      @if ($results['result']['tests']['imageFormats']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'imageFormats' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- cdn ussage-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="cdnusage">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater cdnusagehide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.cdnusage')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert cdnusagehide" style="display:grid">
    
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!-- Image Cache-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="imagecache">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater imagecachehide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.imgcaching')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert imagecachehide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!--end-->
<!-- Image meta-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="imagemeta">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater imagemetahide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.imgmeta')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert imagemetahide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!-- js Cache-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="jscache">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater jscachehide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.jscaching')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert jscachehide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!-- minify js-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="minifyjs">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater minifyjshide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.jsminification')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert minifyjshide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- js Cache-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="csscache">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater csscachehide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.csscaching')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert csscachehide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!-- minify js-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="minifycss">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater minifycsshide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.cssminification')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert minifycsshide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>



<!-- console errors-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="console">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater consolehide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.console')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert consolehide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>



<!-- Cls -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="cls">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater clshide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.cls')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert clshide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>



<!-- js execution -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="jsexecution">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater jsexecutionhide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.jsexecution')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert jsexecutionhide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--lcp -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="lcp">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater lcphide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.lcp')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert lcphide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>



<!--render blocking -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="renderblocking">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater renderblockinghide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.renderblocking')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert renderblockinghide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- nestedTables -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['nestedTables']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.nestedTables')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsagenestedTablesExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if($results['result']['tests']['nestedTables']['status'] == true)

          <strong class="text-success">Congratulations! </strong> {{__('seo.nestedTablesPassed') }}
          @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
 {{ __('seo.nestedTablesFailed') }}
            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>

         
          @endif

        </p>

      </div>

      @if ($results['result']['tests']['nestedTables']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'nestedTables' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- framesets -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if  ($results['result']['tests']['framesets']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.framesets')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsageframesetsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if ($results['result']['tests']['framesets']['status'] == true)

          <strong class="text-success">Congratulations! </strong> {{__('seo.framesetsPassed') }}
          @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
 {{ __('seo.framesetsFailed') }}
            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>

         
          @endif

        </p>

      </div>

      @if  ($results['result']['tests']['framesets']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'framesets' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- doctype  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['doctype']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.doctype')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsageDoctypeExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if($results['result']['tests']['doctype']['status'] == true)

          <strong class="text-success">Congratulations! </strong> {{ __('seo.doctypePassed') }}
          @else

          {{ __('seo.doctypeFailed') }}
          @endif

        </p>

      </div>
      @if ($results['result']['tests']['doctype']['status'] == true)
      
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['doctype'] }}</code></div>
         
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'doctype' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- redirects  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if  ($results['result']['tests']['redirects']['status'] === true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.redirects')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.multiCollapseredirectsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">


        <p>
          @if ($results['result']['tests']['redirects']['status'] === true)

          <strong class="text-success">Congratulations! </strong> {{ __('seo.redirectsPassed') }}
          @else

          {{  __('seo.redirectsFailed') }}
          @endif

        </p>

      </div>
        @if (count($results['result']['redirects']) > 1)
        
         <div class="badge bg-error/10 text-error dark:bg-error/15 my-2"> @foreach ($results['result']['redirects'] as $redirect)
                                         @if ($loop->iteration != 1)
                                             <span class="px-1 text-error">→</span>
                                         @endif
                                         <code>{{ $redirect['location'] }}</code>
                                     @endforeach</div>
                                
                             @endif
         
     
      @if  ($results['result']['tests']['redirects']['status'] === true)
   
         
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'redirects' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--============================================================================================Speed optimizations report tab end here============================================================================================-->
   <!--============================================================================================Server and Security report tab start here============================================================================================-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="server">

  <div class="col-span-12 lg:col-span-6 text-center half">

    <h2 class="text-4xl font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
      <i class="an an-security text-4xl"></i>
      <span>@lang('seo.serverAndSecurity')</span>
    </h2>
  </div>

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--savebrowsering -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if($results['result']['tests']['savebrowsering']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.savebrowsering')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.savebrowseringexplainer', ['recommended' => config('artisan.seo.load_time')])" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
     

      <div class="font-inter">
<p>
        @if($results['result']['tests']['savebrowsering']['status'] == true)
        
         <strong class="text-success">Congratulations! </strong>    {!!__('seo.savebrowseringPassed')  !!}


        
        @else
        
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">

             {!! __('seo.savebrowseringFailed')!!}
 

            </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>






      @if ($results['result']['tests']['savebrowsering']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'savebrowsering' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- plainEmails-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['plainEmails']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.plainEmail')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.plainEmailExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                          

      <div class="font-inter">



        @if($results['result']['tests']['plainEmails']['status'] == true)

        <strong class="text-success">Congratulations! </strong> {!!__('seo.plainEmailPassed', ['count' => count($results['result']['plainEmails']) ?? 0]) !!}
        @else

        {!!__('seo.plainEmailFailed', ['count' => count($results['result']['plainEmails']) ?? 0]) !!}
        @endif

      </div>

     @if (count($results['result']['plainEmails']) > 0)
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                @lang('seo.plainEmail')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['plainEmails']) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                    
                    @foreach ($results['result']['plainEmails'] as $email)
                                                     <li class="py-1 text-break">
                                                        <a href="mailto: {{ $email }}"> {{ $email }}</a></li>
                                                 @endforeach
               
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>
     
      @endif
     

      @if($results['result']['tests']['plainEmails']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'plainEmail' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--httpsEncryption -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if($results['result']['ssl']['is_valid'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.httpsEncryption')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.httpsEncryptionExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
     
      <div class="font-inter">
<p>
        @if($results['result']['ssl']['is_valid'] == true)
         <strong class="text-success">Congratulations! </strong>    {!! __('seo.sslTestPassed', ['issuer' => $results['result']['ssl']['issuer'] , 'expire_at' => $results['result']['ssl']['expire_at']])  !!}
        @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
             {!! __('seo.sslTestFailed') !!} </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>
      @if ($results['result']['ssl']['is_valid'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'httpsEncryption' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--mixedContent -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if($results['result']['tests']['mixedContent']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.mixedContent')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
    <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.mixedContentExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter">
<p>
        @if($results['result']['tests']['mixedContent']['status'] == true)
         <strong class="text-success">Congratulations! </strong>    {!!  __('seo.mixedContentNo') !!}
        @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
             {!!  __('seo.mixedContentYes') !!} </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>
      @if ($results['result']['tests']['mixedContent']['status'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'mixedContent' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- serverSignature  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['serverSignature']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.serverSignature')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.serverSigExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if($results['result']['tests']['serverSignature']['status'] == true)

          <strong class="text-success">Congratulations! </strong> {{ __('seo.serverNo') }}
          @else

          {{__('seo.serverYes')}}
          @endif

        </p>

      </div>
       @if (count($results['result']['server']) > 0)
         <div class="badge bg-error/10 text-error dark:bg-error/15 my-2">   @foreach ($results['result']['server'] as $server)
                                         <code>{{ $server }}</code>
                                     @endforeach</div>
                                   
                                 @endif
      
      @if ($results['result']['tests']['serverSignature']['status'] == true)
      
    
         
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'serverSignature' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
   <!-- Unsafe Cross-Origin Links -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['coLinks']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.coLinks')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.coLinksExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">



        @if($results['result']['tests']['coLinks']['status'] == true)

        <strong class="text-success">Congratulations! </strong> {!!__('seo.coLinksPassed', ['count' => count($results['result']['unsafeCOLinks']) ?? 0])!!}
        @else

        {!! __('seo.coLinksFailed', ['count' => count($results['result']['unsafeCOLinks']) ?? 0])  !!}
        @endif

      </div>

     @if (!$results['result']['tests']['coLinks']['status'])
      <!--collapse-->
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                @lang('seo.coLinks')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['unsafeCOLinks']) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                    
                   @foreach ($results['result']['unsafeCOLinks'] as $links)
                                                     <li class="py-1 text-break">
                                                         <a href="{{ $links }}" target="_blank"
                                                             rel="noopener noreferrer">{{ $links }}</a>
                                                     </li>
                                                 @endforeach
               
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>
      @endif
     

      @if($results['result']['tests']['coLinks']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'coLinks' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

   <!--http2 -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if($results['result']['tests']['http2']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.http2')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.http2Explainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter">
<p>
        @if($results['result']['tests']['http2']['status'] == true)
         <strong class="text-success">Congratulations! </strong>    {!! __('seo.http2Passed')   !!}
        @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
             {!!  __('seo.http2Failed')!!} </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>
      @if ($results['result']['tests']['http2']['status'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'http2' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--hsts -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if($results['result']['tests']['hsts']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.hsts')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.hstsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter">
<p>
        @if($results['result']['tests']['hsts']['status'] == true)
         <strong class="text-success">Congratulations! </strong>    {!!__('seo.hstsPassed')   !!}
        @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
             {!! __('seo.hstsFailed') !!} </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>
      @if ($results['result']['tests']['hsts']['status'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'hsts' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

   
    <!--============================================================================================Server and Security report tab end here============================================================================================-->
<!--============================================================================================Advance report tab start here============================================================================================-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="advance">

  <div class="col-span-12 lg:col-span-6 text-center half">

    <h2 class="text-4xl font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
      <i class="an an-miscellaneous text-4xl"></i>
      <span>@lang('seo.advance')</span>
    </h2>
  </div>

</div>
<!--end-->
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

   <!-- Structured Data -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['structuredData']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.structuredData')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.structuredDataExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             
      <div class="font-inter">



        @if($results['result']['tests']['structuredData']['status'] == true)

        <strong class="text-success">Congratulations! </strong> {!!__('seo.structuredDataPassed')!!}
        @else

        {!! __('seo.structuredDataFailed') !!}
        @endif

      </div>
<style>
    .unorder{
            list-style: circle ;
    margin-left: 1rem !important;
    }
    .order{
            list-style: decimal ;
    margin-left: 1rem !important;
    }
</style>
     @if(count($results['result']['structuredData']['schema'] ?? []) > 0)
      <!--collapse-->
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
               @lang('seo.schema')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['structuredData']['schema'] ?? []) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <x-seo-og-schema :item="$results['result']['structuredData']['schema']" />


              </div>


            </div>
          </div>
        </div>

      </div>
      @endif
     

      @if($results['result']['tests']['structuredData']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'structuredData' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- viewPort  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['viewPort']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.viewPort')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.viewPortExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">


        <p>
          @if($results['result']['tests']['viewPort']['status'] == true)

          <strong class="text-success">Congratulations! </strong> {{ __('seo.hasViewPort')  }}
          @else

          {{  __('seo.hasNotviewPort')  }}
          @endif

        </p>

      </div>
      @if($results['result']['tests']['viewPort']['status'] == true)
      
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['viewport'] }}</code></div>
         
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'viewPort' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!-- media query -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" id="mediaquery">
  <!--title-->
  
 <div class="col-span-12 lg:col-span-3 text-center quater mediaqueryhide">
    <div class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="spinner h-7 w-7 animate-spin text-primary dark:text-accent">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-full w-full"
      fill="none"
      viewBox="0 0 28 28"
    >
      <path
        fill="currentColor"
        fill-rule="evenodd"
        d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
        clip-rule="evenodd"
      />
    </svg>
  </div>
            <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.mobileresponse')     </p>

      </div>
    </div>
  </div>
<div class="col-span-12 lg:col-span-9 text-center quaterinvert mediaqueryhide" style="display:grid">
   <h2  class="text-2xl">Loading...</h2>
 <div class="progress h-1 bg-slate-150 dark:bg-navy-500">
    <div
      class="is-indeterminate relative w-4/12 rounded-full bg-primary dark:bg-accent"
    ></div>
  </div>
       

  </div>

 

</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>



<!-- Deferjs-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['deferJs']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.deferJS')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.deferJsExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">



        @if($results['result']['tests']['deferJs']['status'] == true)

        <strong class="text-success">Congratulations! </strong> {!!__('seo.deferJSPassed', ['count' => count($results['result']['deferJs']) ?? 0]) !!}
        @else

        {!! __('seo.deferJSFailed', ['count' => count($results['result']['deferJs']) ?? 0]) !!}
        @endif

      </div>

     @if (count($results['result']['deferJs']) > 0)
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
               @lang('seo.deferJsText')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['deferJs']) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                    
                     @foreach ($results['result']['deferJs'] as $defer)
                                                     <li class="py-1 text-break">
                                                         <a href="{{ $defer }}" target="_blank"
                                                             rel="noopener noreferrer">
                                                             {{ $defer }}
                                                         </a>
                                                     </li>
                                                 @endforeach
               
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>
     
      @endif
     

      @if($results['result']['tests']['deferJs']['status'] == true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'deferJs' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--Directory Browsering Check -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['directorybrowsering']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.directorybrowsering')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
      <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.directorybrowseringexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter">
<p>
        @if ($results['result']['tests']['directorybrowsering']['status'] == true)
         <strong class="text-success">Congratulations! </strong>    {!! __('seo.directorybrowseringFailed')  !!}
        @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
             {!! __('seo.directorybrowseringPassed') !!} </div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>
      @if  ($results['result']['tests']['directorybrowsering']['status'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'directorybrowsering' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--Content Length Test -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['contentlength']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.contentlength')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.contentlengthExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
      <div class="font-inter">
<p>
        @if ($results['result']['tests']['contentlength']['status'] == true)
         <strong class="text-success">Congratulations! </strong> @lang('seo.contentlengthCount', ['count' => $results['result']['full_page']['word_count']])
        @else
<div class="alert flex overflow-hidden rounded-lg bg-error/10 text-error my-2 dark:bg-error/15">
          <div class="flex flex-1 items-center space-x-3 p-4">
            <svg class="h-6 text-error dark:text-error" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
            @lang('seo.contentlengthCount', ['count' => $results['result']['full_page']['word_count']])</div>
          </div>

          <div class="w-1.5 bg-error"></div>
        </div>
        @endif
        
        </p>
      </div>
      @if($results['result']['tests']['contentlength']['status'] == true)
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'contentlength' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!-- canonical url  -->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['canonical']['status'] == true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.canonical')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.keywordUsageCanonicalExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">


        <p>
          @if($results['result']['tests']['canonical']['status'] == true)

          <strong class="text-success">Congratulations! </strong> {{  __('seo.canonicalPassed')  }}
          @else

          {{   __('seo.canonicalFailed')  }}
          @endif

        </p>

      </div>
      @if($results['result']['tests']['canonical']['status'] == true)
      
      <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">{{ $results['result']['canonical'] }}</code></div>
         
      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'canonical' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->


<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>


<!-- Disallow Directive-->
<!--start-->

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!--title-->

  <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">

      @if ($results['result']['tests']['is_disallowed']['status'] === true)
      <!--success pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
        <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
      </div>
      @else
      <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
      @endif
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.is_disallowed')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.multiCollapseisdisallowedExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">



        @if($results['result']['tests']['is_disallowed']['status'] === true)

        <strong class="text-success">Congratulations! </strong> 
                                 {{ $results['result']['tests']['is_disallowed']['message'] }}
        @else

        <div class="badge bg-error/10 text-error dark:bg-error/15 my-2">{{ $results['result']['tests']['is_disallowed']['message'] }}</div>
                                
        @endif

      </div>

     @if (!$results['result']['tests']['is_disallowed']['status'])
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
              @lang('seo.disallowedRules')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">{{ count($results['result']['sitemaps']['disallow_rules']) ?? '0' }}
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>
                    
                    @foreach ($results['result']['sitemaps']['disallow_rules'] as $links)
                                                     <li class="py-1 text-break">
                                                         <a href="{{ $links }}" target="_blank"
                                                             rel="noopener noreferrer">{{ $links }}</a>
                                                     </li>
                                                 @endforeach
               
                </ol>


              </div>


            </div>
          </div>
        </div>

      </div>
     
      @endif
     

      @if($results['result']['tests']['is_disallowed']['status'] === true)

      @else
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'is_disallowed' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

      @endif

    </div>

  </div>



</div>
<!--end-->

<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>

<!--============================================================================================Advance report tab end here============================================================================================-->

@else
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<div class="col-span-12 lg:col-span-12 text-center p-5">
   
   <h4 class="py-2">
      To access the complete SEO report, please register or log in
   </h4>
    <div class="tpheader__right d-flex align-items-center justify-content-center">
                       
                         <div class="tpheader__btn ml-25 d-none d-sm-block">
                              <a href="{{route('login')}}" class="tp-header-btn">Login</a>
                           </div>
                           <div class="tpheader__btn ml-25 d-none d-sm-block">
                              <a href="{{route('register')}}" class="tp-header-btn">Register</a>
                           </div>
                           <div class="offcanvas-btn d-xl-none ml-20">
                              <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                           </div>
                     
                        </div>
      </div>
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
@endif
          </div>


<!--main 12 col div end-->
        


        </div>
      </div>

    </div>
  </div>
  </div>
  <br>
   <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            
              <div class="col-span-12 lg:col-span-12">
                <div class="card">
                  <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
                  >
                    <h2
                      class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100"
                    >   @if (!empty($tool->name))
              {{ $tool->name }}
            @endif
          
                    </h2>
                    <div class="flex justify-center space-x-2">
    
            <button data-id="{{ $tool->id }}" type="button" id="buttonlike" data-url="{{ route('tool.favouriteAction') }}" x-data="{isLiked:  @if (Auth::check() && $tool->hasBeenFavoritedBy(Auth::user())) true @else false @endif }" @click="isLiked = !isLiked" class="btn h-9 w-9 bg-slate-150 p-0 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                  
                    <i x-show="!isLiked" class="fa-regular fa-heart text-lg" style="display: none;"></i>
                          <i x-show="isLiked" class="fa-solid fa-heart text-lg text-error"></i>
            </button>
                
                    </div>
                  </div>
                  <div class="p-4 sm:p-5">
            
                    <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
    <x-form method="post" :route="route('tool.handle', $tool->slug)">
                    <label class="p-2" for="">@lang('tools.enterWebsiteUrl')</label>
    
                    <div class="relative flex -space-x-px" style="margin-top: 0.6rem;" >
        <input
          class="form-input peer w-full rounded-l-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
          placeholder="Enter Url..."
          type="text"
          name="url" id="url" type="url" required
                                value="{{ $results['url'] ?? old('url') }}"  
        />
    
        <div
          class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
        >
        <i class="fas fa-globe"></i>
        </div>
    
        <input type="submit" style="min-width: fit-content;"
          class="btn rounded-l-none bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
        value="Generate Report"
          >
        
    
       
                        </div>
                        </x-form>
                        <x-input-error :messages="$errors->get('url')" /> 
                   
                  </div>
                </div>
              </div>
            </div>
               @csrf <!-- Include the CSRF token -->

               @push('page_scripts')
       @if(Auth()->user())
               <script>
    $('document').ready(function(){
        
        css();
        js();
        imgcaching();
        cdn();
        getPageSpeedInsights();
         errorinconsole();
         query();
         
         
    
    })
       function query(){
         $.ajax({
                    url: "{{route('mediaquery')}}", 
                    type: "POST",
                    data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                       
                    
  cls = "";
                     cls +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
         if(response.mediaquery == false){
          cls +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
       $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});   
      }
      else{
      cls+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `
           $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      };
     
     cls+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.mobileresponse')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.mobileresponseExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">`;
      
          if(response.mediaquery == false){
          cls +=`
          {!!__('seo.mediaqueryFailed') !!}
          </div>
    

   `;
          
      }
      else{
      cls+=`
     <strong class="text-success">Congratulations! </strong> {!!__('seo.mediaqueryPassed') !!}
     </div>
    


     `};


cls += `
<img width="195px" height="422px" src="`+ response.screenshot +`" alt="mobile screen shot"/>
`
      

    if(response.mediaquery == false){

     cls+=` 
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'mediaquery' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

 

   `;
          
      }
      else{
    
          
      };
      cls += ` </div>

  </div>`;
                     $('.mediaqueryhide').hide();
                    $('#mediaquery').append(cls);

                               $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
 var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
                      
             
                      
                    },
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                        
                    }
                });
    }
    
    function css(){
         $.ajax({
                    url: "{{route('minifycss')}}", // Replace with your API URL
                    type: "POST",
                    data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
    // This function is called when the request is successful

   minifycss = "";
 minifycss +=`
   <div class="col-span-12 lg:col-span-3 text-center quater">
<div
class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;


if((response.minimizedcssfiles/response.totaljsfiles)*100 < 50 ){  $('.totaltestwarn').each(function() {
    var warn = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(warn) + 1); // Increment and set the new value
});
minifycss +=`
<!--warning pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
<svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
</svg>
</div>
<!--error pass-->

`;

}else  if((response.minimizedcssfiles/response.totaljsfiles)*100 < 70 ){    $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
minifycss +=`
<!--warning pass-->
<!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
<!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
<!--</svg>-->
<!--</div>-->
<!--error pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
<svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
viewBox="0 0 20 20" fill="currentColor">
<path fill-rule="evenodd"
d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
clip-rule="evenodd"></path>
</svg>
</div>
`;

}
else{ 
    $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
minifycss+=`
<!--success pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
<i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
</div>

`};

minifycss+=`
<div class="font-inter">
<p class="text-base font-semibold text-slate-700 dark:text-navy-100">
@lang('seo.cssminification')
</p>

</div>
</div>
</div>

<!--description-->
<div class="col-span-12 lg:col-span-9 text-center quaterinvert">
<div
class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.cssminificationExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             
<div class="font-inter">

This webpage has total `+ response.totalcssfiles +` Css links

</div>`
if(response.minimizedcsslinks.length >0 ){
minifycss +=`

<!--collapse-->


<div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
<div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
<div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
<div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


<div class="flex">
<p class="text-slate-700 line-clamp-1 dark:text-navy-100">
@lang('seo.minimizedlink')<span>
<div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.minimizedcsslinks.length+`
</div>
</span>
</p>

</div>
</div>
<button @click="expanded = !expanded"
class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
<i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
</button>
</div>
<div x-collapse x-show="expanded">
<div class="px-4 py-4 sm:px-5">

<div class="is-scrollbar-hidden min-w-full overflow-x-auto">
<ol class='reportol'>`;
 
 for (var i = 0; i < response.minimizedcsslinks.length; i++) {

minifycss += "<li class='py-1 text-break'><a target='_blank' href='" + response.minimizedcsslinks[i] + "'>" + response.minimizedcsslinks[i] + "</a></li>";
};

                                 
minifycss+=`</ol>


</div>


</div>
</div>
</div>

</div>`;
}
if(response.unminimizedcsslinks.length > 0 ){
minifycss +=`

<!--collapse-->


<div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
<div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
<div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
<div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


<div class="flex">
<p class="text-slate-700 line-clamp-1 dark:text-navy-100">
@lang('seo.unminimizedlink')<span>
<div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.unminimizedcsslinks.length+`
</div>
</span>
</p>

</div>
</div>
<button @click="expanded = !expanded"
class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
<i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
</button>
</div>
<div x-collapse x-show="expanded">
<div class="px-4 py-4 sm:px-5">

<div class="is-scrollbar-hidden min-w-full overflow-x-auto">
<ol class='reportol'>`;
 
 for (var i = 0; i < response.unminimizedcsslinks.length; i++) {

minifycss += "<li class='py-1 text-break'><a target='_blank' href='" + response.unminimizedcsslinks[i] + "'>" + response.unminimizedcsslinks[i] + "</a></li>";
};

                                 
minifycss+=`</ol>


</div>


</div>
</div>
</div>

</div>`;
}

if((response.minimizedcsslinks/response.totaljsfiles)*100 < 70){
minifycss+=` <!--modal-->
<div x-data="{showModal:false}" class="printhide my-2">
<button @click="showModal = true"
class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
How to Fix
</button>
<template x-teleport="#x-teleport-target">
<div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
<div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
@click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
<div
class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0">
<!--modal contnet-->
<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
<div class="col-span-12 lg:col-span-6 text-center half">
<h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
How to Fix
</h2>
</div>
</div>
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!--modal content end-->
@foreach($seotools as $content)
@if($content->seotool == 'cssminification' )

@php echo $content->howtofix; @endphp

@endif

@endforeach
<button @click="showModal = false"
class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
Close
</button>
</div>
</div>

</template>
</div>



</div>

</div>`;

}
else{


};

 $('.minifycsshide').hide();
                      $('#minifycss').append(minifycss);
                          $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
  cachecss = "";
cachecss +=`
   <div class="col-span-12 lg:col-span-3 text-center quater">
<div
class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;


if((response.cache.length/response.totalcssfiles)*100 < 50 ){ $('.totaltestwarn').each(function() {
    var warn = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(warn) + 1); // Increment and set the new value
});
cachecss +=`
<!--warning pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
<svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
</svg>
</div>
<!--error pass-->

`;

}else  if((response.cache.length/response.totalcssfiles)*100 < 70 ){   $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
cachecss +=`
<!--warning pass-->
<!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
<!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
<!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
<!--</svg>-->
<!--</div>-->
<!--error pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
<svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
viewBox="0 0 20 20" fill="currentColor">
<path fill-rule="evenodd"
d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
clip-rule="evenodd"></path>
</svg>
</div>
`;

}
else{ $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
cachecss+=`
<!--success pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
<i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
</div>

`};

cachecss+=`
<div class="font-inter">
<p class="text-base font-semibold text-slate-700 dark:text-navy-100">
@lang('seo.csscaching')
</p>

</div>
</div>
</div>

<!--description-->
<div class="col-span-12 lg:col-span-9 text-center quaterinvert">
<div
class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.csscachingExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

<div class="font-inter">`;

if((response.cache.length/response.totalcssfiles)*100 < 70){
cachecss +=`
{!!__('seo.cacheFailed') !!}
`;

}
else{
cachecss+=`
<strong class="text-success">Congratulations! </strong> {!!__('seo.cachePassed') !!}

`};







cachecss+=` </div>`
if(response.cache.length >0 ){
cachecss +=`

<!--collapse-->


<div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
<div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
<div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
<div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


<div class="flex">
<p class="text-slate-700 line-clamp-1 dark:text-navy-100">
@lang('seo.cachelink')<span>
<div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.cache.length+`
</div>
</span>
</p>

</div>
</div>
<button @click="expanded = !expanded"
class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
<i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
</button>
</div>
<div x-collapse x-show="expanded">
<div class="px-4 py-4 sm:px-5">

<div class="is-scrollbar-hidden min-w-full overflow-x-auto">
<ol class='reportol'>`;
 
 for (var i = 0; i < response.cache.length; i++) {

cachecss += "<li class='py-1 text-break'><a target='_blank' href='" + response.cache[i] + "'>" + response.cache[i] + "</a></li>";
};

                                 
cachecss+=`</ol>


</div>


</div>
</div>
</div>

</div>`;
}
if(response.notcache.length > 0 ){
cachecss +=`

<!--collapse-->


<div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
<div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
<div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
<div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


<div class="flex">
<p class="text-slate-700 line-clamp-1 dark:text-navy-100">
@lang('seo.uncachelink')<span>
<div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.notcache.length+`
</div>
</span>
</p>

</div>
</div>
<button @click="expanded = !expanded"
class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
<i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
</button>
</div>
<div x-collapse x-show="expanded">
<div class="px-4 py-4 sm:px-5">

<div class="is-scrollbar-hidden min-w-full overflow-x-auto">
<ol class='reportol'>`;
 
 for (var i = 0; i < response.notcache.length; i++) {

cachecss += "<li class='py-1 text-break'><a target='_blank' href='" + response.notcache[i] + "'>" + response.notcache[i] + "</a></li>";
};

                                 
cachecss+=`</ol>


</div>


</div>
</div>
</div>

</div>`;
}

if((response.cache.length/response.totalcssfiles)*100 < 70){
cachecss+=` <!--modal-->
<div x-data="{showModal:false}" class="printhide my-2">
<button @click="showModal = true"
class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
How to Fix
</button>
<template x-teleport="#x-teleport-target">
<div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
<div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
@click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
<div
class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0">
<!--modal contnet-->
<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
<div class="col-span-12 lg:col-span-6 text-center half">
<h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
How to Fix
</h2>
</div>
</div>
<div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
<!--modal content end-->
@foreach($seotools as $content)
@if($content->seotool == 'csscaching' )

@php echo $content->howtofix; @endphp

@endif

@endforeach
<button @click="showModal = false"
class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
Close
</button>
</div>
</div>

</template>
</div>



</div>

</div>`;

}
else{


};

 $('.csscachehide').hide();
                      $('#csscache').append(cachecss);
          $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                 var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
},
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                    }
                });
    }
    
   function js(){
    $.ajax({
               url: "{{route('minifyjs')}}", // Replace with your API URL
               type: "POST",
               data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                   '_token': $('meta[name="csrf-token"]').attr('content'),
               },
               success: function(response) {
                   // This function is called when the request is successful
                
                  minifyjs = "";
                minifyjs +=`
                  <div class="col-span-12 lg:col-span-3 text-center quater">
<div
 class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
 

 if((response.minimizedjsfiles/response.totaljsfiles)*100 < 50 ){ $('.totaltestwarn').each(function() {
    var warn = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(warn) + 1); // Increment and set the new value
});
     minifyjs +=`
     <!--warning pass-->
             <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
   <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
</svg>
</div>
 <!--error pass-->

`;
     
 }else  if((response.minimizedjsfiles/response.totaljsfiles)*100 < 70 ){    $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
     minifyjs +=`
     <!--warning pass-->
 <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
 <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
 <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
 <!--</svg>-->
 <!--</div>-->
 <!--error pass-->
 <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
   <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
     viewBox="0 0 20 20" fill="currentColor">
     <path fill-rule="evenodd"
       d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
       clip-rule="evenodd"></path>
   </svg>
 </div>
`;
     
 }
 else{ $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
 minifyjs+=`
       <!--success pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
<i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
</div>
 
`};

minifyjs+=`
 <div class="font-inter">
   <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
     @lang('seo.jsminification')
   </p>

 </div>
</div>
</div>

<!--description-->
<div class="col-span-12 lg:col-span-9 text-center quaterinvert">
<div
 class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.jsminificationExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

 <div class="font-inter">
 
 This webpage has total `+ response.totaljsfiles +` JavaScript links

 </div>`
  if(response.minimizedjslinks.length >0 ){
     minifyjs +=`

 <!--collapse-->


 <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
   <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
     <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
       <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


         <div class="flex">
           <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
            @lang('seo.jsminimizedlink')<span>
               <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.minimizedjslinks.length+`
               </div>
             </span>
           </p>

         </div>
       </div>
       <button @click="expanded = !expanded"
         class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
         <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
       </button>
     </div>
     <div x-collapse x-show="expanded">
       <div class="px-4 py-4 sm:px-5">

         <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
           <ol class='reportol'>`;
                
                for (var i = 0; i < response.minimizedjslinks.length; i++) {

 minifyjs += "<li class='py-1 text-break'><a target='_blank' href='" + response.minimizedjslinks[i] + "'>" + response.minimizedjslinks[i] + "</a></li>";
};
             
                                                
   minifyjs+=`</ol>


         </div>


       </div>
     </div>
   </div>

 </div>`;
  }
  if(response.unminimizedjslinks.length > 0 ){
     minifyjs +=`

 <!--collapse-->


 <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
   <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
     <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
       <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


         <div class="flex">
           <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
            @lang('seo.jsunminimizedlink')<span>
               <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.unminimizedjslinks.length+`
               </div>
             </span>
           </p>

         </div>
       </div>
       <button @click="expanded = !expanded"
         class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
         <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
       </button>
     </div>
     <div x-collapse x-show="expanded">
       <div class="px-4 py-4 sm:px-5">

         <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
           <ol class='reportol'>`;
                
                for (var i = 0; i < response.unminimizedjslinks.length; i++) {

 minifyjs += "<li class='py-1 text-break'><a target='_blank' href='" + response.unminimizedjslinks[i] + "'>" + response.unminimizedjslinks[i] + "</a></li>";
};
             
                                                
   minifyjs+=`</ol>


         </div>


       </div>
     </div>
   </div>

 </div>`;
  }

if((response.minimizedjsfiles/response.totaljsfiles)*100 < 70){
    minifyjs+=` <!--modal-->
 <div x-data="{showModal:false}" class="printhide my-2">
   <button @click="showModal = true"
     class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
     How to Fix
   </button>
   <template x-teleport="#x-teleport-target">
     <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
       x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
       <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
         @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
       <div
         class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
         x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         <!--modal contnet-->
         <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
           <div class="col-span-12 lg:col-span-6 text-center half">
             <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
               How to Fix
             </h2>
           </div>
         </div>
         <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
         <!--modal content end-->
         @foreach($seotools as $content)
         @if($content->seotool == 'jsminification' )

         @php echo $content->howtofix; @endphp

         @endif

         @endforeach
         <button @click="showModal = false"
           class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
           Close
         </button>
       </div>
     </div>

   </template>
 </div>



</div>

</div>`;
     
 }
 else{

     
 };

                $('.minifyjshide').hide();
                                     $('#minifyjs').append(minifyjs);
                               $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                 cachejs = "";
               cachejs +=`
                  <div class="col-span-12 lg:col-span-3 text-center quater">
<div
 class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
 

 if((response.cache.length/response.totaljsfiles)*100 < 50 ){ $('.totaltestwarn').each(function() {
    var warn = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(warn) + 1); // Increment and set the new value
});
    cachejs +=`
     <!--warning pass-->
             <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
   <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
</svg>
</div>
 <!--error pass-->

`;
     
 }else  if((response.cache.length/response.totaljsfiles)*100 < 70 ){    $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
    cachejs +=`
     <!--warning pass-->
 <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
 <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
 <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
 <!--</svg>-->
 <!--</div>-->
 <!--error pass-->
 <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
   <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
     viewBox="0 0 20 20" fill="currentColor">
     <path fill-rule="evenodd"
       d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
       clip-rule="evenodd"></path>
   </svg>
 </div>
`;
     
 }
 else{$('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
cachejs+=`
       <!--success pass-->
<div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
<i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
</div>
 
`};

cachejs+=`
 <div class="font-inter">
   <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
     @lang('seo.jscaching')
   </p>

 </div>
</div>
</div>

<!--description-->
<div class="col-span-12 lg:col-span-9 text-center quaterinvert">
<div
 class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
  <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.jscachingExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

 <div class="font-inter">`;
 
   if((response.cache.length/response.totaljsfiles)*100 < 70){
    cachejs +=`
     {!!__('seo.jscacheFailed') !!}
`;
     
 }
 else{
cachejs+=`
<strong class="text-success">Congratulations! </strong> {!!__('seo.jscachePassed') !!}

`};



 



cachejs+=` </div>`
  if(response.cache.length >0 ){
    cachejs +=`

 <!--collapse-->


 <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
   <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
     <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
       <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


         <div class="flex">
           <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
            @lang('seo.jscachelink')<span>
               <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.cache.length+`
               </div>
             </span>
           </p>

         </div>
       </div>
       <button @click="expanded = !expanded"
         class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
         <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
       </button>
     </div>
     <div x-collapse x-show="expanded">
       <div class="px-4 py-4 sm:px-5">

         <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
           <ol class='reportol'>`;
                
                for (var i = 0; i < response.cache.length; i++) {

cachejs += "<li class='py-1 text-break'><a target='_blank' href='" + response.cache[i] + "'>" + response.cache[i] + "</a></li>";
};
             
                                                
  cachejs+=`</ol>


         </div>


       </div>
     </div>
   </div>

 </div>`;
  }
  if(response.notcache.length > 0 ){
    cachejs +=`

 <!--collapse-->


 <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
   <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
     <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
       <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


         <div class="flex">
           <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
            @lang('seo.jsuncachelink')<span>
               <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.notcache.length+`
               </div>
             </span>
           </p>

         </div>
       </div>
       <button @click="expanded = !expanded"
         class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
         <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
       </button>
     </div>
     <div x-collapse x-show="expanded">
       <div class="px-4 py-4 sm:px-5">

         <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
           <ol class='reportol'>`;
                
                for (var i = 0; i < response.notcache.length; i++) {

cachejs += "<li class='py-1 text-break'><a target='_blank' href='" + response.notcache[i] + "'>" + response.notcache[i] + "</a></li>";
};
             
                                                
  cachejs+=`</ol>


         </div>


       </div>
     </div>
   </div>

 </div>`;
  }

if((response.cache.length/response.totaljsfiles)*100 < 70){
   cachejs+=` <!--modal-->
 <div x-data="{showModal:false}" class="printhide my-2">
   <button @click="showModal = true"
     class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
     How to Fix
   </button>
   <template x-teleport="#x-teleport-target">
     <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
       x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
       <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
         @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
       <div
         class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
         x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         <!--modal contnet-->
         <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
           <div class="col-span-12 lg:col-span-6 text-center half">
             <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
               How to Fix
             </h2>
           </div>
         </div>
         <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
         <!--modal content end-->
         @foreach($seotools as $content)
         @if($content->seotool == 'jscaching' )

         @php echo $content->howtofix; @endphp

         @endif

         @endforeach
         <button @click="showModal = false"
           class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
           Close
         </button>
       </div>
     </div>

   </template>
 </div>



</div>

</div>`;
     
 }
 else{

     
 };

                $('.jscachehide').hide();
                                     $('#jscache').append(cachejs);
                        $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
 var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
               },
               error: function(xhr, status, error) {
                   // This function is called if an error occurs
                   console.error("Error: " + error);
               }
           });
}

     function imgcaching(){
         $.ajax({
                    url: "{{route('imgcaching')}}", // Replace with your API URL
                    type: "POST",
                    data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        // This function is called when the request is successful
                     
                  

                   
                          html = "";
                     html +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
     
      if((response.cache.length/response.totalimgfiles)*100 < 50 ){
          html +=`
          <!--warning pass-->
                  <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
        <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
     </svg>
   </div>
      <!--error pass-->
     
`;
          
      }else  if((response.cache.length/response.totalimgfiles)*100 < 70 ){
          html +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
            $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
      }
      else{
      html+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `
          $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
          
      };
     
     html+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.imgcaching')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.imgcachingExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                          

      <div class="font-inter">`;
      
        if((response.cache.length/response.totalimgfiles)*100 < 70){
          html +=`
          {!!__('seo.imgcacheFailed') !!}
   `;
          
      }
      else{
      html+=`
     <strong class="text-success">Congratulations! </strong> {!!__('seo.imgcachePassed') !!}

     `};



      

   

     html+=` </div>`
       if(response.cache.length >0 ){
          html +=`
     
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                 @lang('seo.imgcachelink')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.cache.length+`
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>`;
                     
                     for (var i = 0; i < response.cache.length; i++) {
     
      html += "<li class='py-1 text-break'><a target='_blank' href='" + response.cache[i] + "'>" + response.cache[i] + "</a></li>";
    };
                  
                                                     
        html+=`</ol>


              </div>


            </div>
          </div>
        </div>

      </div>`;
       }
       if(response.notcache.length > 0 ){
          html +=`
     
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                 @lang('seo.imguncachelink')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.notcache.length+`
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>`;
                     
                     for (var i = 0; i < response.notcache.length; i++) {
     
      html += "<li class='py-1 text-break'><a target='_blank' href='" + response.notcache[i] + "'>" + response.notcache[i] + "</a></li>";
    };
                  
                                                     
        html+=`</ol>


              </div>


            </div>
          </div>
        </div>

      </div>`;
       }
     
 if((response.cache.length/response.totalimgfiles)*100 < 70){
         html+=` <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'imgcaching' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

 

    </div>

  </div>`;
          
      }
      else{
    
          
      };
    
                     $('.imagecachehide').hide();
                                          $('#imagecache').append(html);
                  $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});

                     var imgmeta = "";
                     
                     imgmeta +=`
<div class="col-span-12 lg:col-span-3 text-center quater">
  <div
    class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
  >
    `; 
    if(response.imgmeta == true){
    imgmeta +=`
    <!--warning pass-->
    <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
    <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
    <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
    <!--</svg>-->
    <!--</div>-->
    <!--error pass-->
    <div
      class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error"
    >
      <svg
        class="h-6 text-error dark:text-white"
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
          clip-rule="evenodd"
        ></path>
      </svg>
    </div>
    `; 
           $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
        
    } else{ imgmeta+=`
    <!--success pass-->
    <div
      class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success"
    >
      <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
    </div>

    `
        $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
        
    }; 
    imgmeta+=`
    <div class="font-inter">
      <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
        @lang('seo.imgmeta')
      </p>
    </div>
  </div>
</div>

<!--description-->
<div class="col-span-12 lg:col-span-9 text-center quaterinvert">
  <div
    class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
  >
   
 <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.imgmetaExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
    <div class="font-inter">
      `; 
      
        if(response.imgmeta == true){
            imgmeta
      +=` {!!__('seo.imgmetaFailed') !!} `; } 
      else{ imgmeta+=`
      <strong class="text-success">Congratulations! </strong>
      {!!__('seo.imgmetaPassed') !!} `};
      imgmeta+=`
    </div>
    `;
     if(response.imgmeta == true){
    imgmeta+=`
    <!--modal-->
    <div x-data="{showModal:false}" class="printhide my-2">
      <button
        @click="showModal = true"
        class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90"
      >
        How to Fix
      </button>
      <template x-teleport="#x-teleport-target">
        <div
          class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
          x-show="showModal"
          role="dialog"
          @keydown.window.escape="showModal = false"
        >
          <div
            class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
            @click="showModal = false"
            x-show="showModal"
            x-transition:enter="ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
          ></div>
          <div
            class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
            x-show="showModal"
            x-transition:enter="ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
          >
            <!--modal contnet-->
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
              <div class="col-span-12 lg:col-span-6 text-center half">
                <h2
                  class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left"
                >
                  How to Fix
                </h2>
              </div>
            </div>
            <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
            <!--modal content end-->
            @foreach($seotools as $content) @if($content->seotool ==
            'imgmeta' ) @php echo $content->howtofix; @endphp @endif
            @endforeach
            <button
              @click="showModal = false"
              class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
            >
              Close
            </button>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>
`; } else{ };

                      
                    $('.imagemetahide').hide();
                                          $('#imagemeta').append(imgmeta);  
                                                  $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
 var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
                    },
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                    }
                });
    }
    
       function cdn(){
         $.ajax({
                    url: "{{route('cdn')}}", // Replace with your API URL
                    type: "POST",
                    data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                       
                //   console.log(response);
                     html = "";
                     html +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
      if(response.length >0 ){
          html +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
           $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
      }
      else{
      html+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `
          $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      };
     
     html+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.cdnusage')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.cdnusageExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">`;
      
        if(response.length >0 ){
          html +=`
          {!!__('seo.cdnusageFailed') !!}
   `;
          
      }
      else{
      html+=`
     <strong class="text-success">Congratulations! </strong> {!!__('seo.cdnusagePassed') !!}

     `};



      

   

     html+=` </div>`
       if(response.length >0 ){
          html +=`
     
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                 @lang('CDNs')<span>
                    <div class="badge bg-success/10 text-success dark:bg-success/15 mx-4">`+response.length+`
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>`;
                     
                     for (var i = 0; i < response.length; i++) {
     
      html += "<li class='py-1 text-break'><a target='_blank' href='" + response[i] + "'>" + response[i] + "</a></li>";
    };
                  
                                                     
        html+=`</ol>


              </div>


            </div>
          </div>
        </div>

      </div>
     

      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'cdnusage' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

 

    </div>

  </div>`;
          
      }
      else{
    
          
      };

   

                     $('.cdnusagehide').hide();
                                          $('#cdnusage').append(html);
      $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                     var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
                     
                    },
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                    }
                });
    }
    
        function getPageSpeedInsights(){
         $.ajax({
                    url: "{{route('getPageSpeedInsights')}}", // Replace with your API URL
                    type: "POST",
                    data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        // This function is called when the request is successful
                    
                      


  cls = "";
                     cls +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
      if(response.cls.displayValue > 0.25){
          cls +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
       $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});   
      }else  if(response.cls.displayValue > 0.1){
          cls +=`
          <!--warning pass-->
                <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">
      <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
      </svg>
</div>
  
    
`;
          
      $('.totaltestwarn').each(function() {
    var warn = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(warn) + 1); // Increment and set the new value
}); }
      else{
      cls+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `
           $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      };
     
     cls+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.cls')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.clsexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">`;
      
       if(response.cls.displayValue > 0.1){
          cls +=`
          {!!__('seo.clsFailed') !!}
          </div>
     <div class="badge bg-error/10 text-error dark:bg-error/15 my-2"> <code
          class=" ">`+ response.cls.displayValue +`</code></div>

   `;
          
      }
      else{
      cls+=`
     <strong class="text-success">Congratulations! </strong> {!!__('seo.clsPassed') !!}
     </div>
     <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">`+ response.cls.displayValue +`</code></div>


     `};



      

    if(response.cls.displayValue > 0.1){

     cls+=` 
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'cls' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

           </template>
      </div>

 

   `;
          
      }
      else{
    
          
      };
      cls += ` </div>

  </div>`;
                     $('.clshide').hide();
                    $('#cls').append(cls);

                               $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                      
                      
                      
 jsexecution = "";
                     jsexecution +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
      if(response.jsexecution.numericValue/1000 > 2){
          jsexecution +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
             $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
      }
      else{
          $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      jsexecution+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `};
     
     jsexecution+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.jsexecution')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.jsexecutionexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                           

      <div class="font-inter">`;
      
       if(response.jsexecution.numericValue/1000 > 2){
          jsexecution +=`
          {!!__('seo.jsexecutionFailed') !!}
          </div>
     <div class="badge bg-error/10 text-error dark:bg-error/15 my-2"> <code
          class=" ">`+ response.jsexecution.displayValue +`</code></div>

   `;
          
      }
      else{
      jsexecution+=`
     <strong class="text-success">Congratulations! </strong> {!!__('seo.jsexecutionPassed') !!}
     </div>
     <div class="badge bg-success/10 text-success dark:bg-success/15 my-2"> <code
          class=" ">`+ response.jsexecution.displayValue +`</code></div>


     `};



      

    if(response.jsexecution.numericValue/1000 > 2){

     jsexecution+=` 
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'jsexecution' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

 

    </div>

  </div>`;
          
      }
      else{
    
          
      };
                     $('.jsexecutionhide').hide();
                    $('#jsexecution').append(jsexecution);
                              $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                      lcp = "";
                     lcp +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
       if(response.largestcontentfulpaint[0].numericValue/1000 > 2.5){    $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
          lcp +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
          
      }
      else{ $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      lcp+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `};
     
     lcp+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.lcp')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.lcpExplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                             

      <div class="font-inter">`;
      
    if(response.largestcontentfulpaint[0].numericValue/1000 > 2.5){
          lcp +=`
        The Largest Contentful Paint duration of this webpage is <strong>`+ response.largestcontentfulpaint[0].displayValue +`</strong> seconds. To provide a good user experience, sites should strive to have Largest Contentful Paint of <strong>2.5</strong> seconds or less.
   `;
          
      }
      else{
      lcp+=`
     <strong class="text-success">Congratulations! </strong> The Largest Contentful Paint duration of this webpage is <strong>`+ response.largestcontentfulpaint[0].displayValue +`</strong> seconds. To provide a good user experience, sites should strive to have Largest Contentful Paint of <strong>2.5</strong> seconds or less.

     `};



      

   

     lcp+=` </div>
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                     @lang('Largest Contentful Paint')
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ul class='reportol'>
                
               
                <li class='py-1 text-break'> Selector: <code>`+ response.largestcontentfulpaint[1].details.items[0].node.selector +`</code></li>
                <li class='py-1 text-break'> Selector: <code>`+ response.largestcontentfulpaint[1].details.items[0].node.path +`</code></li>
                <li class='py-1 text-break'> Selector: `+ response.largestcontentfulpaint[1].details.items[0].node.nodeLabel +`</li>

                     </ul>


              </div>


            </div>
          </div>
        </div>

      </div>
     
`;
      
       if(response.largestcontentfulpaint[0].numericValue/1000 > 2.5){
          lcp +=`
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'lcp' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

`;}else{};

lcp+=`
    </div>

  </div>`;
      
   

                     $('.lcphide').hide();
                                          $('#lcp').append(lcp);
                                          
                                                      $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                                          
                                          
                                          
                        renderblocking = "";
                     renderblocking +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
       if(response.renderblockingresources.numericValue/1000 > 2.5){   $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
          renderblocking +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
          
      }
      else{ $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      renderblocking+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `};
     
     renderblocking+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.renderblocking')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.renderblockingexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                          

      <div class="font-inter">`;
      
   if(response.renderblockingresources.numericValue/1000 > 2.5){
          renderblocking +=`
       Eliminate render-blocking resources <strong>`+ response.renderblockingresources.displayValue +`</strong> 
   `;
          
      }
      else{
      renderblocking+=`
     <strong class="text-success">Congratulations! </strong>  <Eliminate render-blocking resources <strong>`+ response.renderblockingresources.displayValue +`</strong>

     `};



      

   

     renderblocking+=` </div>
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                     @lang('Render-blocking resources')
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ul class='reportol'>
                
              `;
                     
                     for (var i = 0; i < response.renderblockingresources.details.items.length; i++) {
     
      renderblocking += "<li class='py-1 text-break'> Source: " + response.renderblockingresources.details.items[i].url + " <br> Size: " + response.renderblockingresources.details.items[i].totalBytes/1000 + "kb <br> Time: " + response.renderblockingresources.details.items[i].wastedMs/1000 + "s</li>";
    };
                  
                                                     
        renderblocking+=`

                     </ul>


              </div>


            </div>
          </div>
        </div>

      </div>
     
`;
      
      if(response.renderblockingresources.numericValue/1000 > 2.5){
          renderblocking +=`
      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'renderblocking' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

`;}else{};

renderblocking+=`
    </div>

  </div>`;
      
   

                     $('.renderblockinghide').hide();
                                          $('#renderblocking').append(renderblocking);
                                          
                                          
                                                       
                                                     $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      
                      var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
                      
                    },
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                    }
                });
    }
    
    
      function errorinconsole(){
         $.ajax({
                    url: "{{route('errorinconsole')}}", // Replace with your API URL
                    type: "POST",
                    data: {'url':' {{ $results['result']['baseUrl'] ?? '' }}',
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                     success: function(response) {
                     
                   
                     html = "";
                     html +=`
                       <div class="col-span-12 lg:col-span-3 text-center quater">
    <div
      class="flex items-center space-x-4 rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
`;
      
      if(response.score < 1){  $('.totaltestfail').each(function() {
    var fail = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(fail) + 1); // Increment and set the new value
});
          html +=`
          <!--warning pass-->
      <!--            <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-warning/10 dark:bg-warning">-->
      <!--  <svg class="h-6 text-warning dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
      <!--    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>-->
      <!--</svg>-->
      <!--</div>-->
      <!--error pass-->
      <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-error/10 dark:bg-error">
        <svg class="h-6 text-error dark:text-white" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
          viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
`;
          
      }
      else{ $('.totaltestpass').each(function() {
    var pass = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(pass) + 1); // Increment and set the new value
});
      html+=`
            <!--success pass-->
   <div class="mask is-star-2 flex h-12 w-12 items-center justify-center bg-success/10 dark:bg-success">
     <i class="fa-solid fa-check text-2xl text-success dark:text-white"></i>
     </div>
      
     `};
     
     html+=`
      <div class="font-inter">
        <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
          @lang('seo.console')
        </p>

      </div>
    </div>
  </div>

  <!--description-->
  <div class="col-span-12 lg:col-span-9 text-center quaterinvert">
    <div
      class="text-left rounded-2xl border border-slate-150 p-4 dark:border-navy-600 hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
       <div class="col-auto d-none d-lg-block d-md-block f-right">
                         <div class="icon-question" title="@lang('seo.consoleexplainer')" data-bs-toggle="tooltip"
                             data-bs-placement="left">?</div></div>
                            

      <div class="font-inter">`;
      
        if(response.score < 1 ){
          html +=`
          {!!__('seo.consoleFailed') !!}
   `;
          
      }
      else{
      html+=`
     <strong class="text-success">Congratulations! </strong> {!!__('seo.consolePassed') !!}

     `};



      

   

     html+=` </div>`
       if(response.score < 1){
          html +=`
     
      <!--collapse-->

  
      <div class="flex flex-col my-2 space-y-4 sm:space-y-5 lg:space-y-6 ">
        <div x-data="{expanded:false}" class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500">
          <div class="flex items-center justify-between bg-slate-150 px-4 py-1 dark:bg-navy-500 sm:px-5">
            <div class="flex items-center space-x-3.5 tracking-wide outline-none transition-all">


              <div class="flex">
                <p class="text-slate-700 line-clamp-1 dark:text-navy-100">
                 @lang('seo.consoleerrors')<span>
                    <div class="badge bg-error/10 text-error dark:bg-error/15 mx-4">`+response.details.items.length+`
                    </div>
                  </span>
                </p>

              </div>
            </div>
            <button @click="expanded = !expanded"
              class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
              <i :class="expanded && '-rotate-180'" class="fas fa-chevron-down text-sm transition-transform"></i>
            </button>
          </div>
          <div x-collapse x-show="expanded">
            <div class="px-4 py-4 sm:px-5">

              <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <ol class='reportol'>`;
                     
                     for (var i = 0; i < response.details.items.length; i++) {
     
      html += "<li class='py-1 text-break'>" + response.details.items[i].description + " <br> Source: " + response.details.items[i].source + "<br> Line: " + response.details.items[i].sourceLocation.line + "</li>";
    };
                  
                                                     
        html+=`</ol>


              </div>


            </div>
          </div>
        </div>

      </div>
     

      <!--modal-->
      <div x-data="{showModal:false}" class="printhide my-2">
        <button @click="showModal = true"
          class="btn bg-error font-medium text-white hover:bg-error-focus hover:shadow-lg hover:shadow-error/50 focus:bg-error-focus focus:shadow-lg focus:shadow-error/50 active:bg-error-focus/90">
          How to Fix
        </button>
        <template x-teleport="#x-teleport-target">
          <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300"
              @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
              x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div
              class="relative max-w-2xl max-h-[calc(100vh-120px)] overflow-auto modals  rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
              x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100" x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
              <!--modal contnet-->
              <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
                <div class="col-span-12 lg:col-span-6 text-center half">
                  <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100 text-left">
                    How to Fix
                  </h2>
                </div>
              </div>
              <div class="my-5 h-px bg-slate-200 dark:bg-navy-500"></div>
              <!--modal content end-->
              @foreach($seotools as $content)
              @if($content->seotool == 'console' )

              @php echo $content->howtofix; @endphp

              @endif

              @endforeach
              <button @click="showModal = false"
                class="btn mt-6 fa-pull-right bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                Close
              </button>
            </div>
          </div>

        </template>
      </div>

 

    </div>

  </div>`;
          
      }
      else{
    
          
      };

   

                     $('.consolehide').hide();
                                          $('#console').append(html);
          $('.totaltest').each(function() {
    var total = $(this).text(); // Get the current text
    $(this).html(""); // Clear the content
    $(this).append(parseInt(total) + 1); // Increment and set the new value
});
                     var totalpass = parseInt($('#totaltestpass').text());
                     var totalfail = parseInt($('#totaltestfail').text());
                     var totalwarn = parseInt($('#totaltestwarn').text());
                     var totaltest = parseInt($('#totaltest').text());
                     var result = totalpass/totaltest*100;
                     graph(result);
                     let rw = (totalwarn/totaltest*100) + '%';
                     let rp = (totalpass/totaltest*100) + '%';
                     let rf = (totalfail/totaltest*100) + '%';
                     $('#barwarn').css('width',rw);
                     $('#barpass').css('width',rp);
                      $('#barfail').css('width',rf);
                     
                    },
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                    }
                });
    }
</script>
       @endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
        <script>
         $(document).ready(function() {
    var $box = $('.fixeds');
    var boxPosition = $box.offset().top;
    var bodyHeight = $('body').height();

    $(window).scroll(function() {
        var scrollPosition = $(window).scrollTop();
        var windowHeight = $(window).height();

        if (scrollPosition / bodyHeight >= 0.03) {
            $box.addClass('fixes');
        } else {
            $box.removeClass('fixes');
        }
    });
});
    //  var Wus = {
    //       workingHours: {
    //               colors: ["#0EA5E9"],
    //               series: [50],
    //               labels: ['Cricket'],
    //               chart: { height: 210, type: "radialBar" },
    //               plotOptions: {
    //                 radialBar: {
    //                   hollow: { margin: 0, size: "70%" },
    //                   dataLabels: {
    //                     name: { show: !1 },
    //                     value: {
    //                       show: !0,
    //                       color: "#333",
    //                       offsetY: 10,
    //                       fontSize: "24px",
    //                       fontWeight: 600,
    //                     },
    //                   },
    //                 },
    //               },
    //               grid: {
    //                 show: !1,
    //                 padding: { left: 0, right: 0, top: 0, bottom: 0 },
    //               },
    //               stroke: { lineCap: "round" },
    //             },
    //       }
    
    
function graph(ser){
    var options = {
              series: [ser],
              chart: {
              height: 350,
              type: 'radialBar',
              toolbar: {
                show: true
              }
            },
            plotOptions: {
              radialBar: {
                startAngle: -135,
                endAngle: 225,
                 hollow: {
                  margin: 0,
                  size: '60%',
                  background: '#fff',
                  image: undefined,
                  imageOffsetX: 0,
                  imageOffsetY: 0,
                  position: 'front',
                  dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 0,
                    blur: 4,
                    opacity: 0.24
                  }
                },
                    track: {
                      background: '#fff',
                  strokeWidth: '50%',
                  margin: 0, // margin is in pixels
                  dropShadow: {
                    enabled: true,
                    top: -3,
                    left: 0,
                    blur: 4,
                    opacity: 0.35
                  }
                },
            
                dataLabels: {
                  show: true,
                  name: {
                    offsetY: -10,
                    show: true,
                    color: '#888',
                    fontSize: '17px'
                  },
                  value: {
                    formatter: function(val) {
                      return parseInt(val);
                    },
                    color: '#111',
                    fontSize: '36px',
                    show: true,
                  }
                }
              }
            },
            fill: {
              type: 'gradient',
              gradient: {
                shade: 'dark',
                type: 'horizontal',
                shadeIntensity: 0.5,
                gradientToColors: ['#ABE5A1'],
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100]
              }
            },
            stroke: {
              lineCap: 'round'
            },
            labels: ['Your score'],
            };
    var chartDiv = document.getElementById("chart");
    chartDiv.innerHTML = ""
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        
    }
    
    graph(@if(!empty($results['result']['test_count']['percentage'])) {{ $results['result']['test_count']['percentage']}} @endif);
    
//     setTimeout(function() {
//   graph(100);
//   alert();
// }, 10000);
    
       
     function printreport() {
        var printContents = document.querySelector('.printable-container');
        var originalContents = document.body.innerHTML;
    
        document.body.innerHTML = printContents.outerHTML;
        var t =  document.body.innerHTML;
        var url ="{{ $results['result']['baseUrl'] ?? '' }}";
          var scs =$('#deskss').attr('src');
         
        $('body').append(
            `<div id="load">
            <div id="app-loader" class="loading-overlay">
    <div class="loading"></div>
</div>
</div>
            `

        );
$.post("{{ route('report') }}",
{
 'report': t,
 'url': url,
 'ss': scs,
 "_token": "{{ csrf_token() }}",
},
function(data){
  console.log(data);
    $("#load").remove();
    window.print();
    document.body.innerHTML = originalContents;
});
       
    }
    
    
    $('#buttonlike').click(function(){
    
    var ids =$(this).attr("data-id");
     
    $.post("{{ route('tool.favouriteAction') }}",
      {
        'id': ids,
        "_token": "{{ csrf_token() }}",
      },
      function(data){
    
      });
    
    });


        </script>
    @endpush

  @endif
           
          
   <!--footer-->
            <br>
            

                    
                    <x-tool-content :tool="$tool" />
              
 
     
                    

     
    
       
       
       
      
    </x-application-tools-wrapper>
    