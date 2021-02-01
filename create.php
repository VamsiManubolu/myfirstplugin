<?php
/**
* Plugin Name: myfirstplugin
* Plugin URI: ''
* Description: Plugin  to add a form to upload a photo on the admin backend and show it on the website frontend.
.
* Author: Vamsi Manubolu
* Author URI: https://www.miniorange.com
* License: MIT/Expat
* License URI: https://docs.miniorange.com/mit-license
*/

//action

add_action("admin_menu","addMenu");


//call back function from line 26
function adduser(){
	include_once('index.php');
	
}



function addMenu(){
	$adduser=add_menu_page('MyPlugin' ,'WP_AVATAR' ,'administrator' ,' Mainmenu','adduser',plugin_dir_url(__FILE__).'images/gallery.png');
}







?>

