jQuery( function() {
  var page = 1;
  jQuery('body').on('click', '#load-more', function(){
      var data = {
        'action': 'load_posts_by_ajax',
        'page': ++page,
        'security': Postsbydate.nonce
      };

      jQuery.get( Postsbydate.ajaxurl, data, function(response){
        jQuery('#wrapper').append(response);
      });
    });

});







  
