<x-canvas-layout>
    <style>
       .border-ri{
            border-right:solid 1px #fff; padding-right:1rem;
       }
       .nav-social.style2 li .btn-social {
    display: block;
    border-radius: 0;
    padding: 0.8rem 0.5rem;
    margin-right: 1rem;
    border-radius: 5px;
}
    </style>
    <!-- blog-details-area-start -->
      <section class="blog-details-area blog-details-bg pb-120 pt-200"
         data-background="@if ($post->getFirstMediaUrl('featured-image')){{ $post->getFirstMediaUrl('featured-image') }}@endif" style="background-image: url(&quot;@if ($post->getFirstMediaUrl('featured-image')){{ $post->getFirstMediaUrl('featured-image') }}@endif&quot;);">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="blog-details-content">
                     <div class="blog-details-tag">
                          @foreach ($post->categories as $category)
                                 
                                    <span><a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a></span>
                                @endforeach
                     
                     </div>
                     <h4 class="blog-details-banner-title">{{ $post->title }}</h4>
                     <div class="d-flex">
                            <span class="border-ri">
                                 <a href="#" class="d-flex align-center justify-content-center text-white  ">
                                       @if ($post->author->getFirstMediaUrl('avatar'))
                      
                                       <img src="{{ $post->author->getFirstMediaUrl('avatar') }}" style="margin-top:-5px;margin-right:0.5rem" width="40px" alt="Profile-Image">
                            @else
                              
                                   <img src="{{ setting('default_user_image') }}" style="margin-top:-5px;margin-right:0.5rem" width="40px" alt="Profile-Image">
                            @endif
                           
                                {{ $post->author->name }}
                           </a>
                            </span>
                             <span class="d-flex align-center justify-content-center text-white  px-1">
                           <i style="    margin: 5px 8px 0 1rem;">
                              <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                    d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                 <path
                                    d="M10.5967 10.226L8.42672 8.93099C8.04872 8.70699 7.74072 8.16799 7.74072 7.72699V4.85699"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                              </svg>
                           </i>
                          {{ $post->created_at->format('M d') }} <span class="mx-1">/</span>
                                {{ $post->created_at->diffForHumans() }}
                        </span>
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="inner-shape-dots">
            <img src="assets/img/shape/inner-dots-shape.png" alt="">
         </div>
      </section>
      <!-- blog-details-area-end -->
    <!-- postbox-area-start -->
      <section class="postbox-area mt-90 pb-120">
         <div class="container">
            <div class="row">
               <div class="col-lg-9">
                  <div class="postbox-area-wrap">
                     <div class="postbox-main">
                        <div class="postbox-single-text">
                          <x-ad-slot :advertisement="get_advert_model('post-above')" />
                    {!! $post->contents !!}
                        </div>
                      
                        <div class="tagcloud mt-3">
                             @foreach ($post->tags as $tag)
                               <a href="{{ route('blog.tag', $tag->slug) }}">{{ $tag->name }}</a>
                        
                        @endforeach
                          
                        </div>
                     </div>
                  
                  </div>
                    <x-page-social-share :url="route('posts.show', ['slug' => $post->slug])" :title="$post->title" />
               </div>
              @if (!Widget::group('post-sidebar')->isEmpty())
            <x-application-sidebar>
                @widgetGroup('post-sidebar')
            </x-application-sidebar>
    
    @endif
            </div>
         </div>
      </section>
  
    <x-ad-slot :advertisement="get_advert_model('post-below')" />
   

</x-canvas-layout>