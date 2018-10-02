<?php
/**
 * Created by PhpStorm.
 * User: Mularski
 * Date: 02.10.2018
 * Time: 16:55
 */

namespace MMularczyk\Reorder\Test\Unit\Controller\Products;

use MMularczyk\Reorder\Controller\Products\Reorder;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;

class ReorderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Reorder
     */
    private $reorderControllerModel;

    /**
     * @var Context|\PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var PageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resultPageFactoryMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultPageFactoryMock = $this->getMockBuilder(PageFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->reorderControllerModel = new Reorder(
            $this->contextMock,
            $this->resultPageFactoryMock
        );
    }

    /**
     * Test for execute() method.
     */
    public function testPagePreparationAndExecution()
    {
        $resultPageMock = $this->getMockBuilder(Page::class)->disableOriginalConstructor()->setMethods(['getConfig'])->getMock();
        $this->resultPageFactoryMock->expects($this->once())->method('create')->willReturn($resultPageMock);
        $configMock = $this->getMockBuilder(Config::class)->disableOriginalConstructor()->setMethods(['getTitle'])->getMock();
        $resultPageMock->expects($this->once())->method('getConfig')->willReturn($configMock);
        $titleMock = $this->getMockBuilder(Title::class)->disableOriginalConstructor()->setMethods(['prepend'])->getMock();
        $configMock->expects($this->once())->method('getTitle')->willReturn($titleMock);
        $titleMock->expects($this->once())->method('prepend')->with(__('Reorder Products'));

        $this->assertSame($resultPageMock, $this->reorderControllerModel->execute());
    }
}
