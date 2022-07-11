// Immediately-invoked function expression
(function() {
    // Load the script
    const script = document.createElement("script");
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js';
    script.type = 'text/javascript';
    let currentPage = 1;
    script.addEventListener('load', () => {
      jQuery( '#load-more' ).on( 'click', function( event ) {
        console.log('radiii');
        currentPage++; // Do currentPage + 1, because we want to load the next page

        $.ajax({
          type: 'POST',
          url: '/wp-admin/admin-ajax.php',
          dataType: 'html',
          data: {
            action: 'weichie_load_more',
            paged: currentPage,
          },
          success: function (res) {
            $('.publication-list').append(res);
          }
        });
 
     } );
    });
    document.head.appendChild(script);
  })();
  
