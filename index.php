<?php
/**
 * Plugin Name: Banner Ad Slideshow
 * Plugin URI:  https://profiles.wordpress.org/walexconcepts/
 * Description: This plugin is all-in-one slider solution for WordPress that create responsive(Premium Features) banners. 
 * Version:     1.0
 * Author:      Awodeyi Adewale Emmanuel
 * Author URI:  https://www.walexconcepts.com/
 * License:     GPLv2+
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define('BANNER_AD_SLIDESHOE_PATH', __FILE__ . '/'); 
$installpath = explode('plugins', BANNER_AD_SLIDESHOE_PATH);
define('BANNER_AD_SLIDESHOE_INSTALLATION_PATH', dirname($installpath[0]) . '/'); 


wp_enqueue_script('jquery');



function banner_ad_slideshow_call_after_install(){
$path = plugin_dir_path( __FILE__ ) . 'system/banner_ad_slideshow.sql';
$sql = file_get_contents($path);
require_once( BANNER_AD_SLIDESHOE_INSTALLATION_PATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}
register_activation_hook( __FILE__, 'banner_ad_slideshow_call_after_install' );



function banner_ad_slideshow_call_after_uninstall() {
global $wpdb;
$wpdb->query( 'DROP TABLE IF EXISTS banneradslideshow' );
$wpdb->query( 'DROP TABLE IF EXISTS banneradsettings' );
}
register_uninstall_hook( __FILE__, 'banner_ad_slideshow_call_after_uninstall' );



function banner_ad_call_filesystem_processing(){
require_once( BANNER_AD_SLIDESHOE_INSTALLATION_PATH . 'wp-admin/includes/file.php' );
WP_Filesystem();
global $wp_filesystem;
$targetpath = plugin_dir_path( __FILE__ ) . '/admin/images/banner/';
if (!is_dir($targetpath)) 
{
        wp_mkdir_p( $targetpath );
}	
}
add_action( 'init', 'banner_ad_call_filesystem_processing' );



function banner_ad_my_custom_upload_directory( $param ) {
$folder = '/banner-ad-slideshow/admin/images/banner';
$param['path'] = WP_PLUGIN_DIR . $folder;
$param['url'] = WP_PLUGIN_URL . $folder;
return $param;
}	
add_filter('upload_dir', 'banner_ad_my_custom_upload_directory');



function banner_ad_filename_rename($filename) {
global $wpdb;
$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM banneradslideshow WHERE varbannerimage = '$filename'"));
if($result){
foreach($result as $row){
$bannerid = sanitize_text_field($row->intbannerid);
				
}
}
$ext = explode( '.', $filename );
$fl_db=$ext[0].$bannerid.".".$ext[1];   
return $fl_db;
}
add_filter('sanitize_file_name', 'banner_ad_filename_rename', 10);




function banner_ad_slideshow_allowed_html() {
	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		
	);
return $allowed_tags;
}





function banner_ad_slideshow_home() {
global $wpdb;		
require plugin_dir_path( __FILE__ ) . 'banner_ad_slideshow_myform.php';		
?>
<style>
#fadeshow1 .gallerylayer img{
width: 100%;
height: auto;
}
</style>
<?php
}
add_shortcode('banner_ad_slideshow','banner_ad_slideshow_home');

 




function banner_ad_slideshow_scripts(){
//optional touchswipe file to enable swipping to navigate slideshow -->
wp_enqueue_script('jquerytouchSwipemin', plugins_url('js/jquery.touchSwipe.min.js', __FILE__ ));
wp_enqueue_script('fadeslideshow', plugins_url('js/fadeslideshow.js', __FILE__ ));
wp_enqueue_script('custom_banner_ad', plugins_url('js/custom_banner_ad.js', __FILE__ ));
require plugin_dir_path( __FILE__ ) . 'temp.php';
$array = array(
'var1' => $bannerimage
 );
wp_localize_script( 'custom_banner_ad', 'php_var', $array );

}
add_action( 'wp_enqueue_scripts', 'banner_ad_slideshow_scripts' );



function banner_ad_slideshow_admin_menu() {
    add_menu_page( 'Bannerad..', 'Bannerad..', null, 'administrator_bannerad', '', plugin_dir_url( __FILE__ ) . 'adminicon.png');
	add_submenu_page( 'administrator_bannerad', 'Add New Banner', 'Add New Banner', 'manage_options', 'addbanner_bannerad', 'banner_ad_addbanner' );
	add_submenu_page( 'administrator_bannerad', 'Banner Manager', 'Banner Manager', 'manage_options', 'bannermanager_bannerad', 'banner_ad_bannermanager' );
	add_submenu_page( 'administrator_bannerad', __( 'Help', 'administrator_bannerad' ), __( 'Help', 'administrator_bannerad' ), 'manage_options', 'help_bannerad', 'banner_ad_help');
	wp_enqueue_style( 'formstylewelcomebox', plugins_url( 'admin/css/banner_ad_slideshow_formstyle.css', __FILE__ ));
	wp_enqueue_script('scwjs', plugins_url('admin/js/scw.js', __FILE__ ));
    wp_enqueue_script('bannerjs', plugins_url('admin/js/banner.js', __FILE__ ));

}
function banner_ad_addbanner(){
	global $wpdb;
	require plugin_dir_path( __FILE__ ) . 'admin/system/msg.inc.php';
	require plugin_dir_path( __FILE__ ) . 'admin/addbanner.php';
}
function banner_ad_bannermanager(){
	global $wpdb;
	require plugin_dir_path( __FILE__ ) . 'admin/system/msg.inc.php';
	require plugin_dir_path( __FILE__ ) . 'admin/bannermanager.php';
}

function banner_ad_help(){
	require plugin_dir_path( __FILE__ ) . 'admin/system/msg.inc.php';
	require plugin_dir_path( __FILE__ ) . 'admin/bannerhelp.php';
}

add_action('admin_menu', 'banner_ad_slideshow_admin_menu');


function banner_ad_slideshow_settings_link( $links){
	$links[] = '<a href="admin.php?page=help_bannerad">Help</a>' ;		
	$links[] = '<a target="_blank" href="https://walexconcepts.com/index.php?page=item&id=18">Go Premium!</a>' ;
	return $links;
}
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'banner_ad_slideshow_settings_link');
