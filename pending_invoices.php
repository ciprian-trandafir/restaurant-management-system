<?php

foreach (glob('classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(1);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Invoices • Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/pending_invoices.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
<div class="page">
    <div class="go-loader-wrapper">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
    <div class="pending_invoices_wrapper">
        <div class="pending_invoices">
            <div class="row">
                <?php
                $invoices = Invoice::getPendingInvoices();
                if (!count($invoices)) {
                    echo '<div class="no-results">
                            <span>There are no pending invoices</span>
                        </div>';
                }
                foreach ($invoices as $invoice) {
                    $href = Link::getLink('exportPDF', 'events', ['id_invoice' => $invoice['ID']]);
                    echo '<div class="invoice">
                        <div class="invoice_inner">
                            <div class="invoice_header">
                                <div class="invoice_image">
                                    <img src="./assets/invoice.png" alt="" class="invoice_img">
                                </div>
                                <span class="invoice_placed">'.$invoice['date_add'].'</span>
                                <span class="invoice_id">'.$invoice['ID'].'</span>
                            </div>
                            <div class="invoice_body">
                                <div class="invoice_name">
                                    <span>'.$invoice['mentions'].'</span>
                                </div>
                                <div class="invoice_price">
                                    <span>'.$invoice['total'].' RON</span>
                                </div>
                            </div>
                            <div class="invoice_footer">
                                <a href="'.$href.'" target="_blank" rel="noreferrer noopener nofollow" class="btn buttonPayInvoice">Finish</a>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
<?php include './footer.php'; ?>
<script src="./js/pending_invoices.js"></script>
</html>
