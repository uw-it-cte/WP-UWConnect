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
      },
      error: function() {
        jQuery('#services').html("<div class='alert alert-warning' style='margin-top:2em;'>We are currently experiencing problems retrieving the status of our services. Please try again in a few minutes.</div>");
      }
  });
}
