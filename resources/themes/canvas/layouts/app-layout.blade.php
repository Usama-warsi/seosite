<x-partials.head></x-partials.head>
 @if(!empty(Session::get('tool')))
<x-partials.sidebar></x-partials.sidebar>
@endif
<x-partials.header></x-partials.header>
 @if(!empty(Session::get('tool')))
<x-partials.rightsidebar></x-partials.rightsidebar>
@endif
 <x-application-messages />
<main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="h-10"></div>

{{ $slot }}
  @if(!empty(session::get('tool')))
  @else
   <x-application-footer></x-application-footer>
  @endif
</main>
@meta_tags('footer')
    @stack('page_scripts')
<x-partials.footer></x-partials.footer>
