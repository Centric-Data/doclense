<?php
/**
 * Document-Lense Form
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
