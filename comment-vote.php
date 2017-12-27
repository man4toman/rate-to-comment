<?php 
/*
Plugin Name: rate to comment master
Plugin URI: https://pgacompany.com
Description: rate-to-comment-master
Version: 1.0
Author: PGA co.
Author URI: https://pgacompany.com
*/

#******************************************************
#           COMMENTS RATING
#******************************************************
include_once('include/comment-rate-widgets.php');
include_once('include/comment-rate_setting.php');

$rate_option=get_option('comment_rate_option',array());
global $rate_option;

add_action( 'wp_enqueue_scripts', 'wpcr_add_comment_rate_css' );
function wpcr_add_comment_rate_css() {
  global $rate_option;
  $rate_style=get_option('rate_style');
	wp_enqueue_style( 'wpcr_comment_rate_css',plugins_url( '/assets/css/comment-vote.css', __FILE__ ) );

	if ( 'style1' === $rate_option['rate_style'] ) {
    wp_enqueue_style( 'comment_rate_awesome', plugins_url( '/assets/css/font-awesome.min.css', __FILE__ ) );
		wp_enqueue_style( 'comment_rate_style1', plugins_url( '/assets/css/style1.css', __FILE__ ) );
  }elseif ( 'style2' === $rate_option['rate_style'] ) {
		wp_enqueue_style( 'comment_rate_style2', plugins_url( '/assets/css/style2.css', __FILE__ )  );
  }elseif ( 'style3' === $rate_option['rate_style'] ) {
		wp_enqueue_style( 'comment_rate_style3', plugins_url( '/assets/css/style3.css', __FILE__ ) );
  }elseif ( 'style4' === $rate_option['rate_style'] ) {
		wp_enqueue_style( 'comment_rate_style4', plugins_url( '/assets/css/style4.css', __FILE__ )  );
  }
}


wp_enqueue_script( 'comment-ajax-handle', plugins_url( '/assets/js/comment.js', __FILE__ ), array( 'jquery' ) );
wp_localize_script( 'comment-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 
add_action( 'wp_ajax_the_comment_ajax_hook', 'wpcr_the_comment_action_function' );
add_action( 'wp_ajax_nopriv_the_comment_ajax_hook', 'wpcr_the_comment_action_function' );


#***************************************************
#
#***************************************************

//if ( 'after_text' === $rate_option['like_location'] || 'before_text' === $rate_option['like_location'] ) {
  function wpcr_wb_comment_rate ($comment) {
    global $comment,$rate_option;
  if(!is_admin()){
    if(empty($rate_option['like_type'])) $rate_option['like_type']='pos';
    $comment_id = $comment->comment_ID;
    $get_pos = get_comment_meta ( $comment_id, '_pos', true );
    $get_neg = get_comment_meta ( $comment_id, '_neg', true );
      
    if($get_pos==''){ $_pos = 0; update_comment_meta( $comment_id, '_pos', 0 ); }else{ $_pos = $get_pos; }
    if($get_neg==''){ $_neg = 0; update_comment_meta( $comment_id, '_neg', 0 ); }else{ $_neg = $get_neg; }
    
    $mytext  = "<div id='rateme' class='res_rate_".$comment_id."'>";
    if('pos' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
    $mytext .= "<span class='rate green'>".per_number($_pos)."</span><span data-rate-val='+|".$comment_id."' class='rateme rateme_btn pos green'></span>";
    }
    if('neg' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
    $mytext .= "<span data-rate-val='-|".$comment_id."' class='rateme rateme_btn neg  red'></span><span class='rate red'>".per_number($_neg)."</span>";
    }
    $mytext .= "</div>\n";
    if ( 'before_text' === $rate_option['like_location']){
      return $mytext.$comment->comment_content;
    }else{
      return $comment->comment_content.$mytext;
    }
  }
  return $comment->comment_content;
  }
  add_filter( 'comment_text', 'wpcr_wb_comment_rate' ); 
//}

#***************************************************
#
#***************************************************

function wpcr_the_comment_action_function(){
	global $rate_option;
  $income = explode('|', $_POST['rateval']);
  $controller = $income[0];
  $comment_id = $income[1];

  if(empty($rate_option['like_type'])) $rate_option['like_type']='pos';
  
  if(isset($_COOKIE[$comment_id])){
	   $_pos = get_comment_meta ( $comment_id, '_pos', true );
	   $_neg = get_comment_meta ( $comment_id, '_neg', true );
       
       $mytext = "<div id='rateme' class='res_rate_".$comment_id."'>";
       if('pos' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
       $mytext .= "<span class='rate green'>".per_number($_pos)."</span><span data-rate-val='+|".$comment_id."' class='rateme rateme_btn pos green'></span>";
       }
       if('neg' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
       $mytext .= "<span data-rate-val='-|".$comment_id."' class='rateme rateme_btn neg  red'></span><span class='rate red'>".per_number($_neg)."</span>";
       }
       $mytext .= "<span class='rerror'>&#1588;&#1605;&#1575; &#1602;&#1576;&#1604;&#1575; &#1575;&#1605;&#1578;&#1740;&#1575;&#1586; &#1583;&#1575;&#1583;&#1607; &#1575;&#1740;&#1583;.</span>";
       $mytext .= "</div>\n";
       echo $mytext;
  }
  else{
	
	if($controller == '+'){
	   $get_pos = get_comment_meta ( $comment_id, '_pos', true );
	   $_pos = $get_pos+1;
	   update_comment_meta( $comment_id, '_pos', $_pos );
	   
	   $_pos = get_comment_meta ( $comment_id, '_pos', true );
	   $_neg = get_comment_meta ( $comment_id, '_neg', true );
       
       $mytext = "<div id='rateme' class='res_rate_".$comment_id."'>";
       if('pos' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
       $mytext .= "<span class='rate green'>".per_number($_pos)."</span><span data-rate-val='+|".$comment_id."' class='rateme rateme_btn pos  green'></span>";
       }
       if('neg' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
       $mytext .= "<span data-rate-val='-|".$comment_id."' class='rateme rateme_btn neg  red'></span><span class='rate red'>".per_number($_neg)."</span>";
       }
       $mytext .= "</div>\n";
       echo $mytext;

	}
	else{
	   $get_neg = get_comment_meta ( $comment_id, '_neg', true );
	   $_neg = $get_neg+1;
	   update_comment_meta( $comment_id, '_neg', $_neg );
	   
	   $_neg = get_comment_meta ( $comment_id, '_neg', true );
	   $_pos = get_comment_meta ( $comment_id, '_pos', true );
	   
       $mytext = "<div id='rateme' class='res_rate_".$comment_id."'>";
       if('pos' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
       $mytext .= "<span class='rate green'>".per_number($_pos)."</span><span data-rate-val='+|".$comment_id."' class='rateme rateme_btn pos  green'></span>";
       }
       if('neg' == $rate_option['like_type'] || 'pn' == $rate_option['like_type'] ){
       $mytext .= "<span class='rate red'>".per_number($_neg)."</span><span data-rate-val='-|".$comment_id."' class='rateme rateme_btn neg  red'></span>";
       }
       $mytext .= "</div>\n";
       echo $mytext;
  }
  ob_start();
  setcookie($comment_id, '1');
  }//else
}
#***************************************************
#
#***************************************************

if ( 'post' === $rate_option['add_fav'] || 'both' === $rate_option['add_fav'] ) {
  
  if ( 'after_p_title' === $rate_option['fav_post_location'] || 'before_p_title' === $rate_option['fav_post_location'] ) { 
    add_filter('the_title','wpcr_favorite_the_posts');
  }else if ( 'after_p_content' === $rate_option['fav_post_location'] || 'before_p_content' === $rate_option['fav_post_location'] ) { 
    add_filter('the_content','wpcr_favorite_the_posts');
  }
  function wpcr_favorite_the_posts($content){
      global $rate_option;

      if(empty($rate_option['fav_post_location'])) $rate_option['fav_post_location']='after_p_title';

      if ( in_the_loop() && is_singular( 'post' ) ) {

          $post_id=get_the_ID();
          $pos=0;
          $class="no_fav";
          if(get_post_meta($post_id,'_favorite_post',true) !=""){
              $pos=get_post_meta($post_id,'_favorite_post',true);
              $pos=$pos+1;
              $class="fav";
          }

          $submit="<div class='fav_box_".$post_id."'><span class= 'favoritebtn ".$class." ' post_id= '".$post_id."' fav_val='".$pos."'  >$pos</span></div>";
          if ( 'before_p_title' === $rate_option['fav_post_location'] || 'before_p_content' === $rate_option['fav_post_location'] ) { 
            $content = $submit.$content;
          }elseif ( 'after_p_title' === $rate_option['fav_post_location'] || 'after_p_content' === $rate_option['fav_post_location'] ) { 
            $content = $content.$submit;
          }
  
  
      }

    return $content; 
  }
}
#***************************************************
#
#***************************************************
add_action( 'wp_ajax_wpcr_add_fav_post', 'wpcr_add_fav_post' );
add_action( 'wp_ajax_nopriv_wpcr_add_fav_post', 'wpcr_add_fav_post' );

function wpcr_add_fav_post(){
  $post_id=$_POST['post_id'];
  $pos=$_POST['fav_val'];

  $class="no_fav";
if(isset($_COOKIE[$post_id])){

  if($pos>0){
    $class="fav";
  }
  $submit="<span class= 'favoritebtn ".$class." ' post_id= '".$post_id."' fav_val='".$pos."'  >$pos</span><span class='rerror'>شما قبلا امتیاز داده اید</span>";
 }else{

    $pos=$pos+1;
    $class="fav";
    update_post_meta($post_id,'_favorite_post',$pos);

  $submit="<span class= 'favoritebtn ".$class." ' post_id= '".$post_id."' fav_val='".$pos."'  >$pos</span>";

 }
echo $submit;
  ob_start();
  setcookie($post_id, '1');
}
#***************************************************
#
#***************************************************

if ( 'cat' === $rate_option['add_fav'] || 'both' === $rate_option['add_fav'] ) {
  
  if ( 'after_cat_title' === $rate_option['fav_cat_location'] || 'before_cat_title' === $rate_option['fav_cat_location'] ) { 
    add_filter('single_cat_title','wpcr_favorite_the_cats');
   // add_filter('the_archive_title','wpcr_favorite_the_cats');
  }

  function wpcr_favorite_the_cats($content){
      global $rate_option;

      if(empty($rate_option['fav_post_location'])) $rate_option['fav_post_location']='after_p_title';

      if(is_category()) { 

          $categoryid = get_category(get_query_var('cat'));
          $term_id = $categoryid->term_id;
          $pos=0;
          $class="no_fav";
          if(get_term_meta($term_id,'_favorite_cat',true) !=""){
              $pos=get_post_meta($post_id,'_favorite_cat',true);
              $pos=$pos+1;
              $class="fav";
          }

          $submit="<div class='fav_box_".$term_id."'><span class= 'cat_fav_btn ".$class." ' term_id= '".$term_id."' fav_val='".$pos."'  >$pos</span></div>";
          if ( 'before_cat_title' === $rate_option['fav_cat_location'] ) { 
            $content = $submit.$content;
          }elseif ( 'after_cat_title' === $rate_option['fav_cat_location'] ) {
            $content = $content.$submit;
          }
  
      }

    return $content; 
  }
}
#***************************************************
#
#***************************************************
add_action( 'wp_ajax_wpcr_add_fav_cat', 'wpcr_add_fav_cat' );
add_action( 'wp_ajax_nopriv_wpcr_add_fav_cat', 'wpcr_add_fav_cat' );

function add_fav_cat(){
  $term_id=$_POST['term_id'];
  $pos=$_POST['fav_val'];

  $class="no_fav";
if(isset($_COOKIE[$term_id])){

  if($pos>0){
    $class="fav";
  }
  $submit="<span class= 'cat_fav_btn ".$class." ' term_id= '".$term_id."' fav_val='".$pos."'  >$pos</span><span class='rerror'>شما قبلا امتیاز داده اید</span>";
 }else{

    $pos=$pos+1;
    $class="fav";
    update_term_meta($term_id,'_favorite_cat',$pos);

  $submit="<span class= 'cat_fav_btn ".$class." ' term_id= '".$term_id."' fav_val='".$pos."'  >$pos</span>";

 }
echo $submit;
  ob_start();
  setcookie($post_id, '1');
}
#***************************************************
#
#***************************************************
add_filter( 'manage_edit-comments_columns', 'wpcr_add_columns_head' );
function wpcr_add_columns_head( $defaults ) {
    $defaults['pos'] = 'رای مثبت';
    $defaults['neg'] = 'رای منفی';
    return $defaults;
}

add_action('manage_comments_custom_column', 'wpcr_add_columns_content', 10, 2);
function wpcr_add_columns_content($column_name, $post_ID) { 
     global $comment;
    if ( $column_name == 'pos' ) {
        $postid=$comment->comment_ID;
        $commentid_pos=get_comment_meta( $comment->comment_ID, '_pos', true );
        if(empty($commentid_pos)) $commentid_pos='--';
        echo $commentid_pos;
    }
    if ( $column_name == 'neg' ) {
      $postid=$comment->comment_ID;
      $commentid_neg=get_comment_meta( $comment->comment_ID, '_neg', true );
      if(empty($commentid_neg)) $commentid_neg='--';
      echo $commentid_neg;
  }
}
#***************************************************
#
#***************************************************
function wpcr_add_comment_metabox(){
  add_meta_box( 'add_meta_title1', 'امتیاز دیدگاه ها', 'wpcr_comment_metabox', 'comment', 'normal' );
}
add_action( 'add_meta_boxes', 'wpcr_add_comment_metabox' );

function wpcr_comment_metabox(){
  global $comment;
  $commentid_pos=get_comment_meta( $comment->comment_ID, '_pos', true );
  $commentid_neg=get_comment_meta( $comment->comment_ID, '_neg', true );
  ?>
  <table>
      <tr>
          <td><label>امتیاز مثبت : </label></td>
          <td>
              <input type="text" value="<?php echo $commentid_pos; ?>" name="c_pos" >
          </td>
      </tr>
      <tr>
          <td><label>امتیاز منفی : </label></td>
          <td>
              <input type="text" value="<?php echo $commentid_neg; ?>" name="c_neg" >
          </td>
      </tr>
  </table>
  <?php
}

add_action( 'edit_comment', 'wpcr_save_comment_meta' );

function wpcr_save_comment_meta( $comment_id ) {
  update_comment_meta(   $comment_id, '_pos',$_POST['c_pos'] );
  update_comment_meta(   $comment_id, '_neg',$_POST['c_neg'] );

}
#***************************************************
#
#***************************************************
load_theme_textdomain('comment_rate', plugins_url( '/languages', __FILE__ ));

