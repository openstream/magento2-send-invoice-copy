<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Plugin\Sales\Block\Adminhtml\Order\Invoice;

use Magento\Framework\View\LayoutInterface;
use Magento\Sales\Block\Adminhtml\Order\Invoice\View;
use Openstream\SendInvoiceCopy\Helper\Config;

class ViewPlugin
{

    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param View $view
     * @param LayoutInterface $layout
     * @return array
     */
    public function beforeSetLayout(View $view, LayoutInterface $layout)
    {
        $storeId = $view->getInvoice()->getStoreId();
        if ($this->config->isInvoiceCopyEnabled($storeId)) {
            $message = __('Are you sure you want to do send an invoice email copy?');
            $url = $view->getUrl('sendinvoicecopy/invoice/emailCopy', ['invoice_id' => $view->getInvoice()->getId()]);

            $view->addButton(
                'send_email_admin',
                [
                    'label'   => __('Send Email Copy'),
                    'class'   => 'send',
                    'onclick' => "confirmSetLocation('{$message}', '{$url}')"
                ]
            );
        }

        return [$layout];
    }
}
