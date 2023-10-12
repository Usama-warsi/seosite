<x-user-profile :title="__('common.editProfile')">
    <x-form :route="route('user.profile.update')" enctype="multipart/form-data">
    
           
              <div class="p-4 sm:p-5">
                <div class="flex flex-col">
                  <span class="text-base font-medium text-slate-600 dark:text-navy-100">@lang('profile.image')</span>
          <label
    class="btn bg-slate-150 max-w-44 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
  >
    <input
      tabindex="-1" name="image"
      type="file"
      class="pointer-events-none absolute inset-0 h-full w-full opacity-0"
    />
    <div class="flex items-center space-x-2">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"
        />
      </svg>
      <span>Choose File</span>
    </div>
  </label>
                </div>
                <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                  <label class="block">
                    <span>@lang('tools.fullName')</span>
                    <span class="relative mt-1.5 flex">
                      <input  name="name" required value="{{ $user->name }}" s class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter name" type="text">
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-regular fa-user text-base"></i>
                      </span>
                    </span>
                  </label>
                  <label class="block">
                    <span>@lang('profile.username')</span>
                    <span class="relative mt-1.5 flex">
                      <input name="username" required value="{{ $user->username }}" class="form-input peer w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Enter full name" type="text">
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-regular fa-user text-base"></i>
                      </span>
                    </span>
                  </label>
      
                
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 mt-5">
                  <label class="block">
    <textarea
    name="about"
      rows="4"
      placeholder="Enter Text"
      class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
    >{{ $user->about }}</textarea>
  </label>
                
                </div>
              
              
              <button type="submit" class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Save
              </button>
   
              </div>
           
    </x-form>
</x-user-profile>
