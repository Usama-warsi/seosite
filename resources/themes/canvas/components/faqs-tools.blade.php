@props([
    'faqs' => null,
])
@if ($faqs->count() > 0)
 
    <div class="resizing-accordion section-padding max-900">
        <div class="container">
            <div class="hero-title center my-5 bold">
                <h2 class="h1">@lang('tools.frequentlyAskedQuestions')</h2>
                <p>@lang('tools.frequentlyAskedQuestionsDesc')</p>
            </div>
            <div class="mb-3 mt-4">
       <div
    x-data="{expandedItem:null}"
    class="flex flex-col space-y-4 sm:space-y-5 lg:space-y-6 max-900"
  >
  
     @foreach ($faqs as $faq)
                        <div
      x-data="accordionItem('{{ $faq->id }}')"
      class="overflow-hidden rounded-lg border border-slate-150 dark:border-navy-500"
    >
      <div
        class="flex items-center justify-between bg-slate-150 px-4 py-4 dark:bg-navy-500 sm:px-5"
      >
        <div
          class="flex items-center space-x-3.5 tracking-wide outline-none transition-all"
        >
         
          <div>
            <p class="text-slate-700 line-clamp-1 dark:text-navy-100 mb-0">
                {{ $faq->question }}
            </p>
           
          </div>
        </div>
        <button
          @click="expanded = !expanded"
          class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
        >
          <i
            :class="expanded && '-rotate-180'"
            class="fas fa-chevron-down text-sm transition-transform"
          ></i>
        </button>
      </div>
      <div x-collapse x-show="expanded">
        <div class="px-4 py-4 sm:px-5">
         {!! $faq->answer !!}
         
        </div>
      </div>
    </div>
                    @endforeach
  </div>
              
            </div>
        </div>
    </div>
@endif
