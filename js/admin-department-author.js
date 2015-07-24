jQuery(document).ready(function($){
  //force top item (in the case of department editors, the only) to be checked all the time
  var required_cat = $('#categorychecklist li:first-child input');
  if( !required_cat.attr('checked')  ) {
    required_cat.attr('checked','checked');
  }

  $('a[href$="nav-menus.php?action=locations"]').hide();

  var string = $('#dom-target').text();
  var match = document.getElementById( string );
  $('.menu-theme-locations input').each(function() {
    if ( this == match ){
      //nothing
    }else{
      $(this).parent().css('display', 'none');
    }
  });
});
