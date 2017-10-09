<?php
#******************************************************
#           COMMENTS RATING
#******************************************************

wp_enqueue_script( 'comment-ajax-handle', get_bloginfo('template_url') . '/js/comment.js', array( 'jquery' ) );
wp_localize_script( 'comment-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 
add_action( 'wp_ajax_the_comment_ajax_hook', 'the_comment_action_function' );
add_action( 'wp_ajax_nopriv_the_comment_ajax_hook', 'the_comment_action_function' );

function wb_comment_form_preinsert() { ?>
   <form id="rateForm">
     <input name="action" type="hidden" value="the_comment_ajax_hook" />
     <input name="rateval" type="hidden" id="rateval" value="" />
   </form>
<?php }
add_action( 'comment_form_before' , 'wb_comment_form_preinsert' );

function wb_comment_rate ($cid) {
   //global $comment;
 if(!is_admin()){
   //$comment_id = $comment->comment_ID;
   $get_pos = get_comment_meta ( $cid, '_pos', true );
   $get_neg = get_comment_meta ( $cid, '_neg', true );
   
   if($get_pos==''){ $_pos = 0; update_comment_meta( $cid, '_pos', 0 ); }else{ $_pos = $get_pos; }
   if($get_neg==''){ $_neg = 0; update_comment_meta( $cid, '_neg', 0 ); }else{ $_neg = $get_neg; }
   
   $mytext  = "<span class='res_rate_".$cid."'>";
   $mytext .= "<strong class='rate rateme green' data-rate-val='+|".$cid."'>+</strong><strong class='dontrateme result' data-rate-val='=|".$cid."'>".per_number($_pos-$_neg)."</strong>";
   $mytext .= "</span>\n";
   //return $comment->comment_content.$mytext;
   return $mytext;
 }
}
//add_filter( 'comment_text', 'wb_comment_rate' ); 

function the_comment_action_function(){
  $income = explode('|', $_POST['rateval']);
  $controller = $income[0];
  $comment_id = $income[1];
	
  if(isset($_COOKIE[$comment_id])){
	   $_pos = get_comment_meta ( $comment_id, '_pos', true );
	   $_neg = get_comment_meta ( $comment_id, '_neg', true );
       
       $mytext  = "<span class='res_rate_".$comment_id."'>";
       $mytext .= "<span class='rerror'>شما قبلا امتیاز داده اید</span>";
       $mytext .= "<strong class='rate rateme green' data-rate-val='+|".$comment_id."'>+</strong><strong class='dontrateme result' data-rate-val='=|".$comment_id."'>".per_number($_pos-$_neg)."</strong>";
       $mytext .= "</span>\n";
       echo $mytext;
  }
  else{

	if($controller == '+'){
	   $get_pos = get_comment_meta ( $comment_id, '_pos', true );
	   $_pos = $get_pos+1;
	   update_comment_meta( $comment_id, '_pos', $_pos );
	   
	   $_pos = get_comment_meta ( $comment_id, '_pos', true );
	   $_neg = get_comment_meta ( $comment_id, '_neg', true );
       
       $mytext  = "<span class='res_rate_".$comment_id."'>";
       $mytext .= "<strong class='rate rateme green' data-rate-val='+|".$comment_id."'>+</strong><strong class='dontrateme result' data-rate-val='=|".$comment_id."'>".per_number($_pos-$_neg)."</strong>";
       $mytext .= "</span>\n";
       echo $mytext;

	}
	else{
	   $get_neg = get_comment_meta ( $comment_id, '_neg', true );
	   $_neg = $get_neg+1;
	   update_comment_meta( $comment_id, '_neg', $_neg );
	   
	   $_neg = get_comment_meta ( $comment_id, '_neg', true );
	   $_pos = get_comment_meta ( $comment_id, '_pos', true );
	   
       $mytext  = "<span class='res_rate_".$comment_id."'>";
       $mytext .= "<strong class='rate rateme green' data-rate-val='+|".$comment_id."'>+</strong><strong class='dontrateme result' data-rate-val='=|".$comment_id."'>".per_number($_pos-$_neg)."</strong>";
       $mytext .= "</span>\n";
       echo $mytext;
	}


  ob_start();
  setcookie($comment_id, '1');
  }//else
}