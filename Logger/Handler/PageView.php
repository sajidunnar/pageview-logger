<?php
namespace Magemontreal\PageViewLogger\Logger\Handler;

use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;

class PageView extends Base
{
    /**
     * @var Logger
     */
    protected $loggerType = Logger::INFO;
    //custom file path
    protected $fileName = '/var/log/page-view.log';

}
