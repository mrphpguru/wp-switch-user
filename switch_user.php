<?php
/**
 * Plugin Name: Switch user
 * Plugin URI: http://mrphpguru.com
 * Description: This plugin allows admin to switch user use shortcode [pq_switch_user].
 * Version: 1.0.0
 * Author: mrphpguru
 * Author URI: http://mrphpguru.com
 * License: GPL2
 */


wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');

add_shortcode('pq_switch_user', 'mrphpguru_switch_user');
function mrphpguru_switch_user()
{
	global $wpdb; 
	 $current_user = wp_get_current_user();


	if ($current_user->ID == 1 ) 
	{ 
		if(isset($_POST['switchUserEmail']) && $_POST['switchUserEmail'] != '')
		{
			$user_emails = $_POST['switchUserEmail']; 
			$user = get_user_by( 'email', $user_emails ); 
			if( $user ) {
			    wp_set_current_user( $user->ID, $user->user_login );
			    wp_set_auth_cookie( $user->ID );
			    do_action( 'wp_login', $user->user_login );
			    wp_redirect( home_url() ); exit;
			}
		}
	?>
		<div id="pqSwitchUser">
			
<style type="text/css">
	.ui-autocomplete
	{
		z-index: 999999 !important;
	}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($) {

<?php
 $wp_user_search = $wpdb->get_results("SELECT user_email,ID FROM $wpdb->users ORDER BY ID");
 $userEmails = '';
 foreach ( $wp_user_search as $userid ) 
 {
 	$userEmails .= "\"".$userid->user_email."\",";
 }
 ?>
var availableTags = [<?php echo $userEmails;?>];
           



            $( "#switchUserEmail" ).autocomplete({
                source: availableTags
            });
    });

</script>



			<form action="" method="post" name="switchUserMrphpguruForm">
			
			<input name="switchUserEmail" id="switchUserEmail" style="width:441px" /> 



			<input type="submit" name="switchUserMrphpguru" value="Switch User" />

		</div>
	<?php
	} //chk admin if close
}
