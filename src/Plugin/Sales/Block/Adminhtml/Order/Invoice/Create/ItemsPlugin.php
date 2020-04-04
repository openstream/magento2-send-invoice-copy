<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Plugin\Sales\Block\Adminhtml\Order\Invoice\Create;

use Magento\Framework\View\Element\TemplateFactory;
use Magento\Sales\Block\Adminhtml\Order\Invoice\Create\Items;
use Openstream\SendInvoiceCopy\Helper\Config;

class ItemsPlugin
{
    const CHECKBOX_TEMPLATE = 'Openstream_SendInvoiceCopy::order/invoice/create/items/admin-email-checkbox.phtml';
    /**
     * @var TemplateFactory
     */
    private $templateFactory;
    /**
     * @var Config
     */
    private $config;

    public function __construct(TemplateFactory $templateFactory, Config $config)
    {
        $this->templateFactory = $templateFactory;
        $this->config = $config;
    }

    /**
     * @param Items $subject
     * @param string $result
     * @return string
     */
    public function afterFetchView(Items $subject, $result): string
    {
        $storeId = $subject->getInvoice()->getStoreId();
        if (!$this->config->isInvoiceCopyEnabled($storeId)) {
            return $result;
        }

        /** @var \Magento\Framework\View\Element\Template $checkboxBlock */
        $checkboxBlock = $this->templateFactory->create();
        $checkboxBlock->setTemplate(self::CHECKBOX_TEMPLATE);

        $regex = '/<input id="send_email"((?!<\/div>)[\s\S])*<\/div>/';
        if (preg_match($regex, $result, $matches)) {
            $emailCheckboxHtml = $matches[0];
            $result = str_replace($emailCheckboxHtml, $emailCheckboxHtml . $checkboxBlock->toHtml(), $result);
        }

        return $result;
    }
}
