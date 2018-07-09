<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MMularczyk\Reorder\Block\Account;

use \Magento\Framework\App\ObjectManager;
use \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;

/**
 * Class Reorder
 * @package MMularczyk\Reorder\Block\Account
 */
class Reorder extends \Magento\Catalog\Block\Category\View
{
    /**
     * @return string
     */
    public function getProductListHtml()
    {
        return $this->getChildHtml('product_list');
    }
}
