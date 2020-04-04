<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Model\Order\Email\Container;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Openstream\SendInvoiceCopy\Helper\Config;

class InvoiceIdentity extends \Magento\Sales\Model\Order\Email\Container\InvoiceIdentity
{
    /**
     * @var Config
     */
    private $configHelper;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Config $configHelper
    ) {
        parent::__construct($scopeConfig, $storeManager);
        $this->configHelper = $configHelper;
    }

    /**
     * @return string[]|bool
     */
    public function getEmailCopyToAdmin()
    {
        return $this->configHelper->getInvoiceAdminEmails($this->getStore()->getId());
    }

    /**
     * @return bool
     */
    public function isEmailCopyToAdminEnabled()
    {
        return $this->configHelper->isInvoiceAdminEmailEnabled($this->getStore()->getId());
    }
}
