<?php
/**
 * @author      Oleh Kravets <oleh@openstream.ch>
 * @copyright   Copyright (c) 2020 Openstream Internet Solutions  (https://www.openstream.ch)
 * @license     MIT License
 */

namespace Openstream\SendInvoiceCopy\Model\Order\Email;

use Magento\Framework\{
    Exception\LocalizedException,
    Exception\MailException
};

class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder
{
    /**
     * @inheritDoc
     */
    public function send()
    {
        parent::send();

        if ($this->identityContainer->isEmailCopyToAdminEnabled()) {
            $this->sendCopyToAdmin();
        }
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws MailException
     */
    public function sendCopyToAdmin()
    {
        $copyTo = $this->identityContainer->getEmailCopyToAdmin();

        if (!empty($copyTo)) {
            foreach ($copyTo as $email) {
                $this->configureEmailTemplate();
                $this->transportBuilder->addTo($email);
                $transport = $this->transportBuilder->getTransport();
                $transport->sendMessage();
            }
        }
    }
}
