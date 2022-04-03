<div class="waiter_index">
    <a class="custom_card createInvoiceCard" href="<?php echo Link::getLink('create_invoice')?>">
        <div class="icon-container">
            <img class="icon" src="assets/invoice.png">
        </div>
        <div class="content">
            <h4 class="text">Create an invoice</h4>
            <div class="divider"></div>
            <span class="note">Lorem Ipsum dolores</span>
        </div>
    </a>
    <a class="custom_card pendingInvoicesCard" href="<?php echo Link::getLink('pending_invoices')?>">
        <div class="icon-container">
            <img class="icon" src="assets/pending-invoice.png">
        </div>
        <div class="content">
            <h4 class="text">Pending invoices</h4>
            <p class="number"><?php echo count(Invoice::getPendingInvoices()); ?></p>
            <div class="divider"></div>
            <span class="note">Lorem Ipsum dolores</span>
        </div>
    </a>
    <a class="custom_card kitchenRequestsCard" href="<?php echo Link::getLink('kitchen_requests')?>">
        <div class="icon-container">
            <img class="icon" src="assets/kitchen.png">
        </div>
        <div class="content">
            <h4 class="text">Kitchen requests</h4>
            <p class="details"><?php echo count(KitchenRequest::getPendingRequests()); ?> pending | <?php echo count(KitchenRequest::getPendingRequests(true)); ?> finished</p>
            <div class="divider"></div>
            <span class="note">Lorem Ipsum dolores</span>
        </div>
    </a>
</div>
