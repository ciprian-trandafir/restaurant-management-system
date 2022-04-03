<div class="custom_card stockCard">
    <div class="icon-container stockIcon">
        <img class="icon" src="assets/out-of-stock.png">
    </div>
    <div class="content">
        <h4 class="text">Products that ran out of stock</h4>
        <p class="number"><?php echo count(Inventory::loadInventory(false, 0 , 0)); ?></p>
        <div class="divider"></div>
        <span class="note">Lorem Ipsum dolores</span>
    </div>
</div>
<div class="custom_card invoiceCard">
    <div class="icon-container billIcon">
        <img class="icon" src="assets/bill.png">
    </div>
    <div class="content">
        <h4 class="text">Invoices completed today</h4>
        <p class="number"><?php echo count(Invoice::getTodayInvoices()); ?></p>
        <div class="divider"></div>
        <span class="note">Lorem Ipsum dolores</span>
    </div>
</div>
<button class="button home_refresh">Refresh</button>
