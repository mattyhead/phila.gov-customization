<?php
/**
 * Plugin Name: Phila.gov Customization
 * Plugin URI: https://github.com/CityOfPhiladelphia/phila.gov-customization
 * Description: Custom Wordpress functionality, custom post types, custom taxonomies, etc.
 * Version: 0.3.3
 * Author: Karissa Demi
 * Author URI: http://karissademi.com
 *
 * @package phila.gov-customization
 */

$dir = plugin_dir_path( __FILE__ );

require $dir. '/meta-boxes.php';
require $dir. '/taxonomies.php';
require $dir. '/admin-ui.php';
require $dir. '/browse.php';
require $dir. '/departments.php';
require $dir. '/news.php';
require $dir. '/alerts.php';

//dashboard config
//require $dir. '/dashboard/alerts.php';
//require $dir. '/dashboard/disable-defaults.php';
