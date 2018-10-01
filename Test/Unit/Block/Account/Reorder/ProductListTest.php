<?php
/**
 * Created by PhpStorm.
 * User: Mularski
 * Date: 01.10.2018
 * Time: 18:23
 */

namespace MMularczyk\Reorder\Test\Unit\Block\Account\Reorder;

use MMularczyk\Reorder\Block\Account\Reorder\ProductList;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Customer\Model\Session;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessor;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Collection as OrderCollection;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

class ProductListTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ProductList
     */
    private $productListModel;

    /**
     * @var ProductCollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $productCollectionFactoryMock;

    /**
     * @var ProductCollection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $productCollectionMock;

    /**
     * @var JoinProcessor|\PHPUnit_Framework_MockObject_MockObject
     */
    private $joinProcessorMock;

    /**
     * @var OrderCollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $orderCollectionFactoryMock;

    /**
     * @var OrderCollection|\PHPUnit_Framework_MockObject_MockObject
     */
    private $orderCollectionMock;

    /**
     * @var Session|\PHPUnit_Framework_MockObject_MockObject
     */
    private $customerSessionMock;

    /**
     * @var Context|\PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var PostHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $postHelperMock;

    /**
     * @var Resolver|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resolverMock;

    /**
     * @var CategoryRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $categoryRepositoryMock;

    /**
     * @var Data|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dataMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->productCollectionFactoryMock = $this->getMockBuilder(ProductCollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productCollectionMock = $this->getMockBuilder(ProductCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addAttributeToSelect', 'joinAttribute', 'addAttributeToFilter'])
            ->getMock();

        $this->productCollectionFactoryMock->method('create')->willReturn($this->productCollectionMock);

        $this->joinProcessorMock = $this->getMockBuilder(JoinProcessor::class)
            ->disableOriginalConstructor()
            ->setMethods(['process'])
            ->getMock();

        $this->orderCollectionFactoryMock = $this->getMockBuilder(OrderCollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->orderCollectionMock = $this->getMockBuilder(OrderCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addFieldToFilter'])
            ->getMock();

        $this->orderCollectionFactoryMock->method('create')->willReturn($this->orderCollectionMock);

        $this->customerSessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCustomerId'])
            ->getMock();

        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->postHelperMock = $this->getMockBuilder(PostHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resolverMock = $this->getMockBuilder(Resolver::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryRepositoryMock = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->dataMock = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListModel = new ProductList(
            $this->productCollectionFactoryMock,
            $this->joinProcessorMock,
            $this->orderCollectionFactoryMock,
            $this->customerSessionMock,
            $this->contextMock,
            $this->postHelperMock,
            $this->resolverMock,
            $this->categoryRepositoryMock,
            $this->dataMock
        );
    }

    /**
     * Test for _getProductCollection method.
     */
    public function testGetProductCollection()
    {
        $this->orderCollectionFactoryMock->expects($this->once())->method('create');
        $this->orderCollectionMock->expects($this->once())->method('addFieldToFilter')->willReturn([]);
        $this->customerSessionMock->expects($this->once())->method('getCustomerId');
        $this->productCollectionFactoryMock->expects($this->once())->method('create');
        $this->joinProcessorMock->expects($this->once())->method('process')->with($this->productCollectionMock);

        $this->productCollectionMock->expects($this->once())->method('addAttributeToSelect');
        $this->productCollectionMock->expects($this->exactly(2))->method('joinAttribute');
        $this->productCollectionMock->expects($this->once())->method('addAttributeToFilter');

        $this->assertSame($this->productCollectionMock, $this->productListModel->_getProductCollection());
    }
}
