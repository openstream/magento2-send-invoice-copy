<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Model\Order\Email\Sender;

use Magento\Sales\{
    Model\Order,
    Model\Order\Email\SenderBuilder
};

class InvoiceSender extends \Magento\Sales\Model\Order\Email\Sender\InvoiceSender
{
    private $sendCopyOnly = false;

    /**
     * Send order email if it is enabled in configuration.
     *
     * @param Order $order
     * @return bool
     */
    protected function checkAndSend(Order $order)
    {
        if ($this->sendCopyOnly) {
            $this->identityContainer->setStore($order->getStore());
            $this->prepareTemplate($order);

            try {
                /** @var SenderBuilder $sender */
                $sender = $this->getSender();
                $sender->sendCopyTo();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                return false;
            }

            return true;
        }

        return parent::checkAndSend($order);
    }

    /**
     * @param bool $value
     * @return void
     */
    public function setSendCopyOnly($value)
    {
        $this->sendCopyOnly = (bool) $value;
    }
}
