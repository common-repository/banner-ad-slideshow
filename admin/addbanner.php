<?php
if ( ! defined( 'ABSPATH' ) ) exit;
define('BANNER_AD_SLIDESHOE_PATH', __FILE__ . '/'); 
$installpath = explode('plugins', BANNER_AD_SLIDESHOE_PATH);
define('BANNER_AD_SLIDESHOE_INSTALLATION_PATH', dirname($installpath[0]) . '/'); 

 
$page=sanitize_text_field($_REQUEST["page"]);
$current_url = esc_url(admin_url( "admin.php?page=".$page));
if(isset($_REQUEST['Submit']) && trim($_REQUEST['Submit']) == "Submit") {
$https="https://";
$title=sanitize_text_field($_REQUEST['bannertitle']);
$file= sanitize_file_name($_FILES['imagefile']['name']);
$dtadded=date('Y-m-d H:i:s');							
if(($_FILES['imagefile']['size'] > 2000000))	{					
header("location:$current_url&msg=imgszbg");
die();
}else if(($_FILES['imagefile']['size'] <= 0))	{					
header("location:$current_url&msg=imgszup");
die();
} else {
$insert=$wpdb->query( $wpdb->prepare( "INSERT INTO banneradslideshow (varbannertitle, varbannerimage, dtadded) VALUES ( %s, %s, %d)", $title, $file, $dtadded) );

$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM banneradslideshow WHERE varbannerimage = '$file'"));
if($result){
			foreach($result as $row){
				$bannerid = sanitize_text_field($row->intbannerid);
				
			}
		}
if(isset($_REQUEST['uploading']) && trim($_REQUEST['uploading']) == "imageupload" && $_FILES['imagefile']['name']!="")	{
if ( ! function_exists( 'wp_handle_upload' ) ) {
	require_once( BANNER_AD_SLIDESHOE_INSTALLATION_PATH . 'wp-admin/includes/file.php' );
}
$targetpath = plugin_dir_path( __FILE__ ) . '/images/banner/';
$ext=explode(".",$file);
if($ext[1]=="jpg" || $ext[1]=="gif" || $ext[1]=="jpeg" || $ext[1]=="png" || $ext[1]=="bmp" || $ext[1]=="wbmp" || $ext[1]=="JPEG" || $ext[1]=="JPG")	{
			
if($_FILES['imagefile']['size'] <= 2000000)	{
$ext=explode(".",$file);
$filename=$targetpath.$ext[0].$bannerid.".".$ext[1];
if(file_exists($filename))	{
				chmod($filename, 0777);
				unlink($filename);
}
$fl_db=$ext[0].$bannerid.".".$ext[1];


$upload_overrides = array(
'test_form' => false
);
if (wp_handle_upload( $_FILES['imagefile'], $upload_overrides )) {
$result = $wpdb->query($wpdb->prepare( "UPDATE banneradslideshow SET  
varbannerimage='".$fl_db."' WHERE intbannerid = '".$bannerid."'" ));
			
}					
				
}
}
}
header("location:$current_url&msg=add");
die();
}
}


?>
<br>
<br>
<div style="float:none" class="well center-block col-md-7">
 
<form action="" method="post" enctype="multipart/form-data" name="banner">		

<span style="color:red">
<?php 
if(isset($_REQUEST['msg'])){
	echo esc_html(sanitize_text_field($mess[$_REQUEST['msg']])); 
}
?>
</span>
<br> 
            
<h3>Add New Banner... (* All fields are Required)</h3>
<br>
<label>*Banner Title</label>
<input style="max-width:100%;width:100%" name="bannertitle" type="text" id="bannertitle" value="<?php echo esc_html($p_title);?>" />
<br><br>
<label>*Image</label>
<input style="width:100%" name="imagefile" type="file" id="imagefile" />
<br>
<input style="width:100%" type="hidden" name="uploading" value="imageupload" />
<br>
<input name="Submit" type="submit" class="btn" id="Submit" value="<?php echo esc_html(($action)==2) ? "Update":"Submit"; ?>"  onClick="return check();"/>
<br>

</form>

</div>