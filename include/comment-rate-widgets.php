<?php
class CR_Widget extends WP_Widget {

        public function __construct() {
            $widget_ops = array( 
                'classname' => 'cr_widget',
                'description' => 'پر رای ترین و کم رای ترین دیدگاه ها',
            );
            parent::__construct( 'cr_widget', 'پر رای ترین و کم رای ترین نوشته ها', $widget_ops );
        }
    
    
    
    
    

        public function form( $instance ) {
    
            $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $comment_count = ! empty( $instance['comment_count'] ) ? $instance['comment_count'] : 5;
            $rate_type = ! empty( $instance['rate_type'] ) ? $instance['rate_type '] : 'pos';
            ?>
            <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"> عنوان: </label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'comment_count' ); ?>">  تعداد نمایش: </label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'comment_count' ); ?>" name="<?php echo $this->get_field_name( 'comment_count' ); ?>" type="text" value="<?php echo esc_attr( $comment_count ); ?>">
            </p>
            <p>
            <label for="<?php echo $this->get_field_id( 'rate_type' ); ?>">بازه زمانی</label>
            <select id="<?php echo $this->get_field_id( 'rate_type' ); ?>" name="<?php echo $this->get_field_name( 'rate_type' ); ?>" class="widefat">
                <option <?php if($instance['rate_type']=='pos') echo "selected"; ?> value="pos">پر رای ترین</option>
                <option <?php if($instance['rate_type']=='neg') echo "selected"; ?> value="neg">کم رای ترین</option>
                
            </select>
                </p>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : 'پر رای ترین دیدگاه ها';
            $instance['comment_count'] = ( ! empty( $new_instance['comment_count'] ) ) ? strip_tags( $new_instance['comment_count'] ) :5;
            $instance['rate_type'] = ( ! empty( $new_instance['rate_type'] ) ) ? strip_tags( $new_instance['rate_type'] ) :'pos';
            return $instance;
        
        }

        public function widget( $args, $instance ) {
            global $wpdb;
            $comment_count =$instance['comment_count'];
            $title =$instance['title'];
            $rate_type =$instance['rate_type'];

            if($rate_type=='pos'){
                $mk="_pos";
            }elseif($rate_type=='neg'){
                $mk="_neg";
            }
            $txt="";
            $txt.= $args['before_widget'];
            $txt.= $args['before_title'] . $title . $args['after_title'];
            $query="SELECT (cm.meta_value * 1) AS mv,c.comment_ID  FROM ".$wpdb->prefix."comments c INNER JOIN (SELECT * FROM ".$wpdb->prefix."commentmeta WHERE meta_key='".$mk."') cm ON cm.comment_id=c.comment_ID ORDER by mv DESC";
            $posts = $wpdb->get_results( $query );

            if(!empty($posts)){
               
                $txt .='<ul>';
                foreach($posts as $post){
                    $co=get_comment( $post->comment_ID);
                   
                    $txt .='<li><a href="'.get_comment_link($post->comment_ID).'">'. get_the_title( $co->comment_post_ID  ).'</a></li>';
                }//end-foreach
                $txt .='</ul>';
            }//end_if
            $txt .=$args['after_widget'];
           echo $txt;
        }
    
    }
    
    function register_cr_widget() {
        register_widget('CR_Widget');
    }
    add_action( 'widgets_init', 'register_cr_widget' );
    
?>