<?php
add_action('admin_menu','add_setting');
function add_setting(){
 

 add_menu_page( 'comment_rate_style', 'تنظیمات استایل', 'manage_options', 'c_setting', 'comment_rate_setting');
}
function comment_rate_setting(){
    $rate_option=get_option('comment_rate_option',array())
    ?>
    <form method="post">
        <div class="wrap userpro-admin">
            <h3 class="selected">
            <!--span class="dashicons dashicons-admin-generic"></span--><?php _e( 'Setting', 'comment_rate' );?>
            </h3>
            <table class="form-table" style="display: table;">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="rate_style">انتخاب استایل</label>
                        </th>
                        <td>
                            <select id="rate_style" class="" name="rate_style" style="width: 300px; display: inline;">
                                <option value=""> انتخاب</option>
                                <option value="style1"<?php if($rate_option['rate_style'] == 'style1'){ echo ' selected'; }  ?>> style1</option>
                                <option value="style2"<?php if($rate_option['rate_style'] == 'style2'){ echo ' selected'; }  ?>>style2</option>
                                <option value="style3"<?php if($rate_option['rate_style'] == 'style3'){ echo ' selected'; }  ?>>style3</option>
                                <option value="style4"<?php if($rate_option['rate_style'] == 'style4'){ echo ' selected'; }  ?>>style4</option>
                                
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="like_location">تنظیم محل نمایش لایک</label>
                        </th>
                        <td>
                            <select id="like_location" class="" name="like_location" style="width: 300px; display: inline;">
                                <!--option value=""> انتخاب</option-->
                                <option value="after_text" <?php if($rate_option['like_location'] == 'after_text'){ echo ' selected'; }  ?>>بعد از متن دیدگاه </option>
                                <option value="before_text"<?php if($rate_option['like_location'] == 'before_text'){ echo ' selected'; }  ?>>قبل از متن دیدکاه</option>
                                
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="like_type">امتیاز</label>
                        </th>
                        <td>
                            <select id="like_type" class="" name="like_type" style="width: 300px; display: inline;">
                                <!--option value=""> انتخاب</option-->
                                <option value="pos" <?php if($rate_option['like_type'] == 'pos'){ echo ' selected'; }  ?>>مثبت </option>
                                <option value="neg"<?php if($rate_option['like_type'] == 'neg'){ echo ' selected'; }  ?>>منفی</option>
                                <option value="pn"<?php if($rate_option['like_type'] == 'pn'){ echo ' selected'; }  ?>>هردو</option>
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="add_fav">افزودن علاقمندی</label>
                        </th>
                        <td>
                            <select id="add_fav" class="" name="add_fav" style="width: 300px; display: inline;">
                                <option value=""> انتخاب</option>
                                <option value="post" <?php if($rate_option['add_fav'] == 'post'){ echo ' selected'; }  ?>>پست ها</option>
                                <option value="cat"<?php if($rate_option['add_fav'] == 'cat'){ echo ' selected'; }  ?>>دسته بندی</option>
                                <option value="both"<?php if($rate_option['add_fav'] == 'both'){ echo ' selected'; }  ?>>هردو</option>
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="fav_post_location">موقعیت علاقمندی در پست ها</label>
                        </th>
                        <td>
                            <select id="fav_post_location" class="" name="fav_post_location" style="width: 300px; display: inline;">
                                <option value=""> انتخاب</option>
                                <option value="after_p_title"<?php if($rate_option['fav_post_location'] == 'after_p_title'){ echo ' selected'; }  ?>>بعد از عنوان پست</option>
                                <option value="before_p_title" <?php if($rate_option['fav_post_location'] == 'before_p_title'){ echo ' selected'; }  ?>>قبل از عنوان پست</option>
                                <option value="after_p_content"<?php if($rate_option['fav_post_location'] == 'after_p_content'){ echo ' selected'; }  ?>>بعد از محتوای پست</option>
                                <option value="before_p_content"<?php if($rate_option['fav_post_location'] == 'before_p_content'){ echo ' selected'; }  ?>>قبل از محتوای پست</option>
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for="fav_cat_location">موقعیت علاقمندی در دسته ها</label>
                        </th>
                        <td>
                            <select id="fav_cat_location" class="" name="fav_cat_location" style="width: 300px; display: inline;">
                                <option value=""> انتخاب</option>
                                <option value="after_cat_title"<?php if($rate_option['fav_cat_location'] == 'after_cat_title'){ echo ' selected'; }  ?>>بعد از عنوان دسته</option>
                                <option value="before_cat_title" <?php if($rate_option['fav_cat_location'] == 'before_cat_title'){ echo ' selected'; }  ?>>قبل از عنوان دسته</option>
                            </select>
                        </td>
                    </tr>


                    <tr valign="top">
                        <td>
                            <p class="submit">
                                <input id="submit" class="button button-primary" type="submit" value="ذخیره تغییرات" name="comment_rate_save">
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    <?php
}

if(isset($_POST['comment_rate_save']))
{
    $val['rate_style']        = $_POST['rate_style'];
    $val['like_location']     = $_POST['like_location'];
    $val['like_type']         = $_POST['like_type'];
    $val['add_fav']           = $_POST['add_fav'];
    $val['fav_post_location'] = $_POST['fav_post_location'];
    $val['fav_cat_location']  = $_POST['fav_cat_location'];
    update_option('comment_rate_option', $val);

    add_action( 'admin_notices', 'my_notice' );
 
}
/**************************/
function my_notice() {
    ?>
    <div class="updated">
        <p><?php echo "تنظیمات ذخیره شد."; ?></p>
    </div>
    <?php
}

/*****************************************************************/
?>