<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$page=sanitize_text_field($_REQUEST["page"]);
$current_url = esc_url(admin_url( "admin.php?page=".$page));

if(isset($_REQUEST['a']) && trim($_REQUEST['a'])==3)
{
	if(isset($_REQUEST['bannerid']) && trim($_REQUEST['bannerid'] != ""))
	{
		$bannerid = sanitize_text_field($_REQUEST['bannerid']);
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM banneradslideshow WHERE intbannerid = '$bannerid'"));
		if($result){
			foreach($result as $row){
				$targetpath = plugin_dir_path( __FILE__ ) . '/images/banner/';
				$th_file = sanitize_text_field($row->varbannerimage);
				$filename1=$targetpath.$th_file;
					chmod($filename1, 0777);
					unlink($filename1);
			}
		}
		$query = $wpdb->prepare( 'SELECT intbannerid FROM banneradslideshow WHERE intbannerid = %d', $bannerid );
		$var = $wpdb->get_var( $query );
		if ( $var ) {
        $sql_del = $wpdb->prepare( 'DELETE FROM banneradslideshow WHERE intbannerid = %d', $bannerid );
        $wpdb->query( $sql_del );
		}
		header("location:$current_url&msg=del");
		die();
	}
}

			
?>
<style>
    table, td {
		width:70%;
        border: 1px solid black;
        border-collapse: collapse;
        padding: 25px;
     }
</style>
<br>
<br>
<table align="center">        
<tbody>
            
            <tr>
				<td colspan="2" align="left">
				<h3 style="color:red"><?php if(isset($_REQUEST['msg'])){ echo esc_html(sanitize_text_field($mess[$_REQUEST['msg']])); } ?></h3>
				<h3>Banners Manager</h3><a href="banner.php?script=addbanner" class="aa"></a>...</td>
                <td colspan="1" align="right"><a href="<?php echo esc_url(admin_url('admin.php?page=addbanner_bannerad'));?>" class="aa">[NEW]</a></td>
            </tr>
            <tr>
                <td align="center" width=""><strong>Name</strong></td>
                <td align="center" width=""><strong>Image</strong></td>
                <td align="center" width=""><strong>Delete</strong></td>
            </tr>
				<?php
				$query = $wpdb->get_results($wpdb->prepare("SELECT COUNT(*) as num FROM banneradslideshow"));
				foreach($query as $row)	{
				$total_pages = $row->num;
				}
				$targetpage = $current_url;
				$limit = 4;
				$page = (isset($_GET['paged'])) ? (int)sanitize_text_field($_GET['paged']) : 0;
				if($page) 
				$start = ($page - 1) * $limit; 			
				else
				$start = 0;

				$bannertitle = "";
				$bannerimage = "";
				$bannerid = "";
				$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM banneradslideshow ORDER BY `intbannerid` DESC LIMIT $start, %d", $limit ));
				if($result)	{
				foreach($result as $row)	{			
				$bannertitle = sanitize_text_field($row->varbannertitle);
				$bannerimage = sanitize_text_field($row->varbannerimage);
				$bannerid = sanitize_text_field($row->intbannerid);
	
				?>
            <tr>
                <td align="center" width=""><?php echo esc_html($bannertitle); ?></td>
                <td align="center" width="">
				<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'images/banner/'.$bannerimage.''); ?>"
                 width="100" height="100" border="0" />
				</td>
				<td align="center" width="">
                    <a Title="Click here to Delete" class="link"
                        href="<?php echo esc_url(admin_url('admin.php?page=bannermanager_bannerad'));?>&a=3&amp;bannerid=<?php echo esc_html($bannerid);?>"
                        onClick="return confirm('Are you sure to delete this record ?');">
                        <img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'images/delete.bmp'); ?>"
                            border="0" />
                    </a>
                </td>
            </tr>
			<?php
					}
				}
	
			?>
			<tr>  
			<td colspan="3">
			<div align="left" class="pagination">
			<div class="results">
			<?php
			$adjacents = 1;
			if ($page == 0) $page = 1;					
			$prev = $page - 1;							
			$next = $page + 1;							
			$lastpage = ceil($total_pages/$limit);		
			$lpm1 = $lastpage - 1;						
			$pagination = "";
			if($lastpage > 1)
			{	
			$pagination .= "<div class=\"pagination\">";
			if ($page > 1) 
				$pagination.= "<a href=\"$targetpage&paged=$prev\">&laquo; previous</a>";
			else
				$pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
				
			if ($lastpage < 7 + ($adjacents * 2))	
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&paged=$counter\">$counter</a>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	
			{
				
				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage&paged=$counter\">$counter</a>";					
					}
					$pagination .= "<span class=\"elipses\">...</span>";
					$pagination.= "<a href=\"$targetpage&paged=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage&paged=$lastpage\">$lastpage</a>";		
				}
				
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<a href=\"$targetpage&paged=1\">1</a>";
					$pagination.= "<a href=\"$targetpage&paged=2\">2</a>";
					$pagination .= "<span class=\"elipses\">...</span>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage&paged=$counter\">$counter</a>";					
					}
					$pagination .= "<span class=\"elipses\">...</span>";
					$pagination.= "<a href=\"$targetpage&paged=$lpm1\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage&paged=$lastpage\">$lastpage</a>";		
				}
				
				else
				{
					$pagination.= "<a href=\"$targetpage&paged=1\">1</a>";
					$pagination.= "<a href=\"$targetpage&paged=2\">2</a>";
					$pagination .= "<span class=\"elipses\">...</span>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage&paged=$counter\">$counter</a>";					
					}
				}
			}
			
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage&paged=$next\">next &raquo;</a>";
			else
				$pagination.= "<span class=\"disabled\">next &raquo;</span>";
			$pagination.= "</div>\n";		
			}
			?>

            <?php 
			$allowed_html = banner_ad_slideshow_allowed_html();
			echo wp_kses($pagination, $allowed_html);			
			?>
			</div>
			</div>
			
			</td>
			</tr>

				
        </tbody>
    </table>




