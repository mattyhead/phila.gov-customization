<?php
/**
 * Contains :
 * Change admin lables
    * post > information Page
    * page > Department Page
 * redorder admin menu
 * custom post types
    * Services
    * News
 *
 * @link https://github.com/CityOfPhiladelphia/phila.gov-customization
 * 
 * @package phila.gov-customization
 */


/**
 * Change admin lables
 *
 * @link https://github.com/CityOfPhiladelphia/phila.gov-customization
 * 
 * @package phila.gov-customization
 */

if (!class_exists('PhilaGovCustomAdminLabels')){
    class PhilaGovCustomAdminLabels {
        function change_admin_post_label(){
            global $menu;
            global $submenu;
                
            $menu[5][0] = 'Information Page';
            $submenu['edit.php'][5][0] = 'Information Page';
            $submenu['edit.php'][10][0] = 'Add Information Page';
                
            echo '';
            //remove comments, this is here b/c we are using the add_action hook
            remove_menu_page('edit-comments.php');
        }
        
        function change_admin_post_object(){
            global $wp_post_types;
            //can't extract $lables in one go, so break it into 2 vars
            $get_post = $wp_post_types['post'];
            
            $lables = $get_post -> labels;
            $lables -> name = 'Information Page';
            $lables -> singular_name = 'Information';
            $lables -> add_new = 'Add Information Page';
            $lables -> add_new_item = 'Add Information Page';
            $lables -> edit_item = 'Edit Information Page';
            $lables -> new_item = 'Information';
            $lables -> view_item = 'View Information Page';
            $lables -> search_items = 'Search Information Pages';
            $lables -> not_found = 'No Information Page Found';
            $lables -> not_found_in_trash = 'No Information Page found in Trash';
            $lables -> all_items = 'All Information Pages';
            $lables -> menu_name = 'Information Page';
            $lables -> name_admin_bar = 'Information Page';
        }
        
  
        
        function change_admin_page_label(){
            global $menu;
            global $submenu;
                
            $menu[20][0] = 'Phila.gov Page';
            $submenu['edit.php?post_type=page'][5][0] = 'Phila.gov Page';
            $submenu['edit.php?post_type=page'][10][0] = 'Add Phila.gov Page';
                
            echo '';
        }
        
        function change_admin_page_object(){
            global $wp_post_types;
            //can't extract $lables in one go, so break it into 2 vars
            $get_page = $wp_post_types['page'];
            $lables = $get_page -> labels;
            $lables -> name = 'Phila.gov Page';
            $lables -> singular_name = 'Phila.gov';
            $lables -> add_new = 'Add Phila.gov Page';
            $lables -> add_new_item = 'Add Phila.gov Page';
            $lables -> edit_item = 'Edit Phila.gov Page';
            $lables -> new_item = 'Phila.gov';
            $lables -> view_item = 'View Phila.gov Page';
            $lables -> search_items = 'Search Phila.gov Pages';
            $lables -> not_found = 'No Phila.gov Page Found';
            $lables -> not_found_in_trash = 'No Phila.gov Page found in Trash';
            $lables -> all_items = 'All Phila.gov Pages';
            $lables -> menu_name = 'Phila.gov Page';
            $lables -> name_admin_bar = 'Phila.gov Page';
            
            //also, register post_tag and cats
            register_taxonomy_for_object_type('post_tag', 'page');
            register_taxonomy_for_object_type('category', 'page'); 
        
        }
        
        
    }//end PhilaGovCustomAdminLables
}

//create instance of PhilaGovCustomAdminLabels
if (class_exists("PhilaGovCustomAdminLabels")){
    $admin_menu_lables = new PhilaGovCustomAdminLabels();
}

if (isset($admin_menu_lables)){
    //WP actions
    add_action( 'init', array($admin_menu_lables, 'change_admin_post_object'));
    add_action( 'admin_menu', array($admin_menu_lables, 'change_admin_post_label')); 
    
    add_action( 'init', array($admin_menu_lables, 'change_admin_page_object'));
    add_action( 'admin_menu', array($admin_menu_lables, 'change_admin_page_label'));

}

/**
 *  Create Custom Post Types
 *
 * Additional custom post types can be defined here
 * http://codex.wordpress.org/Post_Types
 *
 * @link https://github.com/CityOfPhiladelphia/phila.gov-customization
 *
 *
 */

if (!class_exists('PhilaGovCustomPostTypes')){
    class PhilaGovCustomPostTypes{
        function create_services_post_type() {
          register_post_type( 'service_post',
            array(
                'labels' => array(
                    'name' => __( 'Service Page' ),
                    'singular_name' => __( 'Service Page' ),
                    'add_new'   => __('Add Service Page'),
                    'all_items'   => __('All Service Pages'),
                    'add_new_item' => __('Add Service Page'),
                    'edit_item'   => __('Edit Service Page'),
                    'view_item'   => __('View Service Page'),
                    'search_items'   => __('Search Service Pages'),
                    'not_found'   => __('Service Page Not Found'),
                    'not_found_in_trash'   => __('Service Page not found in trash'),
              ),
                'taxonomies' => array('category', 'post_tag'),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-groups',
                'hierarchical' => false,
                'rewrite' => array(
                    'slug' => 'service',
                ),
            )
          );
        }
    
        function create_departments_page_type() {
          register_post_type( 'department_page',
            array(
                'labels' => array(
                    'name' => __( 'Department Page' ),
                    'singular_name' => __( 'Department Page' ),
                    'add_new'   => __('Add Department Page'),
                    'all_items'   => __('All Department Pages'),
                    'add_new_item' => __('Add Department Page'),
                    'edit_item'   => __('Edit Department Page'),
                    'view_item'   => __('View Department Page'),
                    'search_items'   => __('Search Department Pages'),
                    'not_found'   => __('Department Page Not Found'),
                    'not_found_in_trash'   => __('Department Page not found in trash'),
              ),
                'taxonomies' => array('category', 'post_tag'),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-groups',
                'hierarchical' => true,
                'rewrite' => array(
                    'slug' => 'department',
                ),
            )
          );
        }
        
         function create_news_post_type() {
          register_post_type( 'news_post',
            array(
                'labels' => array(
                    'name' => __( 'News' ),
                    'singular_name' => __( 'News' ),
                    'add_new'   => __('Add News'),
                    'all_items'   => __('All News'),
                    'add_new_item' => __('Add News'),
                    'edit_item'   => __('Edit News'),
                    'view_item'   => __('View News Item'),
                    'search_items'   => __('Search News'),
                    'not_found'   => __('News Not Found'),
                    'not_found_in_trash'   => __('News not found in trash'),
              ),
                'taxonomies' => array('category', 'post_tag'),
                'public' => true,
                'has_archive' => true,
                'menu_position' => 6,
                'menu_icon' => 'dashicons-media-document',
                'hierarchical' => false,
                'rewrite' => array(
                    'slug' => 'news',
                ),
            )
          );
        }        
    }//end class

}


if (class_exists("PhilaGovCustomPostTypes")){
    $custom_post_types = new PhilaGovCustomPostTypes();
}

if (isset($custom_post_types)){
    //actions
    add_action( 'init', array($custom_post_types, 'create_services_post_type'));
    add_action( 'init', array($custom_post_types, 'create_news_post_type'));
    add_action( 'init', array($custom_post_types, 'create_departments_page_type'));
    register_activation_hook( __FILE__, array($custom_post_types, 'rewrite_flush') );
}

/**
 * Reorder Menu Items
 *
 * 
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/custom_menu_order
 *
 * @link https://github.com/CityOfPhiladelphia/phila.gov-customization
 *
 *
 */
if (!class_exists('PhilaGovCustomMenuOrdering')){
    class PhilaGovCustomMenuOrdering {
        function custom_menu_order($menu_ord) {
            if (!$menu_ord) return true;

            return array(
                'index.php', // Dashboard
                'separator1', // First separator
                'edit.php', // Posts
                'edit.php?post_type=service_post', // Links
                'edit.php?post_type=page', // Pages
                'upload.php', // Media
            );
        }
    }
}

if (class_exists("PhilaGovCustomMenuOrdering")){
    $change_menu_order = new PhilaGovCustomMenuOrdering();
}
if (isset($change_menu_order)){
    add_filter('custom_menu_order', array($change_menu_order, 'custom_menu_order')); // Activate custom_menu_order
    add_filter('menu_order', array($change_menu_order, 'custom_menu_order'));
}