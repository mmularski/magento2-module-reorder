<?php

use Magento\TestFramework\Helper\Bootstrap;
use Magento\Customer\Model\Session;

define('TESTS_INSTALL_CONFIG_FILE', 'etc/install-config-mysql.php');
define('TESTS_GLOBAL_CONFIG_FILE', 'etc/config-global.php');
define('TESTS_GLOBAL_CONFIG_DIR', '../../../app/etc');
define('TESTS_CLEANUP', 'enabled');
define('TESTS_MEM_LEAK_LIMIT', '');
define('TESTS_EXTRA_VERBOSE_LOG', '1');
define('TESTS_MAGENTO_MODE', 'developer');
define('TESTS_ERROR_LOG_LISTENER_LEVEL', '-1');

require_once __DIR__ . '/../../../../../../../../../dev/tests/integration/framework/bootstrap.php';
require_once __DIR__ . '/../../../../../../../../../dev/tests/integration/testsuite/MMularczyk/Reorder/_files/controller_customer.php';
require_once __DIR__ . '/../../../../../../../../../dev/tests/integration/testsuite/MMularczyk/Reorder/_files/controller_customer_address.php';

$I = new IntegrationTester($scenario);

/** @var Session $session */
$session = Bootstrap::getObjectManager()
    ->get(Session::class);
$session->loginById(1);

$I->amOnPage('/sales/products/reorder');
$I->assertContains('Reorder Products', $I->grabPageSource());