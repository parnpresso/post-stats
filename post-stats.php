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
        'post-stats/post-stats-admin.php',
        'post_stats_home_page',
        'dashicons-analytics',
        3
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );


function post_stats_home_page(){
    $search_by_date = getdate();

    if ( isset( $_GET['search_by_date'] ) ) {
        $date_in_string = $_GET['search_by_date'];
        $formatted_date = explode( '-', $date_in_string );
        $raw_date_format = strtotime( $formatted_date[1] . '/' . $formatted_date[2] . '/' . $formatted_date[0] );
        $search_by_date = getdate( $raw_date_format );
    }

    $args = array(
        'posts_per_page'  => -1,
        'post_type'       => 'post',
        'post_status'     => 'publish',
        'year'            => $search_by_date['year'],
        'monthnum'        => $search_by_date['mon'],
        'day'             => $search_by_date['mday']
    );
    $posts = get_posts($args);

    $result =  '<div class="wrap">';
    $result .= '    <h2>Post Stats</h2>';
    $result .= '    <p>Posts created by today (' . date('Y-m-d') . ')</p>';
    $result .= '    <form action="" method="GET">';
    $result .= '        <input type="hidden" name="page" value="post-stats/post-stats-admin.php"></input>';
    $result .= '        Date: <input type="date" name="search_by_date" data-date="" data-date-format="DD MM YYYY" required></input>';
    $result .= '        <input type="submit" value="Search" class="button"></input>';
    $result .= '    </form>';
    $result .= '    <table class="widefat fixed" cellspacing="0" style="margin-top: 15px;">';
    $result .= '        <thead>';
    $result .= '            <tr>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 5%;"><strong>#</strong></th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 10%;"><strong>ID</strong></th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 50%;"><strong>Title</strong></th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 5%;"><strong>Views</strong></th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 15%;"><strong>Author</strong></th>';
    $result .= '                <th id="columnname" class="manage-column column-columnname" scope="col" style="width: 15%;"><strong>Date</strong></th>';
    $result .= '            </tr>';
    $result .= '        </thead>';
    $result .= '        <tbody>';

    $index = 1;
    foreach ( $posts as $post ) {
        $post_view_count = get_post_meta( $post->ID, 'post_views_count', true );

        $result .= '        <tr class="alternate">';
        $result .= '            <td class="column-columnname" scope="row">' . $index . '</td>';
        $result .= '            <td class="column-columnname" scope="row">' . $post->ID . '</td>';
        $result .= '            <td class="column-columnname"><a href="' . $post->guid . '" target="_blank">' . $post->post_title . '</a></td>';
        $result .= '            <td class="column-columnname">' . $post_view_count . '</td>';
        $result .= '            <td class="column-columnname">' . get_the_author_meta( 'first_name', $post->post_author ) . ' ' . get_the_author_meta( 'last_name', $post->post_author ) . '</td>';
        $result .= '            <td class="column-columnname">' . $post->post_date . '</td>';
        $result .= '        </tr>';

	$index++;
    }
    $result .= '        </tbody>';
    $result .= '    </table>';
    $result .= '</div>';

    echo $result;
}
