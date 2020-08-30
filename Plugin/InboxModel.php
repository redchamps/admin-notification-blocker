<?php
namespace RedChamps\AdminNotificationBlocker\Plugin;

use Magento\AdminNotification\Model\Inbox;
use Magento\Framework\App\Config\ScopeConfigInterface;

class InboxModel
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    protected $_blockedSeverities = false;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function beforeParse(Inbox $subject, array $data)
    {
        $blockedSeverities = $this->getBlockedSeverities();
        foreach ($data as $index => $item) {
            if (isset($item['severity']) && in_array($item['severity'], $blockedSeverities)) {
                unset($data[$index]);
            }
        }
        return [$data];
    }

    protected function getBlockedSeverities()
    {
        if ($this->_blockedSeverities === false) {
            $blockedSeverities = $this->scopeConfig->getValue(
                "admin_notification_blocker/settings/blocked_severities"
            );
            if($blockedSeverities) {
                $this->_blockedSeverities = explode(",", $blockedSeverities);
            } else {
                $this->_blockedSeverities = [];
            }
        }

        return  $this->_blockedSeverities;
    }
}
