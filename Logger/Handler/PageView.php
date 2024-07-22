<?php
namespace Magemontreal\PageViewLogger\Logger\Handler;

use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;

class PageView extends Base
{
    protected $loggerType = Logger::INFO;
    protected $fileName = '/var/log/page-view.log';
}
