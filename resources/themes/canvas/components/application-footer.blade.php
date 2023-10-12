@if (setting('footer_copyright_bar', 1) == 1 || setting('footer_widgets', 1) == 1)
    <footer class="footer">
        @if (setting('footer_widgets', 1) == 1)
            <div class="contant">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                        <div class="footer-widget footer-col-1 mb-40">
                           <div class="footer-widget-logo mb-20">
                              <a href="{{route('front.index')}}">
                                      @if (!empty(setting('website_logo_dark')))
        <img src="{{ setting('website_logo_dark') }}" alt="{{ config('app.name') }}" class="logo-dark w-50">
    @endif
                              </a>
                           </div>
                           <div class="footer-widget-content">
                              <p class="footer-widget-text mb-20">Find comprehensive search engine optimization (SEO) tools for your site.
</p>
                              <div class="footer-widget-social">
                                 <span>Follow Us On</span>
                                 <a href="https://wwww.facebook.com/seositechecker/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                 <a href="https://www.pinterest.com/seositechecker/" target="_blank"><i class="fa-brands fa-pinterest"></i></a>
                                 <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                 <!--<a href="#"><i class="fa-brands fa-vimeo-v"></i></a>-->
                              </div>
                           </div>
                        </div>
                     </div>
                    
                        @for ($i = 1; $i <= setting('footer_widget_columns', 4); $i++)
                            <div class="{{ bsColumns(setting('footer_widget_columns', 4)) }}">
                                @if (!Widget::group("footer-{$i}")->isEmpty())
                                    @widgetGroup("footer-{$i}")
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endif
        @if (setting('footer_copyright_bar', 1) == 1)
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12{{ setting('footer_center_copyright', 1) == 1 ? ' text-center' : '' }}">
                            {!! sanitize_html(
                                setting(
                                    '_footer_copyright',
                                    '© 2023 All rights reserved By: <a href="https://seositechecker.pro">Seo Site Checker</a>',
                                ),
                            ) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </footer>
@endif
