 @props([
    'results' => null,
    'tool' => null,
    'seotools' => null,
])


  @if (isset($results))
<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

  <div class="col-span-12 lg:col-span-12">
    <div class="card">
      <div
        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100"> Report Result
        </h2>
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
          <div class="col-span-12 lg:col-span-7 " id="overview">
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
                        <p class="py-1">
                        <div class="progress h-2 bg-primary/15 dark:bg-primary/25">
                          <div class=" rounded-full bg-primary"
                            style="width:100%">
                          </div>
                        </div>
                        </p>


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
                        <p class="py-1">
                        <div class="progress h-2 bg-success/15 dark:bg-success/25">
                          <div class=" rounded-full bg-success"  id="barpass"
                            style="width:{{$results['result']['test_count']['passed']/$results['result']['test_count']['total']*100}}%">
                          </div>
                        </div>
                        </p>


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
                        <p class="py-1">
                        <div class="progress h-2 bg-warning/15 dark:bg-warning/25">
                          <div class="rounded-full bg-warning"  id="barwarn"
                          style="width:0%"></div>
                        </div>
                        </p>

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

                        <p class="py-1">
                        <div class="progress h-2 bg-error/15 dark:bg-error/25">
                          <div class="rounded-full bg-error" id="barfail"
                            style="width:{{$results['result']['test_count']['failed']/$results['result']['test_count']['total']*100}}%">
                          </div>
                        </div>
                        </p>
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
                  <img class="w-100" src="{{ generateScreenshot($results['result']['baseUrl']) }}">
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

          </div>


<!--main 12 col div end-->
        


        </div>
      </div>

    </div>
  </div>
  </div>
 
               @csrf <!-- Include the CSRF token -->

               @push('page_scripts')
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
        <script>
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
                  strokeWidth: '67%',
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
        var url = 'test test test';
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
document.addEventListener('DOMContentLoaded', function() {
  const links = document.querySelectorAll('a[href^="#"]');

  // Add a new variable to store the desired scroll speed.
  const scrollSpeed = 100; // milliseconds per pixel

  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();


      const targetId = this.getAttribute('href').substring(1);
      const targetElement = document.getElementById(targetId);
   scrollToElement(targetElement, scrollSpeed); 
      if (targetElement) {
        // Update the scrollIntoView() call to pass in the desired scroll speed.
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start', // You can adjust the scrolling position if needed
        
        });
      }
    });
  });
});


function scrollToElement(element, scrollSpeed) {
  const startPosition = window.scrollY;
  const endPosition = element.getBoundingClientRect().top;
  const scrollDistance = endPosition - startPosition;

  const animationDuration = scrollDistance / scrollSpeed;

  const animationStart = performance.now();

  function animationStep() {
    const elapsedTime = performance.now() - animationStart;
    const progress = elapsedTime / animationDuration;

    if (progress >= 1) {
      window.scrollTo(0, endPosition);
      return;
    }

    const scrollPosition = startPosition + progress * scrollDistance;
    window.scrollTo(0, scrollPosition);

    requestAnimationFrame(animationStep);
  }

  requestAnimationFrame(animationStep);
}
        </script>
    @endpush

  @endif
           
