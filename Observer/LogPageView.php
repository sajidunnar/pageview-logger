<?php
namespace Magemontreal\PageViewLogger\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Page\Title as FrontendTitle;
use Magento\Backend\Model\View\Result\Page as BackendPage;

class LogPageView implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var Http
     */
    protected $request;
    /**
     * @var FrontendTitle
     */
    protected $frontendTitle;
    /**
     * @var BackendPage
     */
    protected $backendPage;

    /**
     * @param LoggerInterface $logger
     * @param Http $request
     * @param FrontendTitle $frontendTitle
     * @param BackendPage $backendPage
     */
    public function __construct(
        LoggerInterface $logger,
        Http $request,
        FrontendTitle $frontendTitle,
        BackendPage $backendPage
    ) {
        $this->logger = $logger;
        $this->request = $request;
        $this->frontendTitle = $frontendTitle;
        $this->backendPage = $backendPage;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /**
         *  get Event from observer and controller action
         */
        $action = $observer->getEvent()->getControllerAction();
        // wrote custom function to get the page title
        $pageTitle = $this->getPageTitle();
        $pageUrl = $this->request->getUriString();
        $clientIp = $this->request->getClientIp();

        $logMessage = sprintf('%s: %s - %s', $pageTitle, $pageUrl, $clientIp);
        $this->logger->info($logMessage);
    }

    /**
     * @return mixed
     */
    protected function getPageTitle()
    {
        if ($this->request->getRouteName() === 'adminhtml') {
            $pageTitle = $this->backendPage->getConfig()->getTitle()->get();
        } else {
            $pageTitle = $this->frontendTitle->get();
        }
        return $pageTitle;
    }
}
