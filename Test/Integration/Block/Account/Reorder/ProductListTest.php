<?php
/**
 * Created by PhpStorm.
 * User: Mularski
 * Date: 05.10.2018
 * Time: 12:13
 */

namespace MMularczyk\Reorder\Test\Codeception\Integration\Block\Account\Reorder;

use MMularczyk\Reorder\Block\Account\Reorder\ProductList;
use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Customer\Model\Session;

/**
 * Class ProductListTest
 * @package MMularczyk\Reorder\Test\Codeception\Integration\Block\Account\Reorder
 */
class ProductListTest extends TestCase
{
    /**
     * Login the user
     *
     * @param string $customerId Customer to mark as logged in for the session
     * @return void
     */
    protected function login($customerId)
    {
        /** @var Session $session */
        $session = Bootstrap::getObjectManager()->get(Session::class);

        $session->loginById($customerId);
    }

    /**
     * Test getProductCollection with customer who placed order/orders
     *
     * @magentoDataFixture MMularczyk/Reorder/_files/order_with_customer.php
     */
    public function testGetProductCollection()
    {
        /** @var ProductList $productListModel */
        $productListModel = Bootstrap::getObjectManager()->get(ProductList::class);
        Bootstrap::getObjectManager()->get(Session::class)->setCustomerId(1);

        $this->assertGreaterThan(0, $productListModel->_getProductCollection()->count());
    }
}
