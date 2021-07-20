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
    // Create Meta Boxes in Custom Post Type centric_documents
    add_action( 'add_meta_boxes', array( $this, 'dl_download_meta_boxes' ) );

    // Save meta data.
    add_action( 'save', array( $this, 'dl_save' ) );

    // Add shortcode
    add_shortcode( 'doc-lense', array( $this, 'dl_load_shortcode' ) );

    // Hook for adding admin menus
    add_action( 'admin_menu', 'dl_register_ref_page' );
  }
  /**
   * Custom type meta boxes.
   *
   * return @void
   */
   public function dl_download_meta_boxes(){
     add_meta_box( 'upload_file', 'Attach File', 'dl_render_meta_box_content', 'centric_documents', 'advanced', 'high' );
   }

   /**
   * Render Meta Box content.
   *
   * @param WP_Post $post The post object.
   */
   public function dl_load_shortcode(){
     ?>
     <div class="quicklinks__layout">
       <div class="popular__forms--links">
         <h3>Download popular forms</h3>
         <form action="" id="popular__form_download">
           <label for="document__title">
             <div class="select__form--input">
               <span class="selected__form">Application to Lease Land</span>
               <button id="downloadDoc" class="material-icons">arrow_drop_down</button>
             </div>
           </label>
           <input class="docdownload" type="submit" value="Download">
         </form>
       </div>
     </div>
     <?php
   }

}

new DocumentLense;

/**
 * Register a custom post type.
 *
 * return @void
 */
function dl_download_form_post_type() {
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
 add_action( 'init', 'dl_download_form_post_type' );

 /**
 * Custom Documents Columns.
 *
 * @param WP_Post $post The post object.
 */
 function dl_doclense_columns( $columns ){
   $newColumns = array();
   $newColumns['title'] = 'File Title';
   $newColumns['details'] = 'Excerpt Details';
   $newColumns['document'] = 'Document';
   $newColumns['date'] = 'Date';

   return $newColumns;
 }
 add_filter( 'manage_centric_documents_posts_columns', 'dl_doclense_columns' );

 // Manage custom column data
 add_action( 'manage_centric_documents_posts_custom_column', 'dl_doclense_custom_column_data', 10, 2 );
 function dl_doclense_custom_column_data( $column, $post_id ){
   switch ( $column ) {
     case 'details':
       echo get_the_excerpt();
       break;
    case 'document':
      $attached_document = get_post_meta( $post_id, '_file_meta_value_key', true );
      echo $attached_document;
      break;
     default:
       // code...
       break;
   }
 }

 /**
 * Render Meta Box content.
 *
 * @param WP_Post $post The post object.
 */
 function dl_render_meta_box_content( $post ){
    // Add an once field so we can check for it later.
    wp_nonce_field( '_wpnounce_field', 'wp_doc_haven' );

    // Use get_post_meta to retrieve an existing value from the database
    $value = get_post_meta( $post->ID, '_file_meta_value_key', true );

    // Display the form, using the current array_count_values
    ?>
    <label for="doclence_select_field"><?php _e( 'Attach a Document:' ); ?></label>
    <input id="doclence_doc_data" type="file" name="doclence_doc_data" value="<?php echo esc_attr( $value ); ?>" accept="application/pdf,application/msword">
    <?php
  }

 /**
 * Save the meta data when the post is saved.
 *
 * @param int $post_id The ID of the post being saved.
 */
 function dl_save( $post_id ){
   if( ! current_user_can('edit_post', $post_id ) ){
     return;
   }
   if( ! isset( $_POST['_wpnounce_field'] ) || ! wp_verify_nonce( $_POST['_wpnounce_field'], 'wp_doc_haven' ) ) {
     return;
   }
   if( array_key_exists( 'doclence_doc_data', $_POST ) ){
     $file_uploaded = sanitize_text_field( $_POST['doclence_doc_data'] );
     update_post_meta( $post_id, '_file_meta_value_key', $file_uploaded );
   }

 }

 /**
 * Adds a submenu page under a custom post type
 *
 */
 function dl_register_ref_page(){
   add_submenu_page(
     'edit.php?post_type=centric_documents',
     __( 'Documents Details', 'doclense' ),
     __( 'Details', 'doclense' ),
     'manage_options',
     'documents',
     'dl_ref_page_callback'
   );
 }

 function dl_ref_page_callback(){
  require_once( DL_LOCATION . '/inc/templates/doclense-admin.php' );
 }
