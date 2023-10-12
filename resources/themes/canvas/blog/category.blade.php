<x-application-blog-wrapper>
    <x-page-wrapper class="bg-transparent" :title="$category->name" :sub-title="$category->description" heading="h1">
        <div class="row blog-posts">
            @foreach ($posts as $post)
                @php
                    $dynamic_class = $loop->index > 0 && ($loop->iteration % 7 == 6 || $loop->iteration % 7 == 0) ? 'list-view' : 'grid-view';
                    $columns = $loop->index > 0 && in_array($loop->iteration % 7, [2, 3, 4, 5]) ? 6 : 12;
                @endphp
             
                 <div class="col-lg-6 col-md-6">
                           <div class="tpblog-item-2 mb-30">
                               @if ($post->getFirstMediaUrl('featured-image'))
                            <div class="tpblog-thumb-2">
                                 <a href="{{ route('posts.show', ['slug' => $post->slug]) }}"><img src="{{ $post->getFirstMediaUrl('featured-image') }}" alt="{{ $post->title }}"></a>
                              </div>
                        @endif
                             
                              <div class="tpblog-wrap">
                                 <div class="tpblog-content-2">
                                       @foreach ($post->categories as $category)
                                         <span><a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a></span>
                                       
                                    @endforeach
                                 
                                    <h4 class="tpblog-title-2"><a href="{{ route('posts.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h4>
                                 </div>
                                 <div class="tpblog-meta-2">
                                    <span>
                                       <i>
                                          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M15 8C15 11.864 11.864 15 8 15C4.136 15 1 11.864 1 8C1 4.136 4.136 1 8 1C11.864 1 15 4.136 15 8Z" stroke="#565764" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                             <path d="M10.5967 10.226L8.42672 8.93099C8.04872 8.70699 7.74072 8.16799 7.74072 7.72699V4.85699" stroke="#565764" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          </svg>
                                       </i>
                                      {{ $post->created_at->format('M d') }} <span
                                        class="mx-1">/</span>
                                    {{ $post->created_at->diffForHumans() }}
                                    </span>
                                    <span>
                                       <a href="#">
                                          <i>
                                             <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.99976 7.98487C8.92858 7.98487 10.4922 6.42125 10.4922 4.49243C10.4922 2.56362 8.92858 1 6.99976 1C5.07094 1 3.50732 2.56362 3.50732 4.49243C3.50732 6.42125 5.07094 7.98487 6.99976 7.98487Z" stroke="#565764" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M13 14.9697C13 12.2665 10.3108 10.0803 7 10.0803C3.68917 10.0803 1 12.2665 1 14.9697" stroke="#565764" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                             </svg>
                                          </i>
                                       {{ $post->author->name }}
                                       </a>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
            @endforeach
        </div>
    </x-page-wrapper>
</x-application-blog-wrapper>
