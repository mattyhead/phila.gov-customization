<?php

/**
 * Add custom js to force category selection for Department Author roles
 *
 * @since   0.11.0
 */

add_action( 'plugins_loaded', 'department_author_only' );

function department_author_only(){
  if ( current_user_can( 'department_author' ) ){
    add_action( 'admin_enqueue_scripts', 'administration_admin_scripts' );
  }
}


function administration_admin_scripts() {
	wp_enqueue_script( 'admin-script', plugins_url( '../js/admin-department-author.js' , __FILE__ ) );
}

// define the custom capability name for protected content
define ( 'PHILA_ADMIN', 'see_all_content' );

add_action( 'wp_loaded', 'phila_roles_and_capabilities' );

function phila_roles_and_capabilities(){

  // add the custom capability to other qualified roles
  get_role( 'administrator' )->add_cap( PHILA_ADMIN );
  get_role( 'editor' )->add_cap( PHILA_ADMIN );

}
// Instantiate new class
$phila_role_administration_load = new PhilaRoleAdministration();

class PhilaRoleAdministration {

    public function __construct(){
        //we can only run this role-check after plugins have been loaded
        add_action( 'plugins_loaded', array( $this, 'check_if_user_logged_in' ) );

        //remove our unwanted widgets
        add_action( 'after_setup_theme', array($this, 'remove_others_widgets'), 11 );


    }

    /**
  	 * Outputs all categories into an array w/ just slugs.
  	 *
  	 * @since 0.11.0
  	 * @return $cat_slugs array Returns an array of all categories.
  	 */
    public function get_categories(){
      $categories_args = array(
          'type'                     => 'post',
          'child_of'                 => 0,
          'parent'                   => '',
          'orderby'                  => 'name',
          'order'                    => 'ASC',
          'hide_empty'               => 1,
          'hierarchical'             => 0,
          'taxonomy'                 => 'category',
          'pad_counts'               => false
      );

      $categories = get_categories( $categories_args );

      $cat_slugs =[];

      //loop through and push slugs to $cat_slugs
      foreach( $categories as $category ){
        array_push( $cat_slugs, $category->slug );
      }
      //add category slugs to their own array
      return $cat_slugs;
    }

    /**
     * Matches category on user role.
     *
     * @since 0.11.0
     * @uses get_categories() Outputs all categories into an array w/ just slugs.
     * @uses wp_get_current_user()   https://codex.wordpress.org/Function_Reference/wp_get_current_user
     * @return $cat_slugs array Returns an array of all categories.
     */

    public function get_current_category_slug() {
      $cat_slugs = $this->get_categories();

      if ( is_user_logged_in() ){
        //define current_user, we should only do this when we are logged in
        $user = wp_get_current_user();
        $all_user_roles = $user->roles;
        $all_user_roles_to_cats = str_replace('_', '-', $all_user_roles);

        //matches rely on Category slug and
        //if there are matches, then you have a secondary role that should not be allowed to see other's menus, etc.
        $current_user_cat_assignment = array_intersect( $all_user_roles_to_cats, $cat_slugs );
      }
      return $current_user_cat_assignment;
    }
  /**
   * Outputs all categories into an array w/ just slugs.
   *
   * @since 0.11.0
   * @uses get_categories() Outputs all categories into an array w/ just slugs.
   * @uses get_category_by_slug()   https://codex.wordpress.org/Function_Reference/get_category_by_slug
   * @return $cat_slugs array Returns an array of all categories.
   */
    public function check_if_user_logged_in(){

      $current_user_cat_assignment = $this->get_current_category_slug();

        if( count( $current_user_cat_assignment ) > 0 ) {
          //TODO make this applicable to more than one sub category
          $current_category = get_category_by_slug( $current_user_cat_assignment[1] );
          $current_cat_slug = strval( $current_category->slug );
          $current_cat_id = $current_category->cat_ID;
          $sidebar_id = 'sidebar-' . $current_cat_slug . '-' . $current_cat_id ;
          add_action( 'admin_enqueue_scripts', 'administration_admin_scripts' );

          return $sidebar_id;
        }
      }

  /**
	 * Removes widgets that don't belong to this department category
	 *
	 * @since 0.11.0
   * @uses check_if_user_logged_in() Outputs all categories into an array w/ just slugs.
	  */
    public function remove_others_widgets(){
    $current_user_cat_assignment = $this->get_current_category_slug();
      $cat_object = get_category_by_slug($current_user_cat_assignment[1]);

      //assign $sidebar_id to new var
    	$sidebar_id	= $this->check_if_user_logged_in();

      if ( ! $sidebar_id == null ) {
        //this needs to remove all sidebars
        remove_action( 'widgets_init', 'phila_gov_widgets_init', 10 );

        //re-register the sidebar we just unregistered...
        //TODO see if there is a better way to do this. Seems hacky.
        //also, fails if slug name changes...

        register_sidebar( array(
      		'name'          => __( $cat_object->name . ' Sidebar', 'phila-gov' ),
      		'id'            => $sidebar_id,
      		'description'   => '',
      		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      		'after_widget'  => '</aside>',
      		'before_title'  => '<h1 class="widget-title">',
      		'after_title'   => '</h1>',
      	) );
      }
    }
}//end PhilaRoleAdministration
