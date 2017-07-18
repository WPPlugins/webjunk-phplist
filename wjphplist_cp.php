<?php
$wj_mail_name = "WebJunk PHPList";
$wj_mail_shortname = "wj_mail";
$wj_mail_options=array();

function wj_mail_add_admin() {

	global $wj_mail_name, $wj_mail_shortname, $wj_mail_options;

	//echo 'mc='.get_magic_quotes_gpc().'/'.get_magic_quotes_runtime();
	
	if ( $_GET['page'] == basename(__FILE__) ) {

		if ( 'update' == $_REQUEST['action'] ) {
			wj_mail_activate();
			foreach ($wj_mail_options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				} else { delete_option( $value['id'] );
				}
			}
			header("Location: options-general.php?page=wjphplist_cp.php");
			die;
		}

		if ( 'install' == $_REQUEST['action'] ) {
			wj_mail_activate();
			foreach ($wj_mail_options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				} else { delete_option( $value['id'] );
				}
			}
			header("Location: options-general.php?page=wjphplist_cp.php&installed=true");
			die;
		}

		if( 'uninstall' == $_REQUEST['action'] ) {
			wj_mail_uninstall();
			foreach ($wj_mail_options as $value) {
				delete_option( $value['id'] );
				update_option( $value['id'], $value['std'] );
			}
			header("Location: options-general.php?page=wjphplist_cp.php&uninstalled=true");
			die;
		}
	}

	add_options_page($wj_mail_name." Options", "$wj_mail_name", 8, basename(__FILE__), 'wj_mail_admin');
}

function wj_mail_admin() {

	global $wj_mail_name, $wj_mail_shortname, $wj_mail_options, $wpdb;

	if ( $_REQUEST['installed'] ) echo '<div id="message" class="updated fade"><p><strong>'.$wj_mail_name.' installed.</strong></p></div>';
	if ( $_REQUEST['uninstalled'] ) echo '<div id="message" class="updated fade"><p><strong>'.$wj_mail_name.' uninstalled.</strong></p></div>';

	$wj_mail_version=get_option("wj_mail_version");
	?>
<div class="wrap">
<h2 class="wj-left"><b><?php echo $wj_mail_name; ?></b></h2>


<div style="clear:both"></div>

<hr />
<!-- 
<p>The following Wordpress users are active osTicket users</p>
 -->
<?php if ($wj_mail_version) {
		wj_mail_cp();
}
	?>
	<br />
<div id="wj-mail-cp-menu">
<form method="post">
<p>
	<?php
	if (empty($wj_mail_version))
	echo 'Please proceed with a clean install or deactivate your plugin';
	elseif ($wj_mail_version != WJ_MAIL_VERSION)
	echo 'You downloaded version '.WJ_MAIL_VERSION.' and need to upgrade your database (currently at version '.$wj_mail_version.').';
	elseif ($wj_mail_version == WJ_MAIL_VERSION)
	echo 'Your version ('.$wj_mail_version.') is up to date!';

	?>
	</p>

<?php if (!$wj_mail_version) { ?>
<p class="submit"><input name="install" type="submit" value="Install" /> <input type="hidden"
	name="action" value="install"
/></p>


<?php }  ?>

</form>
<form method="post">
<p class="submit"><input name="uninstall" type="submit" value="Uninstall" /> <input type="hidden"
	name="action" value="uninstall"
/></p>
</form>
</div>
<div style="clear:both"></div>
<hr />
<p>For more info and support, contact us at <a href="http://webjunk.com/">WebJunk.com</a></p>
<hr />
	<?php
}

function wj_mail_cp() {
	global $wj_mail_content;
	global $wj_mail_menu;
//	global $wj_mail_post;
	
	if (empty($_GET['zlist'])) $_GET['zlist']='admin/index';
	
	wj_mail_header();
//echo '<div width="100%">';
	echo '<div id="wjmail-mailz-cp-content">';
	if ($_GET['zlistpage']=='admin') {
		echo 'Please use the <a href="users.php">Wordpress Users menu</a> to change <strong>admin</strong> user details';
	} else {
		echo '<div id="phplist">'.$wj_mail_content.'</div>';
	}
	echo '</div>';
	echo '<div id="wj-mail-cp-menu">';
	echo $wj_mail_menu;
	echo '</div>';
//echo '</div>';
	
}

add_action('admin_menu', 'wj_mail_add_admin'); ?>