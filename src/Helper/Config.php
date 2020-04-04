<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Model\Order\Email\Container\InvoiceIdentity;
use Magento\Store\Model\ScopeInterface;

class Config
{
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
    public function isInvoiceCopyEnabled($storeId = null)
    {
        $copyTo = $this->scopeConfig->getValue(
            InvoiceIdentity::XML_PATH_EMAIL_COPY_TO,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
        return !empty(array_filter(array_map('trim', explode(',', $copyTo))));
    }
}
