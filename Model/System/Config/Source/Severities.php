<?php
namespace RedChamps\AdminNotificationBlocker\Model\System\Config\Source;

use Magento\AdminNotification\Model\Inbox;
use Magento\Framework\Data\OptionSourceInterface;

class Severities implements OptionSourceInterface
{
    /**
     * @var Inbox
     */
    private $inbox;

    protected $_options = [];

    public function __construct(Inbox $inbox)
    {

        $this->inbox = $inbox;
    }

    public function toOptionArray()
    {
        if(!$this->_options) {
            $severities =$this->inbox->getSeverities();

            foreach ($severities as $index => $severity) {
                $this->_options[] = [
                    "value" => $index,
                    "label" => ucfirst($severity)
                ];
            }
        }
        return $this->_options;
    }
}
