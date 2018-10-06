<?php
/**
 * Created by PhpStorm.
 * User: Mularski
 * Date: 06.10.2018
 * Time: 12:41
 */

define('TESTS_INSTALL_CONFIG_FILE', 'etc/install-config-mysql.php');
define('TESTS_GLOBAL_CONFIG_FILE', 'etc/config-global.php');
define('TESTS_GLOBAL_CONFIG_DIR', '../../../app/etc');
define('TESTS_CLEANUP', 'enabled');
define('TESTS_MEM_LEAK_LIMIT', '');
define('TESTS_EXTRA_VERBOSE_LOG', '1');
define('TESTS_MAGENTO_MODE', 'developer');
define('TESTS_ERROR_LOG_LISTENER_LEVEL', '-1');

require_once __DIR__ . '/../../../../../../../dev/tests/integration/framework/bootstrap.php';