<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
 * Filename: functions.php
 * Description: 
 * Date: 28 dec. 2011
 * Company: lettow
 * URL: www.unimecs.com
 * Copyright: lettow, 2011
 * Version:
 * Last changed:
 */

/*scripts*/
require_once dirname(__FILE__).DS.'scripts.php';
/*System*/
require_once dirname(__FILE__).DS.'system'.DS.'system.php';
/*Post*/
require_once dirname(__FILE__).DS.'post'.DS.'post.php';
/*Template function*/
require_once dirname(__FILE__).DS.'template.php';
/* Login */
require_once dirname(__FILE__).'/login.php';

/* Login */
//require_once dirname(__FILE__).'/email.php';


/*Register Thumbsizes*/

/* Register theme locations */
register_nav_menu( 'main-menu', 'Main menu' );