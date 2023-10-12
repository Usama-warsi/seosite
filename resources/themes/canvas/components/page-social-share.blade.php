@props(['url', 'title', 'elementClasses' => 'mb-3', 'style' => 'style2'])
<div class="d-flex align-items-center flex-column flex-md-row justify-content-between {{ $elementClasses }}">
    <div class="fw-bold me-2">
        <h3 class="mb-0">@lang('profile.shareOnSocialMedia')</h3>
    </div>
     
            <div class="offcanvas__social  {{ $style }}">
              <a title="@lang('profile.shareToBrand', ['brand' => 'Facebook'])" data-bs-toggle="tooltip" data-placement="top"
                href="https://www.facebook.com/share.php?u={{ urlencode($url) }}&amp;quote={{ urlencode($title) }}"
                rel="nofollow noreferrer noopener"><i class="fab fa-facebook-f"></i></a> 
                <a title="@lang('profile.shareToBrand', ['brand' => 'Twitter'])" data-bs-toggle="tooltip" data-placement="top"
              
                href="https://twitter.com/intent/tweet?text={{ urlencode($title) }} {{ urlencode($url) }}"
                rel="nofollow noreferrer noopener"><i class="fab fa-twitter"></i></a>
               <a title="@lang('profile.shareToBrand', ['brand' => 'Pinterest'])" data-bs-toggle="tooltip" data-placement="top"
              
                href="https://pinterest.com/pin/create/link/?url={{ urlencode($url) }}"><i class="fab fa-pinterest"></i></a>
               <a title="@lang('profile.shareToBrand', ['brand' => 'Reddit'])" data-bs-toggle="tooltip" data-placement="top"
              
                href="https://www.reddit.com/submit?url={{ urlencode($url) }}&amp;title={{ urlencode($title) }}"><i class="fab fa-reddit"></i></a>
               <a title="@lang('profile.shareToBrand', ['brand' => 'WhatsApp'])" data-bs-toggle="tooltip" data-placement="top" target="_top"
               
                href="whatsapp://send?text={{ urlencode($title) }}%20%0A{{ urlencode($url) }}"><i class="fab fa-whatsapp"></i></a>
                  <a title="@lang('profile.emailThisPage')" data-bs-toggle="tooltip" data-placement="top"
               
                href="mailto:?body={{ __('profile.shareToEmailText', ['title' => urlencode($title), 'url' => urlencode($url)]) }}"
                rel="nofollow noreferrer noopener"><i class="fa fa-share"></i></a>
            </div>
   
</div>
@push('page_scripts')
    <script>
        const SocialApp = function() {
            const popupSize = {
                width: 780,
                height: 550
            };
            const initEvents = function() {
                if (((navigator.userAgent.match(/Android|iPhone/i) && !navigator.userAgent.match(/iPod|iPad/i)) ?
                        true : false)) {
                    document.querySelector(".btn-whatsapp").parentNode.classList.remove('d-none');
                }
                document.querySelectorAll('.social-share').forEach(element => {
                    element.addEventListener('click', e => {
                        e.preventDefault()
                        var verticalPos = Math.floor((window.innerWidth - popupSize.width) / 2),
                            horisontalPos = Math.floor((window.innerHeight - popupSize.height) / 2),
                            url = element.href;

                        var popup = window.open(url, 'social',
                            'width=' + popupSize.width + ',height=' + popupSize.height +
                            ',left=' + verticalPos + ',top=' + horisontalPos +
                            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');
                        if (popup) {
                            popup.focus();
                        } else {
                            var win = window.open(url, '_blank');
                            win.focus();
                        }
                    });
                });
            }

            return {
                init: function() {
                    initEvents()
                }
            }
        }()

        document.addEventListener("DOMContentLoaded", function(event) {
            SocialApp.init();
        });
    </script>
@endpush
