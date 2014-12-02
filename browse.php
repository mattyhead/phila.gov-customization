<?php
/**
 * Functions for Information Finder
 * lives at /browse
 *
 * @link https://github.com/CityOfPhiladelphia/phila.gov-customization
 * 
 * @package phila.gov-customization
 */

function currentURL(){
    $page_URL = 'http';
        $page_URL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $page_URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
            $page_URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
         }
    $the_URL = explode('/', rtrim($page_URL, '/'));
    return $the_URL;
}


function display_browse_breadcrumbs(){
    $get_URL = currentURL();
    $url_last_item =  end($get_URL);
    $url = currentURL();
    end($url);
    $second_to_last = prev($url);
    $topic = count($get_URL);
    if ($topic === 5) {
        echo '<li><a href="/browse/' . $url_last_item. '">' .  replace_dashes($url_last_item) . '</a></li>';
    }elseif ($topic === 6){
        echo '<li><a href="/browse/' . $second_to_last . '">' .  replace_dashes($second_to_last) . '</a></li>';
        echo '<li><a href="/browse/' . $second_to_last . '/' . $url_last_item . '">'.  replace_dashes($url_last_item) . '</a></li>';
    }
}



function display_filtered_pages() {
    $get_URL = currentURL();
    $url_last_item =  end($get_URL);
    $topic = count($get_URL);
    $parent_topic = '';
    if ($topic === 6){
        get_template_part( 'content', 'finder' );    
        echo '<ul class="list">';
          while ( have_posts() ) : the_post();
              get_template_part( 'content', 'list' );
          endwhile; 
        echo '</ul>';
                        
    }
}

function replace_dashes($string) {
    $string = str_replace("-", " ", $string);
    $string = str_replace("and", "&", $string);
    return $string;
}

function get_topics(){
    $parent_terms = get_terms('topics', array('orderby' => 'slug', 'parent' => 0));
        foreach($parent_terms as $key => $parent_term) {
            
            echo '<li class="parent ' . $parent_term->slug .'"><h3><a href="/browse/' . $parent_term->slug . '">' . $parent_term->name . '</h3>'; 
            echo '<p class="parent-description">' . $parent_term->description . '</p></a></li>';
            
            $child_terms = get_terms('topics', array('orderby' => 'slug', 'parent' => $parent_term->term_id));
    
            if($child_terms) {
                echo '<ul>';
                    foreach($child_terms as $key => $child_term) {
                        echo '<li class="child ' . $parent_term->slug . ' '. $child_term->slug . '"><a href="/browse/'. $parent_term->slug . '/' . $child_term->slug . '">' . $child_term->name . '</a></li>';
                        echo '<p class="child-description ' . $parent_term->slug . ' '. $child_term->slug . '">' . $child_term->description . '</p>'; 
                    }
                echo '</ul>';
            }
    }
}