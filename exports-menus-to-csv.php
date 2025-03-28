<?php
/*
Plugin Name: Exports Menus to CSV
Plugin URI: https://github.com/webteammarelle/WP-Exports-Menus-to-CSV.git
Description: Exports all site menus to a CSV file with sanitized columns: menu_name, title, url, order, item_id, parent_id. Access is restricted to administrators.
Version: 1.0
Author: Marelle
Author URI: https://marelle.eu/
License: GPL2
*/

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load plugin textdomain.
 */
function emtc_load_textdomain() {
    load_plugin_textdomain( 'emtc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'emtc_load_textdomain' );

/**
 * Adds an admin page under the Tools menu.
 */
function emtc_add_admin_menu() {
    add_management_page(
        __( 'Export Menus', 'emtc' ),      // Page title
        __( 'Export Menus', 'emtc' ),      // Menu title
        'manage_options',                 // Required capability
        'emtc-export-menus',              // Menu slug
        'emtc_admin_page'                 // Callback function to display the page
    );
}
add_action( 'admin_menu', 'emtc_add_admin_menu' );

/**
 * Displays the plugin's admin page.
 */
function emtc_admin_page() {
    // Check that the user is an administrator.
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'emtc' ) );
    }
    ?>
    <div class="wrap">
        <h1><?php _e( 'Export Menus', 'emtc' ); ?></h1>
        <p><?php _e( 'Click the button below to export all site menus as a CSV file.', 'emtc' ); ?></p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php
            // Security: add a nonce field
            wp_nonce_field( 'emtc_export_nonce', 'emtc_export_nonce_field' );
            ?>
            <input type="hidden" name="action" value="emtc_export_menus">
            <p>
                <input type="submit" class="button-primary" value="<?php _e( 'Export', 'emtc' ); ?>">
            </p>
        </form>
    </div>
    <?php
}

/**
 * Processes the CSV export when the form is submitted.
 */
function emtc_export_menus() {
    // Verify user permissions and nonce for security.
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Unauthorized access.', 'emtc' ) );
    }
    if ( ! isset( $_POST['emtc_export_nonce_field'] ) || ! wp_verify_nonce( $_POST['emtc_export_nonce_field'], 'emtc_export_nonce' ) ) {
        wp_die( __( 'Invalid nonce.', 'emtc' ) );
    }

    // Set the headers for the CSV file download.
    header( 'Content-Type: text/csv; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=menus.csv' );

    // Open the output stream for writing the CSV.
    $output = fopen( 'php://output', 'w' );

    // Write the CSV header row with sanitized column names.
    fputcsv( $output, array( 'menu_name', 'title', 'url', 'order', 'item_id', 'parent_id' ) );

    // Retrieve all registered menus on the site.
    $menus = wp_get_nav_menus();

    if ( ! empty( $menus ) ) {
        foreach ( $menus as $menu ) {
            // Retrieve the menu items for the current menu.
            $menu_items = wp_get_nav_menu_items( $menu->term_id );
            if ( ! empty( $menu_items ) ) {
                foreach ( $menu_items as $item ) {
                    // Get the required information for each menu item.
                    $menu_name = $menu->name;
                    $title     = $item->title;
                    $url       = $item->url;
                    $order     = $item->menu_order;
                    $item_id   = $item->ID;
                    $parent_id = $item->menu_item_parent; // 0 if no parent

                    // Write a row to the CSV file.
                    fputcsv( $output, array( $menu_name, $title, $url, $order, $item_id, $parent_id ) );
                }
            }
        }
    }

    fclose( $output );
    exit;
}
add_action( 'admin_post_emtc_export_menus', 'emtc_export_menus' );
