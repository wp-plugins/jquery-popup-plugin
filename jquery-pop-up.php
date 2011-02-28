<?php
/*
Plugin Name: jQuery Popup
Version: 0.0.1
Description: This plugin integrates a modified version of Hvem Glor's bPopup jquery plugin into your WordPress installation. It provides an easy set of options to control the style and behavior of the popup. Options include: more (enable, disable or preview), set cookie, cookie expires, background color, overlay color, vertical position, and delay.
Author: Mike Van Winkle
Author URI: http://www.mikevanwinkle.com
Plugin URI: http://www.mikevanwinkle.com/wordpress/wordpress-jquery-popup-plugin-beta/
License: GPL
*/
?>
<?php

/* Constants */

define('POP_DIR', rtrim(dirname(__FILE__), '/'));
define('POP_URL', plugins_url() . '/jquery-popup-plugin/');
define('SITENAME',get_bloginfo('site'));

/*Version Check*/
global $wp_version;
$exit_msg = "Dude, upgrade your stinkin Wordpress Installation.";
if(version_compare($wp_version, "3.0-Beta", "<")) { exit($exit_msg); }

/*Hooks and Filters*/

add_action('init', 'register_popup_script');
add_action('admin_menu','popup_settings_init');
add_action('wp_print_footer_scripts', 'popup_footer_script',10);
add_action('wp_footer','popup_footer_div');
add_action('init','popup_cookie_check',1);

/*Register Scripts*/

function register_popup_script() {
	$options = get_option('popup_options');
	wp_register_script('popup', POP_URL . 'jquery.bpopup-0.4.js', array('jquery'));
	wp_register_style('popup-style', POP_URL . 'base.style.css'); 
	if(!is_admin()) { 
		wp_enqueue_script('popup');
			if($options['default_style'] == 'on') {
				wp_enqueue_style('popup-style');
			}
	}
}


/**
**
** Setup Function
**
**/

function popup_settings_init() {
	add_submenu_page( 'options-general.php', 'jQuery Popup Settings', 'Popup', 'manage_options', 'jquery_popup', 'popup_settings_page' );
}


/**
**
** Creates options page
**
**/

function popup_settings_page() { 
	popup_save_options();
	$options = get_option('popup_options'); 
	if(!$options) {
		$options = array(
		'mode' => 'disabled',
		'header' => '',
		'body' => '',
		'overlay' => '#000',
		'close' => 'on',
		'default_style' => 'on',
		'delay'=> '1000',
		'vertical'=> 100,
		'cookie'=> 'on',
		'expires'=> '3600',
		'background' => '#fff'
		); }
	include('options-page.php');
}


/**
**
** This function saves the options 
**
**/

function popup_save_options() {
	if(isset($_POST['save-popup'])) {
		if(wp_verify_nonce('save_changes_nonce', '_popup_nonces')) { wp_die('Death to hackers'); } else {
		
		// set defaults
		$options = array(
			'mode' => 'disabled',
			'header' => '',
			'body' => '',
			'overlay' => '#000',
			'vertical' => '100',
			'close' => 'on',
			'default_style' => 'on',
			'delay'=>1000,
			'cookie' => 'on',
			'expires'=>'3600',
			'background' => '#fff');
		
		//replace defaults with form values
		foreach($options as $k => $v):
			if($_POST['popup_' .$k] != $options[$k] || $_POST['popup_' .$k] != '' ) {
			$options[$k] = $_POST['popup_'.$k];
			}
		endforeach;
		
		//send to databse
		update_option('popup_options',$options);
		} 
	}
}


/**
**
** Adds a div to the wp_footer hook to hold the popup content
**
**/

function popup_footer_div() { ?>
	<?php $options = get_option('popup_options'); ?>
	<div id="jq-popup" style="display:none; width: 25%; background-color:<?php echo $options['background']; ?>;">
	<?php $popup = get_option('popup_options'); ?>
	<?php if($options['close'] == 'on') { ?><div class="pClose"></div><?php } ?>
	<p><?php echo stripslashes($popup['body']); ?></p>
	</div>
<?php
}


/**
**
** Adds the script to the template 
**
**/

function popup_footer_script() {
	$options = get_option('popup_options');
	global $popup_cookie;
	// check if is disabled
		if($options['mode'] == 'enabled' && $popup_cookie != 1) {
			
				$array = setup_popup_options();
				print_popup_script($array);	
				
			} elseif($options['mode'] == 'disabled') {
				//do nothing
			} else {
				if($_GET['pop'] == 'preview') {
					$array = setup_popup_options();
					print_popup_script($array);	
				}
			}
}

function setup_popup_options() {
	$options = get_option('popup_options');
	$delay = $options['delay'] * 1000;
	$array = array(); 
	$array = array(
		'modalColor' => $options['overlay'],
		'vStart'=> intval($options['vertical']),
		'closeClass'=>'pClose',
		'delay' => intval($delay),
		);
	$array = json_encode($array);
	return $array;
}

function print_popup_script($array) { 
	if(!is_admin()) {
	?>
	<script type="text/javascript">
	var j = jQuery.noConflict(); 
	j(document).ready(function() {
		j('#jq-popup').bPopup(<?php echo $array; ?>);
	});
	</script>
	<?
	}
}

/**
**
** Checks for cookie before page loads
**
**/

function popup_cookie_check() {
	session_start();
	$options = get_option('popup_options');
	$exp = intval($options['expires']);
	$cookie = $options['cookie'];
	if($cookie == 'on') {
		global $popup_cookie;
		if(isset($_COOKIE['popup_seen_'])) {
			$popup_cookie = 1;
		} else {
			$popup_cookie = false;
			setcookie("popup_seen_", 1 );
		}
		return $popup_cookie;;
	} else {
		unset($_COOKIE['popup_seen_']);
		return false;
	}
}

?>