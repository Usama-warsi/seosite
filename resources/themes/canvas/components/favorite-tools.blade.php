@props(['tools'])
<div class="products">
    <div class="row">
        @guest
            <div class="col-md-12">
                <div class="favorite-tools text-center">
                    <h6 class="p-2">@lang('tools.favoriteToolsGuestDesc')</h6>
                    <a class="btn btn-primary rounded-pill ps-5 pe-5 mt-3" href="{{ route('login') }}">@lang('auth.login')</a>
                </div>
            </div>
        @elseif($tools)
          <h2 class="text-lg" style="margin: 2rem 0;font-size:2rem">Favorite Tools</h2>
                <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                @foreach ($tools as $tool)
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
                               

        @else
            <div class="col-md-12">
                <div class="favorite-tools text-center">
                    <h6 class="p-2">@lang('tools.favoriteToolsAuthDesc')</h6>
                </div>
            </div>
        @endguest
    </div>
</div>

  