<x-application-page-wrapper>
@csrf 
<input id="rest" name="url" type="text" value="https://yourqualitypainters.com/" />
<button id="test"  class="btn btn-success">
    test
</button>

 <!-- Include the CSRF token -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.0/html2pdf.bundle.min.js"></script>

<script>
// https://monkeymindshop.com/
// https://monicacumberbatch.net/
// https://rooseveltpublishers.com/
// https://www.perpetualhomesadu.com/
// https://iltex.us/
// https://www.glowskinmedspa.com/
// https://www.superiorautomobiledetailing.com/

    $('#test').click(function(){
      var t = $("#rest").val();
       imgcaching(t);
           
    })
    
 

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
    
    
         function imgcaching(t){
         $.ajax({
                    url: "{{route('imgcaching')}}", // Replace with your API URL
                    type: "POST",
                    data: {'url':t,
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        // This function is called when the request is successful
                     console.log(response);
                  

                      
                 
                    },
                    error: function(xhr, status, error) {
                        // This function is called if an error occurs
                        console.error("Error: " + error);
                    }
                });
    }
    
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
</x-application-page-wrapper>
