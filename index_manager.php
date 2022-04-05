<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<div class="manager_index">
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
    <div class="manager_footer">
        <button class="button home_refresh">Refresh</button>
        <button class="button home_sales">View Today Sales</button>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="home_sales">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Today Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="chartSales" style="width:100%; max-width:600px"></canvas>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
