<x-user-profile :title="empty(Auth::user()->google2fa_secret) ? __('profile.setupAuthApp') : __('profile.2faDescription')" :sub-title="empty(Auth::user()->google2fa_secret) ? __('profile.setupAuthAppDesc') : __('profile.disable2faHelp')">
    @if (empty(Auth::user()->google2fa_secret))
    <x-form :route="route('user.twofactor.update')">
    <ol class="timeline max-w-sm p-5">
    <li class="timeline-item">
      <div
        class="timeline-item-point rounded-full bg-slate-300 dark:bg-navy-400"
      ></div>
      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
          <p
            class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0"
          >
          @lang('admin.email'):
          </p>
        
        </div>
        <p class="py-1">{{ Auth::user()->email }}</p>
      </div>
    </li>
    <li class="timeline-item">
      <div
        class="timeline-item-point rounded-full bg-primary dark:bg-accent"
      ></div>
      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
          <p
            class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0"
          >
          @lang('profile.manualKey'):
          </p>
          
        </div>
        <p class="py-1">{{ $secret }}</p>
      </div>
    </li>
    <li class="timeline-item">
      <div class="timeline-item-point rounded-full bg-success"></div>
      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
          <p
            class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0"
          >
          @lang('profile.scanQrCode')
          </p>
       
        </div>
        <p class="py-1">
        @lang('profile.scanQrCodeHelp')
        </p>
        <div class="text-start">
                            @if (Str::of($qr_image)->startsWith('data:image'))
                                <img src="{!! $qr_image !!}" alt="Scan Me">
                            @else
                                {!! $qr_image !!}
                            @endif
                        </div>
      </div>
    </li>
    <li class="timeline-item">
      <div class="timeline-item-point rounded-full bg-warning"></div>
      <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
        <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
          <p
            class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0"
          >
          @lang('profile.verifyCodeFromApp')
          </p>
      
        </div>
        <label class="block " style="margin-top: 1rem;">
    <input     name="code"
      class="form-input w-full rounded-full border border-slate-300 bg-transparent px-4 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
      placeholder="code"
      type="text"
      required
    />
  </label>
    
      </div>
    </li>
   
  </ol>
              
    
  <button style="margin-bottom: 1rem; margin-left:1rem"  type="submit" class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Continue
              </button>
   
                </x-form>







    @else
        <div class="form-group mb-3">
            <a class="btn btn-danger" href="{{ route('user.twofactor.disable') }}">@lang('profile.disable2fa')</a>
        </div>
    @endif
</x-user-profile>
