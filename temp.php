<?php
global $wpdb;
	$bannerimage = array();
	$result = $wpdb->get_results($wpdb->prepare("select * from banneradslideshow"));
	foreach($result as $row){
	$bannerimage[] = [plugin_dir_url( __FILE__ ) . "admin/images/banner/$row->varbannerimage"];
	}	  			  
	
