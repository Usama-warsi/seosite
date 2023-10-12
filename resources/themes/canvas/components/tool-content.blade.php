@props(['tool'])

<x-ad-slot />
            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mb-3">
            
            <div class="col-span-12 lg:col-span-12">
              <div class="card">
                <div
                  class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
                >
                {!! $tool->content !!}
                </div>
              </div>
            </div>
          </div>
        
          @if (setting('display_socialshare_icon', 1) == 1)
<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 ">
            
            <div class="col-span-12 lg:col-span-12">
              <div class="card">
                <div
                  class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
                >
                  
                <x-page-social-share element-classes="justify-content-between" style="style3" :url="route('tool.show', ['tool' => $tool->slug])"
          :title="$tool->meta_title" />
                </div>
              </div>
            </div>
          </div>
@endif