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
    protected $logger;
    protected $request;
    protected $frontendTitle;
    protected $backendPage;

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

    public function execute(Observer $observer)
    {
        $action = $observer->getEvent()->getControllerAction();
        $pageTitle = $this->getPageTitle();
        $pageUrl = $this->request->getUriString();
        $clientIp = $this->request->getClientIp();

        $logMessage = sprintf('%s: %s - %s', $pageTitle, $pageUrl, $clientIp);
        $this->logger->info($logMessage);
    }

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
