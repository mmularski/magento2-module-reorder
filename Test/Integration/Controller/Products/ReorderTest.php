<?php
/**
 * Created by PhpStorm.
 * User: Mularski
 * Date: 05.10.2018
 * Time: 13:08
 */

namespace MMularczyk\Reorder\Test\Integration\Controller\Products;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\Customer\Model\Session;

/**
 * Class ReorderTest
 * @package MMularczyk\Reorder\Test\Integration\Controller\Products
 */
class ReorderTest extends \Magento\TestFramework\TestCase\AbstractController
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
        $session = Bootstrap::getObjectManager()
            ->get(Session::class);
        $session->loginById($customerId);
    }

    /**
     * Test redirect if not logged in
     *
     * @magentoDataFixture Magento/Customer/_files/customer.php
     * @magentoDataFixture Magento/Customer/_files/customer_address.php
     */
    public function testIndexAction()
    {
        $this->login(1);
        $this->dispatch('sales/products/reorder');

        $body = $this->getResponse()->getBody();
        $this->assertContains('Reorder Products', $body);
    }
}