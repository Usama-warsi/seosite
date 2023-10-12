@props([
    'route' => route('admin.pages.store'),
    'title' => __('admin.createPage'),
    'button_text' => __('common.save'),
    'page' => null,
    'locales',
    'seotools' => array('title'=>'Title', 
    'metaDescription'=>'Meta Description',
   
    'metarefresh' => 'Meta Refresh',
    'googleSearchPreview' => 'Google Search Results Preview Test',
    'headings' => "Headings",
    'mostCommonKeywords' => 'Most Common Keywords',
    '404error' => 'Custom 404 Error Pages',
    'imageAltText' => 'Image Alt Text',
    'inpageLinks' => 'In-page Links',
    'language' => 'Language',
    'favicon' => "Favicon",
    'has_robots_txt' => "Robots.txt",
    'nofollow' => "Nofollow Tag",
    'noindex' => "NoIndex Tag",
    'spfRecord' => "SPF Records",
    'redirects' => "URL Redirects",
    'friendly' => "SEO Friendly URL",
    'domSize' => 'Dom Size',
    'loadTime' => 'Load time',
     'pageSize' => 'Page size',
    'HTTPSEncryption' => 'HTTPS encryption',
    'httpRequests' => "Http Requests",
    'imageFormats' => "Modern Image Format",
    'imagesWithoutWebp' => "Images",
    'textCompression' => "HTML Compression/GZIP",
     'plainEmail' => "Plaintext Email",
     'deferJS' => "Defer Javascript",
     'doctype' => "Doctype",
     'nestedTables' => "Nested Tables",
     'framesets' => "Framesets",
      'cssminification' => 'CSS Minification',
       'jsminification' => 'JavaScript Minification',
     'sitecaching' => 'Page Cache Test (Server Side Caching)',
     'csscaching' => 'CSS Caching',
     'jscaching' => 'JavaScript Caching',
     'imgcaching' => 'Image Caching',
    'httpsEncryption' => "SSL Checker and HTTPS Test",
    'mixedContent' => "Mixed Content (HTTP over HTTPS)",
     'serverSignature' => "Server Signature",
     'coLinks' => "Unsafe Cross-Origin Links ",
      'http2' => "HTTP2 Test",
      'hsts' => "HSTS",
      'socialMediaMetaTags' => 'Social Media Meta Tags',
      'structuredData' => "Structured Data",
      'viewPort' => "Meta Viewport",
      'mediaquery' => 'Media Query',
    'mobileresponse' => 'Mobile Snapshot',
    'charset' => "Charset Declaration",
    'sitemaps' => "Sitemaps",
    'socialLinks' => "Social Media Presence",
    'contentlength' => "Content Length Test",
    'inlineCss' => "Inline CSS",
    'depHtml' => "Deprecated HTML Tags",
    'canonical' => "URL Canonicalization",
    'canonicaltag' => "Meta Canonical",
    'analytics' => "Google Analytics",
    'is_disallowed' => "Disallow Directive",
    'keywordUsageTest' => "Keywords Usage",
    'keywordUsageTestLong' => "Long Tail Keywords Usage",
    'friendly' => "SEO Friendly URL",
    'googlesiteverification' =>'Google Site Verification',
    'directorybrowsering' =>'Directory Browsering Check',
    'jsexecution' =>'JavaScript execution time',
     'cls' =>'Cumulative Layout Shift',
     'console' =>'Console Errors',
     'renderblocking' =>'Render Blocking Resources',
     'savebrowsering' =>'Save Browsering Test',
     'cdnusage' =>'CDN Usage Test',
     'lcp' =>'Largest Contentful Paint Test',
     'flashobject' => 'Flash Test',
     'imgmeta' => 'Image Metadata Test',
    )
])

<form action="{{ $route }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="published" value="1">
    <input type="hidden" name="id" value="{{ $page->id ?? null }}">
    <div class="row">
        <div class="col-md-12">
            @if ($locales->count() !== 1)
                <ul class="nav nav-tabs mb-3" role="tablist">
                    @foreach ($locales as $locale)
                        <li class="nav-item">
                            <a class="nav-link @if ($loop->first) active @endif" data-coreui-toggle="tab"
                                href="#locale_{{ $locale->locale }}" role="tab" aria-controls="{{ $locale->name }}">
                                <i class="icon-arrow-right"></i> {{ $locale->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="tab-content">
        @foreach ($locales as $locale)
            @if (isset($page))
                @php($page_locale = $page->translate($locale->locale))
            @endif
            <div class="tab-pane @if ($loop->first) active @endif" id="locale_{{ $locale->locale }}">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">{{ $title }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <input
                                            class="form-control @error($locale->locale . '.title') is-invalid @enderror slug_title"
                                            id="{{ $locale->locale }}-title" placeholder="@lang('common.title')"
                                            name="{{ $locale->locale }}[title]"
                                            value="{{ $page_locale->title ?? old($locale->locale . '.title') }}"
                                            type="text" @if ($loop->first) required autofocus @endif>
                                        @error($locale->locale . '.title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <input
                                            class="form-control @error($locale->locale . '.slug') is-invalid @enderror slug"
                                            id="{{ $locale->locale }}-slug" name="{{ $locale->locale }}[slug]"
                                            placeholder="@lang('common.slug')"
                                            value="{{ $page_locale->slug ?? old($locale->locale . '.slug') }}"
                                            type="text" @if ($loop->first) required @endif>
                                        @error($locale->locale . '.slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <span class="small text-muted">@lang('common.slugHelp')</span>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <textarea id="{{ $locale->locale }}_editor" name="{{ $locale->locale }}[content]" class="editor">{!! $page_locale->content ?? old($locale->locale . '.content') !!}</textarea>
                                    </div>
                                </div>
                                 <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                         <label for="{{ $locale->locale }}-how-to-fix"><h2>@lang('How to Fix')</h2></label>
                                        <textarea id="{{ $locale->locale }}_how-to-fix" name="{{ $locale->locale }}[howtofix]" class="editor">{!! $page_locale->howtofix ?? old($locale->locale . '.howtofix') !!}</textarea>
                                    <p>use this only when you create page for seo site check up tools</p>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <div class="col-md-12">
                                        <textarea class="form-control @error($locale->locale . '.excerpt') is-invalid @enderror"
                                            id="{{ $locale->locale }}-excerpt" placeholder="@lang('common.excerpt')" name="{{ $locale->locale }}[excerpt]">{{ $page_locale->excerpt ?? old($locale->locale . '.excerpt') }}</textarea>
                                        <span class="small text-muted">@lang('common.excerptHelp')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit"> {{ $button_text }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">@lang('common.seoSettings')</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-meta_title">@lang('common.metaTitle')</label>
                                    <input
                                        class="form-control @error($locale->locale . '.meta_title') is-invalid @enderror"
                                        id="{{ $locale->locale }}-meta_title" name="{{ $locale->locale }}[meta_title]"
                                        value="{{ $page_locale->meta_title ?? old($locale->locale . '.meta_title') }}"
                                        type="text">
                                    <span class="small text-muted">@lang('common.metaTitleHelp')</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-meta_description">@lang('common.metaDescription')</label>
                                    <textarea class="form-control @error($locale->locale . '.meta_description') is-invalid @enderror"
                                        id="{{ $locale->locale }}-meta_description" name="{{ $locale->locale }}[meta_description]">{{ $page_locale->meta_description ?? old($locale->locale . '.meta_description') }}</textarea>
                                    <span class="small text-muted">@lang('common.metaDescriptionHelp')</span>
                                </div>
                            </div>
                        </div>
                         <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">@lang('Seo Tools')</h6>
                            </div>
                            <div class="card-body">
                                <!--<div class="form-group mb-3">-->
                                <!--    <label for="{{ $locale->locale }}-seotool">@lang('SEO Tools')</label>-->
                                <!--    <input-->
                                <!--        class="form-control @error($locale->locale . '.seotool') is-invalid @enderror"-->
                                <!--        id="{{ $locale->locale }}-seotool" name="{{ $locale->locale }}[seotool]"-->
                                <!--        value="{{ $page_locale->seotool ?? old($locale->locale . '.seotool') }}"-->
                                <!--        type="text">-->
                                <!--   <span class="small text-muted">use this only when you create page for seo site check up tools</span>-->
                                <!--</div>-->
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-seotool">@lang('SEO Tools')</label>
                                  <select  class="form-control @error($locale->locale . '.seotool') is-invalid @enderror"
                                        id="{{ $locale->locale }}-seotool" name="{{ $locale->locale }}[seotool]">
                                      @if(isset($page_locale->seotool))
                                      <option value="#" selected>choose tool</option>
                                      @else
                                      <option value="#" >choose tool</option>
                                      @endif
                                         @foreach($seotools as $keys => $values)
                                      
                                      @if(isset($page_locale->seotool) && $page_locale->seotool == $keys)
                                      <option value="@lang($keys)" selected>@lang($values)</option>
                                      @else
                                      <option value="@lang($keys)" >@lang($values)</option>
                                      @endif
                                      @endforeach
                                      
                                   
                                      
                                  </select>
                                   <span class="small text-muted">use this only when you create page for seo site check up tools</span>
                                </div>
                               
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">@lang('common.ogSettings')</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-og_title">@lang('common.ogTitle')</label>
                                    <input
                                        class="form-control @error($locale->locale . '.og_title') is-invalid @enderror"
                                        id="{{ $locale->locale }}-og_title" name="{{ $locale->locale }}[og_title]"
                                        value="{{ $page_locale->og_title ?? old($locale->locale . '.og_title') }}"
                                        type="text">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}-og_description">@lang('common.ogDescription')</label>
                                    <textarea class="form-control @error($locale->locale . '.og_description') is-invalid @enderror"
                                        id="{{ $locale->locale }}-og_description" name="{{ $locale->locale }}[og_description]">{{ $page_locale->og_description ?? old($locale->locale . '.og_description') }}</textarea>
                                    <span class="small text-muted">@lang('common.ogDescriptionHelp')</span>
                                </div>
                                @if (isset($page_locale) && $page_locale->og_image)
                                    <div class="form-group mb-2">
                                        <img src="{{ url($page_locale->og_image) }}" class="img-fluid rounded">
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <label for="{{ $locale->locale }}_og_image"
                                        class="form-col-form-label">@lang('common.image')</label>
                                    <div class="input-group">
                                        <input
                                            class="form-control @error($locale->locale . '.og_image') is-invalid @enderror filepicker"
                                            id="{{ $locale->locale }}_og_image"
                                            name="{{ $locale->locale }}[og_image]"
                                            value="{{ $page_locale->og_image ?? old($locale->locale . '.og_image') }}"
                                            type="file">
                                        <span class="small text-muted">@lang('common.ogImageHelp')</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</form>

@section('footer_scripts')
    <script src="{{ asset('themes/admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        document.querySelectorAll('.editor').forEach(elem => {
            ClassicEditor.create(elem, {
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            },
                        ]
                    },
                    simpleUpload: {
                        uploadUrl: '{{ route('uploader.upload') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    },
                })
                .then(editor => {})
                .catch(error => {
                    console.log('error', error);
                });
        });
    </script>
@endsection
