<?php
/**
 * Functions for Information/Department Finder
 * lives at /browse
 *
 * @link https://github.com/CityOfPhiladelphia/phila.gov-customization
 * 
 * @package phila.gov-customization
 */

//global $parent_topic;

function currentURL(){
    $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
         }
    $theURL = explode('/', rtrim($pageURL, '/'));
    //var_dump($theURL);
    return $theURL;
}

function display_topic_list() {
    $get_URL = currentURL();
    $url_last_item =  end($get_URL);
    $topic = count($get_URL);
    $parent_topic = '';
    if ($url_last_item === 'browse' ) {
        get_parent_topics();
    }elseif ($topic === 5) {
        $parent_topic === end($get_URL);
        get_children_topics();
    }elseif ($topic === 6){
        active_children_topics();
    }
}

function display_filtered_pages() {
    $get_URL = currentURL();
    $url_last_item =  end($get_URL);
    $topic = count($get_URL);
    $parent_topic = '';
    if ($url_last_item === 'browse' ) {
        
    }elseif ($topic === 5) {
        
    }elseif ($topic === 6){
        get_template_part( 'content', 'finder' );
                
          while ( have_posts() ) : the_post();
              get_template_part( 'content', 'list' );
          endwhile; 
                        
    }
}

function get_parent_topics(){
    $get_URL = currentURL();
    $url_last_item =  end($get_URL);
    $topic = count($get_URL);
        $parent_terms = get_terms('topics', array('orderby' => 'slug', 'parent' => 0));
    echo '<nav><ul>';
        foreach($parent_terms as $key => $parent_term) {
            
            echo '<li class="parent ' . $parent_term->slug . '"><a href="/browse/' . $parent_term->slug . '"><h3>' . $parent_term->name . '</h3>'; 
                      echo '<span>' . $parent_term->description . '</span></a></li>';
        }
    echo '</ul></nav>';
}   


function list_parent_topics(){
    $parent_terms = get_terms('topics', array('orderby' => 'slug', 'parent' => 0));
    foreach($parent_terms as $key => $parent_term) {

        echo '<li class="parent ' . $parent_term->slug . '"><a href="/browse/' . $parent_term->slug . '"><h3>' . $parent_term->name . '</h3>'; 
                  echo '<span>' . $parent_term->description . '</span></a></li>';
    }
}
function get_children_topics(){
    $url = currentURL();
    $last_term = end($url);
    $parent_term = $last_term;
    
    echo '<h2 class="current-topic">' . $parent_term . '</h2>';
    
    $child_terms = get_terms('topics', array('orderby' => 'slug', 'search' => $parent_term));
    
    $current_term = get_term_by( 'slug', $parent_term, 'topics' );

        //then set the args for wp_list_categories
         $args = array(
            'child_of' => $current_term->term_id,
            'taxonomy' => $current_term->taxonomy,
            'hide_empty' => 0,
            'hierarchical' => true,
            'depth'  => 1,
            'title_li' => ''
            );
         wp_list_categories( $args );
}

function active_children_topics(){
    $url = currentURL();
    end($url);
    $parent_term = prev($url);
    
    echo '<h2 class="current-topic">' . $parent_term . '</h2>';
    
    $child_terms = get_terms('topics', array('orderby' => 'slug', 'search' => $parent_term));
    
    $current_term = get_term_by( 'slug', $parent_term, 'topics' );

        //then set the args for wp_list_categories
         $args = array(
            'child_of' => $current_term->term_id,
            'taxonomy' => $current_term->taxonomy,
            'hide_empty' => 0,
            'hierarchical' => true,
            'depth'  => 1,
            'title_li' => ''
            );
         wp_list_categories( $args );
}