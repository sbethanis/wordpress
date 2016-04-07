<?php
/**
* Plugin Name: Social
* Plugin URI:  https://sygnoos.com
* Description: Social media buttons.
* Version:     1.1.3
* Author:      Sygnoos
* Author URI:  https://www.sygnoos.com
*/
if (!defined( 'ABSPATH' )) exit;
require_once(dirname(__FILE__).'/config.php');
require_once(SGMB_CLASSES.'SGMB.php');
$sgmb = new SGMB();
$sgmb->init();
