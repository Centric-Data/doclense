<?php
/**
 * Document-Lense
 *
 * @package     Document-Lense
 * @author      Centric Data
 * @copyright   2021 Centric Data
 * @license     GPL-2.0-or-later
 *
*/
/*
Plugin Name: Document-Lense
Plugin URI:  https://github.com/Centric-Data/doclense
Description: This is a file download plugin, when activated allows files to be uploaded in the backend, and downloaded in the frontend. Files can be pdf, doc,docx
Author: Centric Data
Version: 1.0.0
Author URI: https://github.com/Centric-Data
Text Domain: doclense
*/
/*
Document-Lense is free software: you can redistribute it and/or modify it under the terms of GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.

Document-Lense Form is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Contact-Lense Form.
*/

/* Exit if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define variable for path to this plugin file.
define( 'DL_LOCATION', dirname( __FILE__ ) );
define( 'DL_LOCATION_URL' , plugins_url( '', __FILE__ ) );
define( 'DL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 *
 */
class DocumentLense
{

  public function __construct()
  {

  }


}

/**
 * Register a custom post type.
 *
 * return @void
 */
function ls_download_form_post_type() {
   $labels = array(
     'name'           => _x( 'Documents', 'Post type general name', 'doclense' ),
     'singular'       => _x( 'Document', 'Post type singular name', 'doclense' ),
     'menu_name'      => _x( 'Documents', 'Admin Menu Text', 'lands' ),
     'name_admin_bar' => _x( 'Document', 'Add New on Toolbar', 'doclense' ),
     'add_new'        => __( 'Add New', 'doclense' ),
     'add_new_item'   => __( 'Add New Document', 'doclense' ),
     'new_item'       => __( 'New Document' ),
     'edit_item'      => __( 'Edit Document', 'doclense' ),
     'view_item'      => __( 'View Document', 'doclense' ),
     'all_items'      => __( 'All Documents', 'doclense' ),
   );
   $args   = array(
     'labels'          => $labels,
     'public'          => true,
     'has_archive'     => true,
     'hierarchical'    => false,
     'supports'        => array( 'title', 'editor' ),
     'capability_type' => 'post',
     'menu_icon'       => 'dashicons-text-page',
   );
   register_post_type( 'centric_documents', $args );
 }
 add_action( 'init', 'ls_download_form_post_type' );
