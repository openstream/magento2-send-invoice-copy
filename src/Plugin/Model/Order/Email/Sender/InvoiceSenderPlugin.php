<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Plugin\Model\Order\Email\Sender;

use Magento\Framework\App\RequestInterface;
use Openstream\SendInvoiceCopy\Model\Order\Email\Sender\InvoiceSender;

class InvoiceSenderPlugin
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function beforeSend(InvoiceSender $subject, ...$params)
    {
        $invoiceData = $this->request->getParam('invoice');
        if (!empty($invoiceData['send_email_copy_only']) && empty($invoiceData['send_email'])) {
            $subject->setSendCopyOnly(true);
        }

        return $params;
    }
}
