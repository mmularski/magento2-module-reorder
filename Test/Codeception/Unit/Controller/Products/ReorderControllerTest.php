<?php

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use MMularczyk\Reorder\Controller\Products\Reorder;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Codeception\Stub\Expected;

/**
 * Class ReorderControllerTest
 */
class ReorderControllerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Reorder
     */
    private $reorderControllerModel;

    /**
     * @var Context
     */
    private $contextMock;

    /**
     * @var PageFactory
     */
    private $resultPageFactoryMock;

    /**
     * @var \Codeception\Stub
     */
    private $titlePageMock;

    /**
     * @var \Codeception\Stub
     */
    private $configPageMock;

    /**
     * @var \Codeception\Stub
     */
    private $resultPageMock;

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        require_once __DIR__ . '/framework/bootstrap.php';

        $this->contextMock = $this->make(Context::class, []);
        $this->titlePageMock = $this->make(Title::class, ['prepend' => Expected::once()]);
        $this->configPageMock = $this->make(Config::class, ['getTitle' => Expected::once($this->titlePageMock)]);
        $this->resultPageMock = $this->make(Page::class, ['getConfig' => Expected::once($this->configPageMock)]);
        $this->resultPageFactoryMock = $this->make(PageFactory::class, ['create' => Expected::once($this->resultPageMock)]);

        $this->reorderControllerModel = new Reorder(
            $this->contextMock,
            $this->resultPageFactoryMock
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
    }

    /**
     * Test for execute() method.
     */
    public function testPagePreparationAndExecution()
    {
        //die(print_r(get_class_methods($this->resultPageMock)));
        $this->tester->assertSame($this->resultPageMock, $this->reorderControllerModel->execute());
    }
}
