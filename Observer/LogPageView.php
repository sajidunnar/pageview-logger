<?php
namespace Magemontreal\PageViewLogger\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Page\Title as FrontendTitle;
use Magento\Backend\Model\View\Result\PageFactory as BackendPageFactory;

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
     * @var BackendPageFactory
     */
    protected $backendPageFactory;

    /**
     * @param LoggerInterface $logger
     * @param Http $request
     * @param FrontendTitle $frontendTitle
     * @param BackendPageFactory $backendPageFactory
     */
    public function __construct(
        LoggerInterface $logger,
        Http $request,
        FrontendTitle $frontendTitle,
        BackendPageFactory $backendPageFactory
    ) {
        $this->logger = $logger;
        $this->request = $request;
        $this->frontendTitle = $frontendTitle;
        $this->backendPageFactory = $backendPageFactory;
    }

    /**
     * Execute method to handle the event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // Get the controller action from the event
        $action = $observer->getEvent()->getControllerAction();
        // Get the page title using the custom function
        $pageTitle = $this->getPageTitle();
        // Get the current page URL
        $pageUrl = $this->request->getUriString();
        // Get the client IP address
        $clientIp = $this->request->getClientIp();

        // Format the log message
        $logMessage = sprintf('%s: %s - %s', $pageTitle, $pageUrl, $clientIp);
        // Log the message
        $this->logger->info($logMessage);
    }

    /**
     * Get the page title based on the request area (frontend or admin)
     *
     * @return string
     */
    protected function getPageTitle()
    {
        if ($this->request->getRouteName() === 'adminhtml') {
            // Create a backend page object and get the title
            $backendPage = $this->backendPageFactory->create();
            return $backendPage->getConfig()->getTitle()->get();
        } else {
            // Get the frontend page title
            return $this->frontendTitle->get();
        }
    }
}
