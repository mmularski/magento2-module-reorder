<?php

use Codeception\Stub\Expected;
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

/**
 * Class ProductListBlockTest
 */
class ProductListBlockTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var ProductList
     */
    protected $productListModel;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactoryMock;

    /**
     * @var JoinProcessor
     */
    protected $extensionAttributesJoinProcessorMock;

    /**
     * @var OrderCollectionFactory
     */
    protected $orderCollectionFactoryMock;

    /**
     * @var Session
     */
    protected $customerSessionMock;

    /**
     * @var Context
     */
    protected $contextMock;

    /**
     * @var PostHelper
     */
    protected $postDataHelperMock;

    /**
     * @var Resolver
     */
    protected $layerResolverMock;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepositoryMock;

    /**
     * @var Data
     */
    protected $urlHelperMock;

    /**
     * @var ProductCollection
     */
    protected $productCollectionMock;

    /**
     * @var OrderCollection
     */
    protected $orderCollectionMock;

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        require_once __DIR__ . '/framework/bootstrap.php';

        $this->productCollectionMock = $this->make(ProductCollection::class, [
            'addAttributeToSelect' => Expected::once(),
            'joinAttribute' => Expected::exactly(2),
            'addAttributeToFilter' => Expected::once(),
        ]);

        $this->orderCollectionMock = $this->make(OrderCollection::class, ['addFieldToFilter' => Expected::once([])]);
        $this->productCollectionFactoryMock = $this->make(ProductCollectionFactory::class, ['create' => Expected::once($this->productCollectionMock)]);
        $this->orderCollectionFactoryMock = $this->make(OrderCollectionFactory::class, ['create' => Expected::once($this->orderCollectionMock)]);
        $this->extensionAttributesJoinProcessorMock = $this->make(JoinProcessor::class, ['process' => Expected::once()]);
        $this->customerSessionMock = $this->make(Session::class, ['getCustomerId' => Expected::once()]);
        $this->contextMock = $this->make(Context::class, []);
        $this->postDataHelperMock = $this->make(PostHelper::class, []);
        $this->layerResolverMock = $this->makeEmpty(Resolver::class, []);
        $this->categoryRepositoryMock = $this->make(CategoryRepository::class, []);
        $this->urlHelperMock = $this->make(Data::class, []);

        $this->productListModel = new ProductList(
            $this->productCollectionFactoryMock,
            $this->extensionAttributesJoinProcessorMock,
            $this->orderCollectionFactoryMock,
            $this->customerSessionMock,
            $this->contextMock,
            $this->postDataHelperMock,
            $this->layerResolverMock,
            $this->categoryRepositoryMock,
            $this->urlHelperMock,
            []
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
    }

    /**
     * Test for _getProductCollection() method.
     */
    public function testGetProductCollection()
    {
        $this->tester->assertSame($this->productCollectionMock, $this->productListModel->_getProductCollection());
    }
}
