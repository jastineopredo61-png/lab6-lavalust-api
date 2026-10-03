<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * LavaLust - DATABASE CONNECTIVITY SETTINGS
 *
 * All credentials come from environment variables (.env locally,
 * Render Environment Variables when deployed).
 * NEVER type a real password in this file - it goes to GitHub.
 */

$database['main'] = array(
    'driver'	=> getenv('DB_DRIVER') ?: 'mysql',
    'hostname'	=> getenv('DB_HOST') ?: '',
    'port'		=> getenv('DB_PORT') ?: '3306',
    'username'	=> getenv('DB_USER') ?: '',
    'password'	=> getenv('DB_PASSWORD') ?: '',
    'database'	=> getenv('DB_NAME') ?: '',
    'charset'	=> getenv('DB_CHARSET') ?: 'utf8mb4',
    'dbprefix'	=> getenv('DB_PREFIX') ?: '',
    // Optional for SQLite
    'path'      => ''
);

?>
