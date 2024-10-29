<?php
$width ="";
$height ="";
$cycles ="";
$pause="";
$randomize="";
$wraparound = "";
$type = "";
$persist = "";
$duration = "";
$descreveal = "";

if ( ! defined( 'ABSPATH' ) ) exit;
$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM banneradsettings"));
if($result){
	foreach($result as $row){
			    $width = sanitize_text_field($row->width);
				$height = sanitize_text_field($row->height);
				$cycles = sanitize_text_field($row->cycles);
				$pause = sanitize_text_field($row->pause);	   
				$randomize = sanitize_text_field($row->randomize);	   
				$wraparound = sanitize_text_field($row->wraparound);	   
		   		$type = sanitize_text_field($row->type);
				$persist = sanitize_text_field($row->persist);
				$duration = sanitize_text_field($row->duration);
				$descreveal = sanitize_text_field($row->descreveal);

			}
		}
?>
    
<div id="fadeshow1"></div>
<div id="fadeshow1toggler" style="padding:0;width:100%; text-align:center; margin-top:10px">
<a href="#" class="prev"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . "admin/images/left.png"); ?>" style="border-width:0" /></a>  <span class="status" style="margin:0 50px; font-weight:bold"></span> <a href="#" class="next"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . "admin/images/right.png"); ?>" style="border-width:0" /></a>
</div>             
<?php 
 