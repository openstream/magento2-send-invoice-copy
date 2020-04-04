<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Controller\Adminhtml\Invoice;

use Magento\Backend\{
    App\Action\Context,
    Model\View\Result\ForwardFactory
};
use Magento\Sales\{
    Api\InvoiceRepositoryInterface,
    Controller\Adminhtml\Invoice\AbstractInvoice\Email
};
use Magento\Framework\Exception\LocalizedException;
use Openstream\SendInvoiceCopy\Model\Order\Email\Sender\InvoiceSender;

class EmailCopy extends Email
{
    /**
     * @var InvoiceRepositoryInterface
     */
    private $invoiceRepository;
    /**
     * @var InvoiceSender
     */
    private $sender;

    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceSender $sender
    ) {
        parent::__construct($context, $resultForwardFactory);
        $this->invoiceRepository = $invoiceRepository;
        $this->sender = $sender;
    }

    public function execute()
    {
        $invoiceId = $this->getRequest()->getParam('invoice_id');
        if (!$invoiceId) {
            return $this->resultForwardFactory->create()->forward('noroute');
        }
        $invoice = $this->invoiceRepository->get($invoiceId);
        if (!$invoice) {
            return $this->resultForwardFactory->create()->forward('noroute');
        }

        try {
            $this->sender->setSendCopyOnly(true);
            $this->sender->send($invoice);
            $this->messageManager->addSuccessMessage(__('You sent the message.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__('There has been an error: %1', $e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath(
            'sales/invoice/view',
            ['order_id' => $invoice->getOrder()->getId(), 'invoice_id' => $invoiceId]
        );
    }
}
