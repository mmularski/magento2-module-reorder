<?php
/**
 * Created by PhpStorm.
 * User: Mularski
 * Date: 02.07.2018
 * Time: 17:00
 */

namespace MMularczyk\Reorder\Block\Account\Reorder;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\ResourceModel\AbstractCollection;
use Magento\Customer\Model\Session;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

/**
 * Class ProductList
 * @package MMularczyk\Reorder\Block\Account\Reorder
 */
class ProductList extends ListProduct
{
    /**
     * @var OrderCollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * ProductList constructor.
     * @param ProductCollectionFactory $productCollectionFactory
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param Session $customerSession
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Data $urlHelper
     * @param array $data
     */
    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        OrderCollectionFactory $orderCollectionFactory,
        Session $customerSession,
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        array $data = []
    )
    {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->customerSession = $customerSession;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    /**
     * {@inheritdoc}
     *
     * @return AbstractCollection
     */
    protected function _getProductCollection()
    {
        if ($this->_productCollection === null) {
            $orders = $this->orderCollectionFactory->create()->addFieldToFilter('customer_id', ['eq' => $this->customerSession->getCustomerId()]);
            $productsIds = [];

            foreach ($orders as $order) {
                foreach ($order->getAllVisibleItems() as $item) {
                    $productsIds[] = $item->getProductId();
                }
            }

            /** @var ProductCollection $collection */
            $collection = $this->productCollectionFactory->create();
            $this->extensionAttributesJoinProcessor->process($collection);

            $collection->addAttributeToSelect('*');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
            $collection->addAttributeToFilter('entity_id', ['in' => $productsIds]);

            $this->_productCollection = $collection;
        }

        return $this->_productCollection;
    }
}
