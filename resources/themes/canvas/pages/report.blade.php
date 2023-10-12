<x-application-page-wrapper>
@csrf 
<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

  <div class="col-span-12 lg:col-span-12">
    <div class="card">
      <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100"> Report Result
        </h2>
        <div class="flex justify-center space-x-2">



            <form action="{{route('tool.handle',['tool'=>'seo-report'])}}" method="post">
                 <button type="submit" class="btn h-9 w-9 bg-slate-150 p-0 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <i class="an an-reload" style="font-size:1rem;color:#ff9800"></i>
            @CSRF
            <input type="hidden" value="{{$url}}">
          </button>
          </form>
         
          <button onclick="printreport()" class="btn h-9 w-9 bg-slate-150 p-0 text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
            <i class="an an-print" style="font-size:1rem;color:#10b981"></i>
          </button>

        </div>
      </div>


      <div class="p-4 sm:p-5">
      {!! $response !!}

        
      </div>

    </div>
  </div>
  </div>

 <!-- Include the CSRF token -->
 @push('page_scripts')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.0/html2pdf.bundle.min.js"></script>

<script>
// https://monkeymindshop.com/
// https://monicacumberbatch.net/
// https://rooseveltpublishers.com/
// https://www.perpetualhomesadu.com/
// https://iltex.us/
// https://www.glowskinmedspa.com/
// https://www.superiorautomobiledetailing.com/


    
 

    function printreport() {
        var printContents = document.querySelector('.printable-container');
        var originalContents = document.body.innerHTML;
    
        document.body.innerHTML = printContents.outerHTML;
      
    window.print();
    document.body.innerHTML = originalContents;

       
    }
    
    


    $('#buttonlike').click(function(){
    
    var ids =$(this).attr("data-id");
     
    $.post("{{ route('tool.favouriteAction') }}",
      {
        'id': ids,
        "_token": "{{ csrf_token() }}",
      },
      function(data){
    
      });
    
    });
document.addEventListener('DOMContentLoaded', function() {
  const links = document.querySelectorAll('a[href^="#"]');

  // Add a new variable to store the desired scroll speed.
  const scrollSpeed = 100; // milliseconds per pixel

  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();


      const targetId = this.getAttribute('href').substring(1);
      const targetElement = document.getElementById(targetId);
   scrollToElement(targetElement, scrollSpeed); 
      if (targetElement) {
        // Update the scrollIntoView() call to pass in the desired scroll speed.
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start', // You can adjust the scrolling position if needed
        
        });
      }
    });
  });
});
</script>
    @endpush
</x-application-page-wrapper>
