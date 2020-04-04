## Openstream Invoice Email Copy

#### Extension for Magento 2

### Overview

The module provides the possibility to send an invoice email copy without sending it to the customer.

------

### Details

The module does not change the default Magento behaviour but offers two additional elements:
 - a checkbox when creating an invoice `Email Copy Only (Do not sent to customer)`
 - a button on the invoice view page `Send Email Copy`
 
 Both options send emails to the addresses specified under `Stores->Configuration->Sales:Sales Emails->Invoices->Send Invoice Email Copy To`, regardless of which method has been selected, Bcc or separate email.
 
 *Please **note***, that the standard Magento Copy To functions exactly as before, which means even if "Email Copy Only" is not chosen, a copy is sent both to the customer and to the specified emails.
 
 ### Requirements and Setup
 
 The module has been tested with Magento 2.3.2 and 2.3.4.
 
 ### Authors
 
 Oleh Kravets oleh@openstream.ch
 
 ### License
 
 MIT
 
 