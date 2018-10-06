<?php

use Magento\TestFramework\Helper\Bootstrap;
use Magento\Customer\Model\Session;

require_once __DIR__ . '/../../magento_bootstrap.php';
require_once __DIR__ . '/../../../../../../../../../dev/tests/integration/testsuite/MMularczyk/Reorder/_files/controller_customer.php';
require_once __DIR__ . '/../../../../../../../../../dev/tests/integration/testsuite/MMularczyk/Reorder/_files/controller_customer_address.php';

$I = new IntegrationTester($scenario);

/** @var Session $session */
$session = Bootstrap::getObjectManager()
    ->get(Session::class);
$session->loginById(1);

$I->amOnPage('/sales/products/reorder');
$I->assertContains('Reorder Products', $I->grabPageSource());