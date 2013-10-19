<?php 

  /*
   Plugin Name: Google Plus Auto Poster
   Plugin URI: http://www.wpsuperplugin.com
   Description: This plugin automatically publishes posts from on your google profile page
   Version: 1.0
   Author: Mr.Subhash Patel
   Author URI: http://www.wpsuperplugin.com
   */
  
function wpsp_googleplus_deactiveplugin()
{
	global $wpdb;
	
}
register_deactivation_hook( __FILE__, 'wpsp_googleplus_deactiveplugin' );


//Drop Database Table
function wpsp_googleplus_dropplugin()
{
	global $wpdb;
	delete_option('wpsp_gpapoption');
	delete_option('wpsp_gpapoptionstatus');
}
register_uninstall_hook( __FILE__, 'wpsp_googleplus_dropplugin' );


function wpsp_gmail_menu()
{
	//icon display on side title plugin in leftside
    $icon_url=WP_PLUGIN_URL."/google-plus-auto-poster/images/googleplusicone.png";
	add_menu_page('WPSP_Googlepost_Autopost', 'Google+Autopost', 'activate_plugins', 'wpspgpap_authontication', 'wpspgpap_authon',$icon_url);
	
}
add_action('admin_menu', 'wpsp_gmail_menu');

function wpspgpap_authon()
{
	$wpapgetoption =get_option('wpsp_gpapoption'); 	
	if(($_POST['username']!="" && $_POST['password']!="")) 
	{
		if($_POST['username']!="" && $_POST['password']!="")         
		{     
			require_once('apigoogleplus.php');
		        
			//Option Value                                 
			if ( get_option( 'wpsp_gpapoption' ) !== false  )   update_option( 'wpsp_gpapoption' , $_POST );            else                                                add_option('wpsp_gpapoption' , $_POST );       
			
			require_once('authontication.php'); 
		}
	}
	?>
<link href="<?php echo WP_PLUGIN_URL."/google-plus-auto-poster/css/wpspgoogleplus.css"; ?>" rel="stylesheet" type="text/css" />
<div style="margin-top:20px;">
<?php 
$statusgpap =get_option( 'wpsp_gpapoptionstatus');
		if($statusgpap=="success" && $msg=="")
		{
			?><div id="msg"><div class="success">Login Success</div></div><?php
		}
		if($statusgpap!="success" && $msg=="")
		{
			?><div id="msg"><div class="error">Incorrect Username/Password </div></div><?php
		}
?>
<div id="msg"><?php echo $msg; ?></div>
<div id="googleboxes">
  <div class="googleplusbody">
  <?php
  wp_enqueue_script("authvalidationjs", plugins_url( '/js/jquery.validate.js' , __FILE__ ), array("jquery"));
  wp_enqueue_script("authjs", plugins_url( '/js/authontication_check.js' , __FILE__ ), array("jquery"));
  ?>
    <h2>Google Plus Auto Post</h2>
    <div>
      <form action="admin.php?page=wpspgpap_authontication" method="post" name="authform" id="authform">
        <table class="form-table" width="100%">
          <tr valign="top">
            <th scope="row">Email Address:</th>
            <td><input type="text" name="username" class="googleforminput" id="username" value="<?php echo $wpapgetoption['username']; ?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row">Password:</th>
            <td><input type="password" name="password" class="googleforminput" id="password" value="<?php echo $wpapgetoption['password']; ?>" /></td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" name="submitauth"  class="button-primary extbutton" value="Submit" />
        </p>
      </form>
    </div>
    <div>Check official website for more information <a href="http://www.wpsuperplugin.com/download/google-auto-poster/">click here</a></div>
  </div>
</div>
</div>
<?php
}

global $post;

function wpspgpap()
{	
	global $wpdb;
	global $post;
	
	$my_postid = $post->ID;//This is page id or post id
	$gettype =get_post_type($my_postid);
	
	if($gettype=='post')
	{
		require_once('apigoogleplus.php');
		$content_post = get_post($my_postid);
		$gpap_guid =$content_post->guid;
		$gpap_title =$content_post->post_title;
		$message = $content_post->post_content;
		$message = apply_filters('the_content', $message);
		$message = str_replace(']]>', ']]&gt;', $message);
		
		$statusgpap =get_option( 'wpsp_gpapoptionstatus');
		if($statusgpap=="success")
		{
			require_once('authontication.php');
					
			//Login success then call if condition
			if (!$loginconnection)
			{
				// link with page title display
				$thumbnilcheck = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				
				if($thumbnilcheck!="")
				{
					$link = array('img'=>$thumbnilcheck,'link'=>$gpap_guid,'domain'=>'','title'=>$gpap_title,'txt'=>'');
					$contentsss = get_post_field('post_content', $my_postid);
					PostOnGooglePlus($contentsss,$link);	
					
				}
				else
				{
					$link = getlinkandtitle($content_post->guid);
					$contentsss = get_post_field('post_content', $my_postid);
					PostOnGooglePlus($contentsss,$link);	
					 
				}
			}
		}
	}
}
add_action('publish_post', 'wpspgpap');

?>
