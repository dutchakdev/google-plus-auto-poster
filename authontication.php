<?php
$wpapgetoption =get_option('wpsp_gpapoption'); 	
$emailaddress = $wpapgetoption['username'];
$password = $wpapgetoption['password'];

//Gmail authontication check username and password
$loginconnection = conncetwithgoogleplus($emailaddress, $password);
if (!$loginconnection)
		{
			$msg ='<div class="success">Login Success</div>';
			//Option Value                             
			if ( get_option( 'wpsp_gpapoptionstatus' ) !== false  )   update_option( 'wpsp_gpapoptionstatus' , 'success' );            else                                                add_option('wpsp_gpapoptionstatus' , 'success' );      
		}
		else
		{
			$msg = '<div class="error">'.$loginconnection.'</div>';
			if ( get_option( 'wpsp_gpapoptionstatus' ) !== false  )   update_option( 'wpsp_gpapoptionstatus' , 'failed' );            else                                                add_option('wpsp_gpapoptionstatus' , 'failed' ); 
		}
?>
