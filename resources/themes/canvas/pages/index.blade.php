@php
$how = "How to Fix"
@endphp



<x-front-layout>
   
    <x-page-wrapper :title="$page->title" :sub-title="$page->excerpt" heading="h1">
        {!! $page->content !!}
    </x-page-wrapper>
    
    @if(!empty($page->howtofix))
      <x-page-wrapper :title="$how" heading="h2">
        {!! $page->howtofix !!}
    </x-page-wrapper>
    @endif

</x-front-layout>