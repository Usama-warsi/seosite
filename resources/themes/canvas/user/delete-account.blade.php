<x-user-profile :title="__('profile.deleteAccount')">
<div class="p-4 sm:p-5">
<p class="mb-4 p-5">
        <i class="fas fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
        {!! __('profile.deleteAccountHelp', ['days' => setting('restore_user_cutoff', 30)]) !!}
        <i class="fas fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
    </p>
<x-form :route="route('user.deleteAccount.action')">
        @method('DELETE')

               
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">
            
                  <label class="block">
                    <span>@lang('admin.password')</span>
                    <span class="relative mt-1.5 flex">
                      <input type="password" name="password"
                placeholder="@lang('admin.enterPassword')" class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" >
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-regular fa-eye text-base"></i>
                      </span>
                    </span>
                  </label>
      
                  <!-- <label for="checkConfirmDelete"
                class="form-label d-block {{ $errors->has('checkConfirmDelete') ? ' is-invalid' : '' }}">
                <input type="checkbox" name="checkConfirmDelete" id="checkConfirmDelete">
                @lang('profile.confirmDeleteAccount')
            </label> -->

            <label class="inline-flex items-center space-x-2">
        <input
          x-model="selectedFruits"
          value="apple"
          class="form-checkbox is-outline h-5 w-5 rounded-full border-slate-400/70 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
          type="checkbox" name="checkConfirmDelete" id="checkConfirmDelete"
        />
        <p> @lang('profile.confirmDeleteAccount')</p>
      </label>


                </div>
               
              
              
              <button style="margin-top: 1rem;" type="submit" class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
              @lang('profile.deleteMyAccount')
              </button>
              </x-form>
              </div>



</x-user-profile>
