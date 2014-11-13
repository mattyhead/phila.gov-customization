<?php 	
/**
 * Plugin Name: Phila.gov Customization
 * Plugin URI: https://github.com/CityOfPhiladelphia/phila.gov-customization
 * Description Custom Wordpress functionality, custom post types, custom taxonomies, etc.
 * Version: 1.0
 * Author: Karissa Demi
 * Author URI: http://karissademi.com 
 * 
 * @package phila.gov-customization
 */

$dir = plugin_dir_path( __FILE__ );

require $dir.'/taxonomies.php';
require $dir.'/post-types.php';