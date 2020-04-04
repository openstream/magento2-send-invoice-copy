<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const CONFIG_PATH_INVOICE_EMAIL_ENABLE = 'sales_email/invoice/enable_email_to_admin';
    const CONFIG_PATH_INVOICE_EMAIL = 'sales_email/invoice/admin_email';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    public function isInvoiceAdminEmailEnabled($storeId = null)
    {
        return (bool) $this->getConfigValue(self::CONFIG_PATH_INVOICE_EMAIL_ENABLE, $storeId);
    }

    /**
     * @param int|null $storeId
     * @return string[]
     */
    public function getInvoiceAdminEmails($storeId = null)
    {
        return array_filter(
            array_map('trim', explode(',', $this->getConfigValue(self::CONFIG_PATH_INVOICE_EMAIL, $storeId)))
        );
    }

    /**
     * @param string $path
     * @param int|null $storeId
     * @return mixed
     */
    private function getConfigValue($path, $storeId)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORES, $storeId);
    }
}
