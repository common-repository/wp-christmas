<?php
/*
Plugin Name:WP-Christmas
Plugin URI: http://liucheng.name/1166/
Description: This plugin create Christmas snowman Wish everyone a Merry Christmas! And have beautiful falling snow flakes on the blogs.| 一对雪人祝大家圣诞快乐! 飘着小雪。
Author: 柳城
Version: 1.2.9
Author URI: http://liucheng.name/

*/
function wp_christmas_admininit()
{
	 // Add a page to the options section of the website
   if (current_user_can('manage_options')) 				
 		add_options_page("WP Christmas","WP Christmas", 8, __FILE__, 'wp_christmas_optionpage');
}

function wp_christmas_topbarmessage($msg)
{
	 echo '<div class="updated fade" id="message"><p>' . $msg . '</p></div>';
}

/**
 * Returns the URL to the directory where the plugin file is located
 * @since 3.0b5
 * @access private
 * @author Arne Brachhold
 * @return string The URL to the plugin directory
 */
if(!function_exists('wp_christmas_GetPluginUrl')) {
	function wp_christmas_GetPluginUrl() {
		
		//Try to use WP API if possible, introduced in WP 2.6
		if (function_exists('plugins_url')) return trailingslashit(plugins_url(basename(dirname(__FILE__))));
		
		//Try to find manually... can't work if wp-content was renamed or is redirected
		$path = dirname(__FILE__);
		$path = str_replace("\\","/",$path);
		$path = trailingslashit(get_bloginfo('wpurl')) . trailingslashit(substr($path,strpos($path,"wp-content/")));
		return $path;
	}
}

function update_wp_christmas_option() {
	if(isset($_POST['action'])) {
		if($_POST[wp_christmas_enable]){ $wp_christmas_enable = '1'; }else{ $wp_christmas_enable = '0'; }
		if($_POST[wp_christmas_Home]){ $wp_christmas_Home = '1'; }else{ $wp_christmas_Home = '0'; }
		if($_POST[wp_christmas_Post]){ $wp_christmas_Post = '1'; }else{ $wp_christmas_Post = '0'; }
		if($_POST[wp_christmas_Tag]){ $wp_christmas_Tag = '1'; }else{ $wp_christmas_Tag = '0'; }
		if($_POST[wp_christmas_Category]){ $wp_christmas_Category = '1'; }else{ $wp_christmas_Category = '0'; }
		if($_POST[wp_christmas_Page]){ $wp_christmas_Page = '1'; }else{ $wp_christmas_Page = '0'; }
		if($_POST[wp_christmas_Page_id]){ $wp_christmas_Page_id = $_POST[wp_christmas_Page_id]; }
		if($_POST[wp_let_it_snows]){ $wp_let_it_snows = '1'; }else{ $wp_let_it_snows = '0'; }
		if($_POST[wp_christmas_Post_id]){ $wp_christmas_Post_id = $_POST[wp_christmas_Post_id]; }
		if($_POST[wp_christmas_cookie]){ $wp_christmas_cookie = '1'; }else{ $wp_christmas_cookie = '0'; }
		if($_POST[let_it_another_snows]){ $let_it_another_snows = '1'; }else{ $let_it_another_snows = '0'; }
		if($_POST[let_it_another_custom_picture]){ $let_it_another_custom_picture = $_POST[let_it_another_custom_picture]; }
		$update_wp_christmas_option = implode('|',array($wp_christmas_enable,$wp_christmas_Home,$wp_christmas_Post,$wp_christmas_Tag,$wp_christmas_Category,$wp_christmas_Page,$wp_let_it_snows,$wp_christmas_Post_id,$wp_christmas_cookie,$let_it_another_snows, $let_it_another_custom_picture, $wp_christmas_Page_id));
        update_option(wp_christmas_option,$update_wp_christmas_option);
		wp_christmas_topbarmessage(__('Options saved.'));
	}
}

function wp_christmas_optionpage() {
      /* Perform any action */
		if(isset($_POST['action'])) {
			if ($_POST['action']=='update') update_wp_christmas_option(); 
		}
		
		/* Definition */
      echo '<div class="wrap"><div style="background: url('.wp_christmas_GetPluginUrl().'liucheng_name32.png) no-repeat;" class="icon32"><br /></div>';
		echo '<h2>WP-Christmas</h2>';

		/* Introduction */ 
		echo '<p>'.__('A wordpress plugin for Christmas. This plugin create Christmas snowman Wish everyone a Merry Christmas! | 一对雪人祝大家圣诞快乐! 飘着小雪。
','wp_christmas').'</p>';

		/* Show the options */
		wp_christmas_show_option();	

		echo '</div>';    
}

function wp_christmas_show_option(){
   $get_wp_christmas_option = get_option(wp_christmas_option);
   if($get_wp_christmas_option){
	   list($wp_christmas_enable, $wp_christmas_Home, $wp_christmas_Post, $wp_christmas_Tag, $wp_christmas_Category, $wp_christmas_Page, $wp_let_it_snows, $wp_christmas_Post_id, $wp_christmas_cookie, $let_it_another_snows, $let_it_another_custom_picture, $wp_christmas_Page_id) = explode('|',$get_wp_christmas_option);
   }else{
	   $wp_christmas_enable = '1';
       $wp_christmas_Home = '1';
	   $wp_let_it_snows = '1';
   }
	?>
		<div class="tool-box">
		    <?php PayPal_Donate_liucheng_name(); ?>
			<h3 class="title"><?php _e('Options');?></h3>
			<a name="wp_christmas_option"></a><form name="wp_christmas_option" method="post" action="">
			<input type="hidden" name="action" value="update" />
			<table>
				<tr><td><label for="wp_christmas_Enable"><?php _e('Enable');?></label></td><td><input type="checkbox" name="wp_christmas_enable" value="1" <?php if($wp_christmas_enable){ echo "checked"; }?> /></td></tr>
				<tr><td><label for="wp_christmas_cookie"><?php _e('Cookie Control');?></label></td><td><input type="checkbox" name="wp_christmas_cookie" value="1" <?php if($wp_christmas_cookie){ echo "checked"; }?> /></td><td><i>Display once!</i></td></tr>
				<tr><td><label for="wp_let_it_snows"><?php _e('let_it_snows');?></label></td><td><input type="checkbox" name="wp_let_it_snows" value="1" <?php if($wp_let_it_snows){ echo "checked"; }?> /></td></tr>
				<tr><td><label for="let_it_another_snows"><?php _e('let_it_another_snows');?></label></td><td><input type="checkbox" name="let_it_another_snows" value="1" <?php if($let_it_another_snows){ echo "checked"; }?> /></td><td><label for="let_it_another_custom_picture"><?php _e('Custom Picture');?></label></td><td><input type="text" name="let_it_another_custom_picture" value="<?php if($let_it_another_custom_picture){ echo $let_it_another_custom_picture; }?>"><i>url</i></td></tr>
				<tr><td><label for="wp_christmas_Display"><strong><?php _e('Display In:');?></strong></td></tr>
				<tr><td><label for="wp_christmas_Home"><?php _e('Home');?></label></td><td><input type="checkbox" name="wp_christmas_Home" value="1" <?php if($wp_christmas_Home){ echo "checked"; }?> /></td></tr>
				<tr><td><label for="wp_christmas_Post"><?php _e('Posts');?></label></td><td><input type="checkbox" name="wp_christmas_Post" value="1" <?php if($wp_christmas_Post){ echo "checked"; }?> /></td><td><label for="wp_christmas_Post_id"><?php _e('Post_ID');?></label></td><td><input type="text" name="wp_christmas_Post_id" value="<?php if($wp_christmas_Post_id){ echo $wp_christmas_Post_id; }?>" /><i>Example: 1166,120,542</i></td></tr>
				<tr><td><label for="wp_christmas_Tag"><?php _e('Tags');?></label></td><td><input type="checkbox" name="wp_christmas_Tag" value="1" <?php if($wp_christmas_Tag){ echo "checked"; }?> /></td></tr>
				<tr><td><label for="wp_christmas_Category"><?php _e('Categorys');?></label></td><td><input type="checkbox" name="wp_christmas_Category" value="1" <?php if($wp_christmas_Category){ echo "checked"; }?> /></td></tr>
				<tr><td><label for="wp_christmas_Page"><?php _e('Pages');?></label></td><td><input type="checkbox" name="wp_christmas_Page" value="1" <?php if($wp_christmas_Page){ echo "checked"; }?> /></td><td><label for="wp_christmas_Page_id"><?php _e('Page_ID');?></label></td><td><input type="text" name="wp_christmas_Page_id" value="<?php if($wp_christmas_Page_id){ echo $wp_christmas_Page_id; }?>" /><i>Example: 1,2</i></td></tr>
			</table>
			<p><strong>Wish you a Merry Christmas! My blog: <a href="http://liucheng.name/" target="_blank">柳城(zhenglc)</a> , Plugin Homepage: <a href="http://liucheng.name/1166/" target="_blank">wp_christmas</a></strong></p>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Update Profile'); ?>" /></p>
			</form>
		</div>
    <?php
}

//let_it_snows
if(!function_exists(let_it_snows)){
	function let_it_snows() {
		// Path for snow images
		$snowPath = wp_christmas_GetPluginUrl();
		$snowJS =	'<script type="text/javascript">
					sitePath = "'.$snowPath.'";
					sflakesMax = '.rand(84,104).';
					sflakesMaxActive = '.rand(64,84).';
					svMaxX = '.rand(2,6).';
					svMaxY = '.rand(3,7).';
					ssnowStick = '.rand(0,1).';
					sfollowMouse = '.rand(0,1).';
					</script>';
		$snowJS .= '<script type="text/javascript" src="'.$snowPath.'snowstorm.js"></script>'."\n";
		print($snowJS);
	}
}

//let_it_another_snows
if(!function_exists(let_it_another_snows)){
	function let_it_another_snows() {
		   $get_wp_christmas_option = get_option(wp_christmas_option);
	   if($get_wp_christmas_option){
		   list($wp_christmas_enable, $wp_christmas_Home, $wp_christmas_Post, $wp_christmas_Tag, $wp_christmas_Category, $wp_christmas_Page, $wp_let_it_snows, $wp_christmas_Post_id, $wp_christmas_cookie, $let_it_another_snows, $let_it_another_custom_picture, $wp_christmas_Page_id) = explode('|',$get_wp_christmas_option);
	   }
		// Path for snow images
		$snowPath = wp_christmas_GetPluginUrl();
		$show_picture = wp_christmas_GetPluginUrl().'image/snow'.rand(0,6).'.gif';
		if($let_it_another_custom_picture){ $show_picture = $let_it_another_custom_picture; }
		$snowJS .= '<script type="text/javascript" src="'.$snowPath.'snow.js.php?show_picture='.$show_picture.'"></script>'."\n";
		print($snowJS);
	}
}

function wp_christmas_snowman(){
	$currentLocale = get_locale();
	if( $currentLocale == 'zh_TW' || $currentLocale == 'zh_CN'){
		$swf_url = wp_christmas_GetPluginUrl().'wp-christmas.swf';
        print '<div id="MagicFace" Style="POSITION:absolute;Z-INDEX:99;visibility:hidden;"><script language="JavaScript" src="'.wp_christmas_GetPluginUrl().'wp-christmas.js.php?swf='.$swf_url.'"></script></div>';
	}else{
		$swf_url = wp_christmas_GetPluginUrl().'wp-christmas-EN.swf';
		print '<div id="MagicFace" Style="POSITION:absolute;Z-INDEX:99;visibility:hidden;"><script language="JavaScript" src="'.wp_christmas_GetPluginUrl().'wp-christmas.js.php?swf='.$swf_url.'"></script></div>';
	}
}

function wp_christmas_cookie(){
	   $get_wp_christmas_option = get_option(wp_christmas_option);
   if($get_wp_christmas_option){
	   list($wp_christmas_enable, $wp_christmas_Home, $wp_christmas_Post, $wp_christmas_Tag, $wp_christmas_Category, $wp_christmas_Page, $wp_let_it_snows, $wp_christmas_Post_id, $wp_christmas_cookie, $let_it_another_snows, $let_it_another_custom_picture, $wp_christmas_Page_id) = explode('|',$get_wp_christmas_option);
   }
   if($wp_christmas_cookie){
	   print '<script type="text/javascript">document.cookie="donotplay=donotplay;"</script>';
   }
}

function the_wp_christmas(){
   $get_wp_christmas_option = get_option(wp_christmas_option);
   if($get_wp_christmas_option){
	   list($wp_christmas_enable, $wp_christmas_Home, $wp_christmas_Post, $wp_christmas_Tag, $wp_christmas_Category, $wp_christmas_Page, $wp_let_it_snows, $wp_christmas_Post_id, $wp_christmas_cookie, $let_it_another_snows, $let_it_another_custom_picture, $wp_christmas_Page_id) = explode('|',$get_wp_christmas_option);
	   if($wp_christmas_Post_id){
		   $array_wp_christmas_Post_id = explode(',', $wp_christmas_Post_id);
	   }
	   if($wp_christmas_Page_id){
		   $array_wp_christmas_Page_id = explode(',', $wp_christmas_Page_id);
	   }
   }else{
	   $wp_christmas_enable = '1';
       $wp_christmas_Home = '1';
	   $wp_let_it_snows = '1';
   }
   if (!isset($_COOKIE['donotplay'])){
	   if($wp_christmas_enable){
		   if( is_home() && $wp_christmas_Home ){
			   wp_christmas_snowman();
			   if($wp_let_it_snows){ let_it_snows(); }
			   if($let_it_another_snows){ let_it_another_snows(); }
			   wp_christmas_cookie();
		   }
		   if($array_wp_christmas_Post_id){
			   #foreach($array_wp_christmas_Post_id as $ID){
				   if( is_single($array_wp_christmas_Post_id) ){
					   wp_christmas_snowman();
					   if($wp_let_it_snows){ let_it_snows(); }
					   if($let_it_another_snows){ let_it_another_snows(); }
					   wp_christmas_cookie();
				   }
			   #}
		   }else{
			   if( is_single() && $wp_christmas_Post ){
				   wp_christmas_snowman();
				   if($wp_let_it_snows){ let_it_snows(); }
				   if($let_it_another_snows){ let_it_another_snows(); }
				   wp_christmas_cookie();
			   }
		   }
		   if (function_exists('is_tag')) { 
			   if ( is_tag() && $wp_christmas_Tag ){
				   wp_christmas_snowman();
				   if($wp_let_it_snows){ let_it_snows(); }
				   if($let_it_another_snows){ let_it_another_snows(); }
				   wp_christmas_cookie();
			   }
		   }
		   if( is_category() && $wp_christmas_Category ){
			   wp_christmas_snowman();
			   if($wp_let_it_snows){ let_it_snows(); }
			   if($let_it_another_snows){ let_it_another_snows(); }
			   wp_christmas_cookie();
		   }

		   ##pages##
		   if($array_wp_christmas_Page_id){
			   #foreach($array_wp_christmas_Page_id as $ID){
				   if( is_page($array_wp_christmas_Page_id) ){
					   wp_christmas_snowman();
					   if($wp_let_it_snows){ let_it_snows(); }
					   if($let_it_another_snows){ let_it_another_snows(); }
					   wp_christmas_cookie();
				   }
			   #}
		   }else{
			   if( is_page() && $wp_christmas_Page ){
			   wp_christmas_snowman();
			   if($wp_let_it_snows){ let_it_snows(); }
			   if($let_it_another_snows){ let_it_another_snows(); }
			   wp_christmas_cookie();
			   }
		   }
		   ## pages ##

	   }
   }
}

function PayPal_Donate_liucheng_name(){
	?>
<!--<div style="float: right;">-->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="margin:0px;display:inline">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
</form>
<!--</div>-->
    <?php
}


 /* Tie the module into Wordpress */
add_action('admin_menu','wp_christmas_admininit');
add_filter('wp_footer','the_wp_christmas',9999);