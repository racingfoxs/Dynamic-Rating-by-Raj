<?php
   /*
   Plugin Name: Dynamic Display Rating by Raj
   Plugin URI: https://github.com/racingfoxs/Dynamic-Rating-by-Raj
   description: A plugin helps to display rating dynamically out of given number.
   Version: 1.0
   Author: Mr. Divyashwar Raj
   Author URI: https://github.com/racingfoxs/Dynamic-Rating-by-Raj
   License: GPL2
   */

function wp_star_rating_frontend( $attr ) {
    $args = shortcode_atts( array(
        'rating' => 0,
		'max' => 5,
        'type'   => 'rating',
        'number' => 0,
        'echo'   => true,
    ), $attr );
    $parsed_args = wp_parse_args( $attr, $args );
 
    // Non-English decimal places when the $rating is coming from a string.
    $rating = (float) str_replace( ',', '.', $parsed_args['rating'] );
 
    // Convert percentage to star rating, 0..5 in .5 increments.
    if ( 'percent' === $parsed_args['type'] ) {
        $rating = round( $rating / 10, 0 ) / 2;
    }
 
    // Calculate the number of each type of star needed.
    $full_stars  = floor( $rating );
    $half_stars  = ceil( $rating - $full_stars );
    $empty_stars = $parsed_args['max'] - $full_stars - $half_stars;
 
    if ( $parsed_args['number'] ) {
        /* translators: 1: The rating, 2: The number of ratings. */
        $format = _n( '%1$s rating based on %2$s rating', '%1$s rating based on %2$s ratings', $parsed_args['number'] );
        $title  = sprintf( $format, number_format_i18n( $rating, 1 ), number_format_i18n( $parsed_args['number'] ) );
    } else {
        /* translators: %s: The rating. */
        $title = sprintf( __( '%s rating' ), number_format_i18n( $rating, 1 ) );
    }
 
    $output  = '<div>';
    $output .= str_repeat( '<img src="https://img.icons8.com/offices/30/000000/filled-star.png"/>', $full_stars );
    $output .= str_repeat( '<img src="https://img.icons8.com/offices/30/000000/star-half-empty.png"/>', $half_stars );
    $output .= str_repeat( '<img src="https://img.icons8.com/offices/30/000000/star.png"/>', $empty_stars );
    $output .= '</div>';
 
   

    return $output;
}

add_shortcode('stars', 'wp_star_rating_frontend'); 

?>