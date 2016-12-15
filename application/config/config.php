<?php

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 */

/**
 * Configuration for: Error reporting
 * Useful to show every little problem during development, but only show hard errors in production
 */
define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/**
 * Configuration for: URL
 * Here we auto-detect your applications URL and the potential sub-folder. Works perfectly on most servers and in local
 * development environments (like WAMP, MAMP, etc.). Don't touch this unless you know what you do.
 *
 * URL_PUBLIC_FOLDER:
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/application" or other folder inside your application or call any other .php file than index.php inside "/public".
 *
 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do. This defines the protocol part of the URL, in older
 * versions of MINI it was 'http://' for normal HTTP and 'https://' if you have a HTTPS site for sure. Now the
 * protocol-independent '//' is used, which auto-recognized the protocol.
 *
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
 *
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 *
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

/**
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */

if($_SERVER['HTTP_HOST'] == 'gator.local') {
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'sfsu_db');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8');
}
else if($_SERVER['HTTP_HOST'] == 'localhost:8888') {
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'f16g08');
    define('DB_USER', 'f16g08');
    define('DB_PASS', 'sfsuf16swe');
    define('DB_CHARSET', 'utf8');
}
else if($_SERVER['HTTP_HOST'] == 'ec2-52-57-143-240.eu-central-1.compute.amazonaws.com') {

    define('DB_TYPE', 'mysql');
    define('DB_CHARSET', 'utf8');
    define('DB_HOST', 'gatorrenter.c0iom0krlj7m.eu-central-1.rds.amazonaws.com');
    define('DB_NAME', 'gator_renter');
    define('DB_USER', 'GatorRenter');
    define('DB_PASS', 'GatorRenter');
}
else {
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'us-cdbr-iron-east-04.cleardb.net');
    define('DB_CHARSET', 'utf8');

    // HS-Fulda
//    define('DB_NAME', 'heroku_dbf30bdf31fcc3c');
//    define('DB_USER', 'bcd047b88e33db');
//    define('DB_PASS', '5bda8f98');

    // SFSU
    define('DB_NAME', 'heroku_34339c2e1bdc646');
    define('DB_USER', 'b964e6c50d049f');
    define('DB_PASS', '23250ed4');
}