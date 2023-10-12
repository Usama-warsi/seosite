  <style>
      .tp-header-btn{display:flex !important;}
  </style>
  <header>
      <div id="header-sticky" class="tptransparent__header header-1 ">
         <div class="tp-header-top">
            <div class="container">
               <div class="tp-mega-menu-wrapper">
                  <div class="row align-items-center">
                     <div class="col-xxl-2 col-xl-2 col-lg-6 col-6">
                        <div class="tplogo__area">
                           <a href="{{route('front.index')}}">
                               <x-application-logo />
                           </a>
                        </div>
                     </div>
                     <div class="col-xxl-8 col-xl-7 col-lg-7 d-none d-xl-block">
                        <div class="tpmenu__area main-mega-menu text-center">
                           <nav class="tp-main-menu-content">
                              <ul>
                                 <li>
                                    <a href="{{route('front.index')}}">Home</a>
                                   
                                 </li>
                                 <li><a href="{{route('front.tools')}}">All Tools</a></li>
                                <!--<li><a href="{{route('plans.list')}}">Pricing</a></li>-->
                                <li><a href="{{route('blog.show')}}">Blogs</a></li>
                              </ul>
                           </nav>
                        </div>
                     </div>
                     <div class="col-xxl-2 col-xl-3 col-lg-6 col-6">
                        <div class="tpheader__right d-flex align-items-center justify-content-end">
                         @if(Auth()->user())
                          <div class="tpheader__btn ml-25 d-none d-sm-block d-flex">
                              <a href="{{route('front.dashboard')}}" target="_blank" class="tp-header-btn">Dashboard <svg xmlns="http://www.w3.org/2000/svg" height="1.6rem" width="1.6rem" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                          </svg></a>
                           </div>
                           <!--<div class="tpheader__btn ml-25 d-none d-sm-block">-->
                           <!--  <form action="{{route('logout')}}"method="post">-->
                           <!--      @CSRF-->
                           <!--       <button type="submit" class="tp-header-btn"></button>-->
                           <!--  </form>-->
                           <!--</div>-->
                           <div class="offcanvas-btn d-xl-none ml-20">
                              <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                           </div>
                         
                         @else
                         <div class="tpheader__btn ml-25 d-none d-sm-block">
                              <a href="{{route('login')}}" class="tp-header-btn">Login</a>
                           </div>
                           <div class="tpheader__btn ml-25 d-none d-sm-block">
                              <a href="{{route('register')}}" class="tp-header-btn">Register</a>
                           </div>
                           <div class="offcanvas-btn d-xl-none ml-20">
                              <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                           </div>
                         @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
        
      </div>
   </header>