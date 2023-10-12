</div>
    <!-- 
        This is a place for Alpine.js Teleport feature 
        @see https://alpinejs.dev/directives/teleport
      -->
    <div id="x-teleport-target"></div>

    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
          
 
  </script>
  
     @if(empty(Session::get('tool')))
       <script src="{{asset('public/front/assets/js/meanmenu.js')}}"></script>

   <script src="{{asset('public/front/assets/js/nav.js')}}"></script>
      @endif
  </body>
</html>
