<x-canvas-layout>
  <section class="breadcrumb-area breadcrumb-overlay p-relative pb-115 pt-195" data-background="/public/front/assets/img/breadcrumb/breadcrumb-bg-1.jpg" style="background-image: url('/public/front/assets/img/breadcrumb/breadcrumb-bg-1.jpg'); background-attachment: scroll; background-size: auto;">
      
       <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content breadcrumb__content-2 text-center p-relative z-index-1">
                     <h3 class="breadcrumb__title">Blog</h3>
                     <x-application-breadcrumbs />
                  </div>
               </div>
            </div>
         </div>
         <div class="inner-shape-dots">
            <img src="/public/front/assets/img/shape/inner-dots-shape.png" alt="">
         </div>
      </section>
  <section>
      <div class="container">
            <div class="row">
        <div class="col-md-9">{{ $slot }}</div>
    
    @if (!Widget::group('post-sidebar')->isEmpty())
            <x-application-sidebar>
                @widgetGroup('post-sidebar')
            </x-application-sidebar>
    
    @endif
 </div>
      </div>
  </section>
   
</x-canvas-layout>
