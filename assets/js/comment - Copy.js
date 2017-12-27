jQuery(document).ready(function(){

    jQuery('body').on('click', '.rateme',function(e){
alert("cccccccccccccc");
       var rateval = jQuery(this).attr('data-rate-val');
       jQuery("#rateForm #rateval").val(rateval);
       //var cls = jQuery(this).parent().attr('class');
       var cls = jQuery(this).parent();


    e.preventDefault();
    if (!jQuery(this).data('isClicked')) {
        var link = jQuery(this);

       jQuery.post(the_ajax_script.ajaxurl,jQuery("#rateForm").serialize(),
          function(response_from_the_comment_action_function){
              cls.html(response_from_the_comment_action_function.substr(0,response_from_the_comment_action_function.length-1));
          }
       );

        link.data('isClicked', true);
        setTimeout(function() {
        link.removeData('isClicked')
        }, 3000);
    }
    });
    
});