<!doctype html>
<html class="no-js" lang="zxx">


<head>
     <!-- CSS here -->
   <link rel="stylesheet" href="{{asset('public/front/assets/css/bootstrap.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/animate.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/swiper-bundle.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/slick.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/nouislider.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/magnific-popup.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/font-awesome-pro.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/spacing.css')}}">
   <link rel="stylesheet" href="{{asset('public/front/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('public/build/assets/font.css')}}">
        @vite(['resources/themes/canvas/assets/js/app.js'])

 @meta_tags()
    @meta_tags('header')
    @stack('page_header')
    @if (setting('enable_header_code', 0))
        {!! setting('header_code') !!}
    @endif
 <meta name="app-search" content="{{ route('search') }}">
  
</head>

<body>

   <div id="scroll-indicator"></div> 
   
   <!-- pre loader area start -->
   <div id="loading">
      <div id="loading-center">
         <div id="loading-center-absolute">
            <!-- loading content here -->
            <div class="tp-preloader-content">
               <div class="tp-preloader-logo">
                  <div class="tp-preloader-circle">
                     <svg width="190" height="190" viewBox="0 0 380 380" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle stroke="#D9D9D9" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round"></circle> 
                        <circle stroke="red" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round"></circle> 
                     </svg>
                  </div>
                  <img src="/public/front/assets/img/logo/preloader/preloader-icon.svg" class="preloaderimg" alt="preloader logo">
               </div>
               <p class="tp-preloader-subtitle">Loading</p>
            </div>
         </div>
      </div>  
   </div>
   <!-- pre loader area end -->


   <!-- back to top start -->
   <div class="back-to-top-wrapper">
      <button id="back_to_top" type="button" class="back-to-top-btn">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
               stroke-linejoin="round" />
         </svg>
      </button>
   </div>
   <!-- back to top end -->
   <x-partials.front-theme.header></x-partials.front-theme.header>
<main>  
   
   
   
   
  {{ $slot }}
   
    @if(!empty(session::get('tool')))
  @else
   <x-application-footer></x-application-footer>
  @endif>

</main>
 
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

   <!-- JS here -->
   <script src="{{asset('public/front/assets/js/vendor/waypoints.js')}}"></script>
   <script src="{{asset('public/front/assets/js/bootstrap-bundle.js')}}"></script>
   <script src="{{asset('public/front/assets/js/meanmenu.js')}}"></script>
   <script src="{{asset('public/front/assets/js/swiper-bundle.js')}}"></script>
   <script src="{{asset('public/front/assets/js/slick.js')}}"></script>
   <script src="{{asset('public/front/assets/js/nouislider.js')}}"></script>
   <script src="{{asset('public/front/assets/js/magnific-popup.js')}}"></script>
   <script src="{{asset('public/front/assets/js/parallax.js')}}"></script>
   <script src="{{asset('public/front/assets/js/nice-select.js')}}"></script>
   <script src="{{asset('public/front/assets/js/wow.js')}}"></script>
   <script src="{{asset('public/front/assets/js/isotope-pkgd.js')}}"></script>
   <script src="{{asset('public/front/assets/js/purecounter.js')}}"></script>
   <script src="{{asset('public/front/assets/js/imagesloaded-pkgd.js')}}"></script>
   <script src="{{asset('public/front/assets/js/parallax-scroll.js')}}"></script>
   <script src="{{asset('public/front/assets/js/ajax-form.js')}}"></script>
   <script src="{{asset('public/front/assets/js/main.js')}}"></script>
</body>

@meta_tags('footer')
    @stack('page_scripts')
</html>