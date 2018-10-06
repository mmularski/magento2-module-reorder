<?php

use Magento\TestFramework\Helper\Bootstrap;
use Magento\Customer\Model\Session;
use MMularczyk\Reorder\Block\Account\Reorder\ProductList;

require_once __DIR__ . '/../../../magento_bootstrap.php';
require_once __DIR__ . '/../../../../../../../../../../dev/tests/integration/testsuite/MMularczyk/Reorder/_files/order_with_customer.php';

$I = new IntegrationTester($scenario);

/** @var ProductList $productListModel */
$productListModel = Bootstrap::getObjectManager()->get(ProductList::class);
Bootstrap::getObjectManager()->get(Session::class)->setCustomerId(1);

$I->assertGreaterThan(0, $productListModel->_getProductCollection()->count());