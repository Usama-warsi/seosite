@props([
    'tool' => false,
])
<style>
    .no-shadow .box-shadow{
        box-shadow: none !important;
    }
</style>
<div {!! $attributes->merge(['class' => 'wrap-content', 'id']) !!}>
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
                  <div
                    class="flex flex-col items-center space-y-4 border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5"
                  >
                  @if (!empty($tool->description))
                <p>{{ $tool->description ?? '' }}</p>
            @endif
                  </div>
                  <div class="p-4 sm:p-5 no-shadow">
                 
    {{ $slot }}
</div>

</div>


@push('page_scripts')
<script>$('#buttonlike').click(function(){
    
    var ids =$(this).attr("data-id");
     
    $.post("{{ route('tool.favouriteAction') }}",
      {
        'id': ids,
        "_token": "{{ csrf_token() }}",
      },
      function(data){
    
      });
    
    });</script>
    @endpush