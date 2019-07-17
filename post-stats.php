<?php
/**
 * Plugin Name:       Post stats
 * Plugin URI:        https://parn.co
 * Description:       Simple post statistics
 * Version:           1.0.0
 * Author:            parnpresso
 * Author URI:        https://parn.co
 */


function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Post Stats', 'textdomain' ),
        'Post Stats',
        'manage_options',
        'myplugin/myplugin-admin.php',
        'post_stats_home_page',
        'dashicons-analytics',
        3
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );


function post_stats_home_page(){
    $today = getdate();
    $args = array(
        'posts_per_page'  => -1,
        'post_type'       => 'post',
        'post_status'     => 'publish',
        'year'            => $today['year'],
        'monthnum'        => $today['mon'],
        'day'             => $today['mday']
    );
    $posts = get_posts($args);

    $result =  '<div class="wrap">';
    $result .= '    <h2>Post Stats</h2>';
    $result .= '    <p>Posts created by today (' . date('Y-m-d') . ')</p>';
    $result .= '    <table class="widefat fixed" cellspacing="0">';
    $result .= '        <thead>';
    $result .= '            <tr>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 5%;">ID</th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 65%;">Title</th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 5%;">Views</th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 10%;">Author</th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 15%;">Date</th>';
    $result .= '            </tr>';
    $result .= '        </thead>';
    $result .= '        <tbody>';
    foreach ( $posts as $post ) {
        $result .= '        <tr class="alternate">';
        $result .= '            <td class="column-columnname" scope="row">' . $post->ID . '</td>';
        $result .= '            <td class="column-columnname"><a href="' . $post->guid . '" target="_blank">' . $post->post_title . '</a></td>';
        $result .= '            <td class="column-columnname">' . '0'. '</td>';
        $result .= '            <td class="column-columnname">' . get_the_author_meta( 'first_name', $post->post_author ) . ' ' . get_the_author_meta( 'last_name', $post->post_author ) . '</td>';
        $result .= '            <td class="column-columnname">' . $post->post_date . '</td>';
        $result .= '        </tr>';
    }
    $result .= '        </tbody>';
    $result .= '    </table>';
    $result .= '</div>';

    echo $result;
}
