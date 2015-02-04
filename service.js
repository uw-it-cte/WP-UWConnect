function servicestatus (){
  jQuery('#noscript').remove();
  jQuery.ajax({
      type: "post",
      url: service_ajax.ajaxurl,
      data: ({action: 'service_status'}),
      beforeSend: function(xhr) {
        jQuery('#spinner').show();
      },
      complete: function() {
        jQuery('#spinner').hide();
      },
      success: function(response, textStatus, jqXHR) {
        jQuery('#services').html(response);
        jQuery('.relatedincidents').hide();
        dropdowns();
      },
      error: function() {
        jQuery('#services').html("<div class='alert alert-warning' style='margin-top:2em;'>We are currently experiencing problems retrieving the status of our services. Please try again in a few minutes.</div>");
      }
  });
}

function dropdowns() {
    jQuery('.switch').click(function(e) {
        target = jQuery(e.target);
        if( target.hasClass('glyphicon-chevron-right') ) {
            target.removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
            target.parent('.servicewrap').parent('.servicecontent').children('.relatedincidents').show(600);
        } else {
            target.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
            target.parent('.servicewrap').parent('.servicecontent').children('.relatedincidents').hide(600);
        }
    });
}
