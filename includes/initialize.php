<?php
//difine the core paths
//difine them as absolute paths to make sure that require_once 
//works as expected

//DIRECTORY_SEPARATOR is PHP pre_define constant
//( \ for windows , / for unix)

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR) ;
//C:\xampp\htdocs\photo_gallary
defined('SITE_ROOT')?NULL : 
        define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'gardiniaService');

defined('LIB_PATH')?null :
                define('LIB_PATH', SITE_ROOT.DS.'includes');
// load config file first
require_once(LIB_PATH.DS."config.php");

//load basic function next so that everything after can use them
require_once(LIB_PATH.DS."functions.php");

//load core objects
require_once LIB_PATH.DS.'database.php';
require_once (LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS.'database_object.php');


//load database related classes
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."product_type.php");
//require_once(LIB_PATH.DS."previous_work.php");
