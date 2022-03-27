<?php

foreach (glob('classes/' . "*.php") as $file)
{
    include_once $file;
}

User::check_page();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <?php include './head.php'; ?>
</head>
<body>
<?php include './header.php'; ?>
    <div class="page">
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
                <h4 class="text">Invoices completed</h4>
                <p class="number">1</p>
                <div class="divider"></div>
                <span class="note">Lorem Ipsum dolores</span>
            </div>
        </div>
        <button class="button">Refresh</button>
        <!-- <img src="https://media.discordapp.net/attachments/513481872106455042/953251597184548964/HTML520dashboard20demo20of20Smart20Theme.png"> -->
    </div>
</body>
<?php include './footer.php'; ?>
</html>
