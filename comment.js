jQuery(document).ready(function(){
    
        jQuery('body').on('click', '.rateme',function(e){
    
           var rateval = jQuery(this).attr('data-rate-val');

           //jQuery("#rateForm #rateval").val(rateval);
           var cls = jQuery(this).parent('div#rateme').attr('class');
    
    
        e.preventDefault();
        if (!jQuery(this).data('isClicked')) {
            var link = jQuery(this);
    
            jQuery( this ).parent().find('span').removeClass( 'rateme' );
            jQuery.post(the_ajax_script.ajaxurl,{action:"the_comment_ajax_hook",rateval:rateval},function(response_from_the_comment_action_function){

           /*jQuery.post(the_ajax_script.ajaxurl,jQuery("#rateForm").serialize(),
              function(response_from_the_comment_action_function){*/
                  jQuery('.'+cls).html(response_from_the_comment_action_function.substr(0,response_from_the_comment_action_function.length-1));
                  jQuery( this ).parent().find('span.pos').addClass( 'rateme' );
                  jQuery( this ).parent().find('span.neg').addClass( 'rateme' );
              }
           );
    
            link.data('isClicked', true);
            setTimeout(function() {
            link.removeData('isClicked')
            }, 3000);
        }
        });
        
        
        //////////////////////////////////////////
        jQuery('body').on('click', '.favoritebtn',function(e){
        var pclass=jQuery(this).parent().attr('class'),
            post_id= jQuery(this).attr('post_id'),
            fav_val =jQuery(this).attr('fav_val');

            jQuery.post(the_ajax_script.ajaxurl,{action:"wpcr_add_fav_post",post_id:post_id,fav_val:fav_val},function(response){
                jQuery('.'+pclass).html(response.substr(0,response.length-1));
               
             });

    });

    ///////////////////////////////////////////////////////
        jQuery('body').on('click', '.cat_fav_btn',function(e){
        var pclass=jQuery(this).parent().attr('class'),
           term_id= jQuery(this).attr('term_id'),
            fav_val =jQuery(this).attr('fav_val');


            jQuery.post(the_ajax_script.ajaxurl,{action:"wpcr_add_fav_cat",term_id:term_id,fav_val:fav_val},function(response){
                jQuery('.'+pclass).html(response.substr(0,response.length-1));
             });

    });
    
        
    });