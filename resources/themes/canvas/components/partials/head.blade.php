<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta tags  -->
 
    @meta_tags()
    @meta_tags('header')
    @stack('page_header')
    @if (setting('enable_header_code', 0))
        {!! setting('header_code') !!}
    @endif
    <link rel="icon" type="image/png" href="   {{ $slot }}" />

    <!-- CSS Assets -->
    @vite(['resources/themes/canvas/assets/sass/app.scss', 'resources/themes/canvas/assets/js/app.js'])

    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    <!-- Javascript Assets -->
    <script src="{{asset('js/app.js')}}" defer></script>
    <!-- Fonts -->
 <meta name="app-search" content="{{ route('search') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
      /**
       * THIS SCRIPT REQUIRED FOR PREVENT FLICKERING IN SOME BROWSERS
       */
      localStorage.getItem("_x_darkMode_on") === "true" &&
        document.documentElement.classList.add("dark");
    </script>
      <style>
      

      .modals::-webkit-scrollbar {
        width: 4px;
      }
      
      /* Track */
      .modals::-webkit-scrollbar-track {
        box-shadow: transparent; 
        border-radius: 10px;
      }
       .dark .dark\:bg-error {
          background-color: rgb(255 87 36)
      }
      /* Handle */
      .modals::-webkit-scrollbar-thumb {
        background: grey; 
        border-radius: 10px;
      }
        .printheader{
            display:none;
        }
         .google-search-preview  {
      background:#fff;
      }
        .google-search-preview .site-url {
          color: #006621;
          font-size: 14px;
          line-height: 1.3;
          margin: 3px 0;
      }
        .google-search-preview .site-title {
          color: #1a0dab;
          font-size: 20px;
          line-height: 26px;
          font-weight: 400;
      }
      .google-search-preview .site-description {
          color: #4d5156;
          font-size: 14px;
          line-height: 1.58;
          font-weight: 400;
      }
      .google-search-preview.mobile-version {
          max-width: 342px;
      }
      .google-search-preview.desktop-version {
          max-width: 600px;
      }
      
      .reportol{
          list-style:decimal;
          padding: revert;
      }
           @media print {
         
          .pagebreak {
            page-break-after: always; 
           
          }
          .card{
                  background: transparent !important;
          box-shadow: none;
          border: none;
          }
          .apexcharts-menu-icon, .printhide{
          display: none;
      }
      
          .half{
                  grid-column: span 6/span 6 !important;
          }
          .quater{
                grid-column: span 3/span 3 !important;
          }
           .quaterinvert{
                grid-column: span 9/span 9 !important;
          }
          .printable-container{
              padding: 0 2rem;
            
          }
          .printheader{
            display:block;
        }
           @page { size: A4 Potrait; margin:100mm 100mm 100mm 100mm; }
        }
        .fixeds{
            transition:0.5s ease;
        }
      .fixes{
          position:fixed;
          bottom:10%;
          right:0.5rem;
          background-color:#fff !important;
          border-radius:20px;
          box-shadow:2px 2px 30px #0002;
      }
       </style>
      @if(empty(Session::get('tool')))
        <style>
      .main-content {
           margin-left:0px; 
            padding-left: 0px;
        padding-right: 0px;
      
        margin:0 auto;
        margin-top:3rem 
      }
        </style>
       <link rel="stylesheet" href="{{asset('public/front/assets/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('public/front/assets/css/main.css')}}">
      @endif
      
       
  </head>
  <x-application-back-to-top />
  <body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- App preloader-->
    
   @if(Session::Get('tool'))
    <div
      class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900"
    >
      <div class="app-preloader-inner relative inline-block h-48 w-48">  
                   </div>
    </div>
   @else
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
                  <img src="/public/front/assets/img/logo/preloader/preloader-icon.svg" alt="preloader logo" class="preloaderimg" >
               </div>
               <p class="tp-preloader-subtitle">Loading</p>
            </div>
         </div>
      </div>  
   </div>
   @endif
  

    <!-- Page Wrapper -->
    <div
      id="root"
      class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900"
      x-cloak
    >

