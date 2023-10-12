<x-user-profile :title="__('common.changePassword')">
    <x-form :route="route('user.password.update')">
             <div class="p-4 sm:p-5">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1">
                <label class="block">
                    <span>@lang('profile.enterCurrentPassword')</span>
                    <span class="relative mt-1.5 flex">
                      <input  name="current_password" required value=""  class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="@lang('profile.enterCurrentPassword')" type="text">
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-regular fa-eye text-base"></i>
                      </span>
                    </span>
                  </label>
                  <label class="block">
                    <span>@lang('profile.enterNewPassword')</span>
                    <span class="relative mt-1.5 flex">
                      <input  id="pwd1"  name="new_password" required value=""  class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="@lang('profile.enterNewPassword')" type="text">
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-regular fa-eye text-base"></i>
                      </span>
                    </span>
                  </label>
                  <label class="block">
                    <span>@lang('profile.confirmNewPassword')</span>
                    <span class="relative mt-1.5 flex">
                      <input id="pwd2"  name="password_confirmation" required value="" class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="@lang('profile.confirmNewPassword')" type="text">
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-regular fa-eye text-base"></i>
                      </span>
                    </span>
                  </label>
                  <p id="status"></p>
                </div>
<br>
              <button id="btn1" type="submit" class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Save
              </button>
              </div>

              
    
    </x-form>
<script>
    // Get references to the password fields and the button
const passwordField1 = document.getElementById('pwd1');
const passwordField2 = document.getElementById('pwd2');
const submitButton = document.getElementById('btn1');
const status = document.getElementById('status');

// Add event listeners to the password fields
passwordField1.addEventListener('input', validatePassword);
passwordField2.addEventListener('input', validatePassword);

// Function to validate the password fields
function validatePassword() {
  const password1 = passwordField1.value;
  const password2 = passwordField2.value;

  // Enable the button if passwords match, otherwise disable it
  if (password1 === password2) {
    submitButton.disabled = false;
    status.style.color = 'Green';
    status.innerHTML = 'Password matched';
  } else {
    submitButton.disabled = true;
    status.style.color = 'red';
    status.innerHTML = 'Password not matched';
  }
}

</script>
</x-user-profile>
