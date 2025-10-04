<?php
/**
 * Installation Status File
 * This file indicates that the system has been successfully installed
 */

// Installation status
define('INSTALLED', true);
define('INSTALL_DATE', date('Y-m-d H:i:s'));
define('INSTALL_VERSION', '1.0.0');

// Prevent re-installation
if (basename($_SERVER['PHP_SELF']) === 'install.php') {
    die('System is already installed. To reinstall, please delete this file.');
}