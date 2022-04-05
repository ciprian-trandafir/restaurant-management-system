<?php

foreach (glob('../classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

User::check_page(2);

if (isset($_POST["import_csv_submit"])) {
    $filename = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        $header_passed = false;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if ($header_passed) {
                $product_name = $getData[0];
                $product_stock = $getData[1];
                $product_price = $getData[2];
                $product_measure_unit = $getData[3];

                if (($inventory = Inventory::getByNameAndMeasureUnit($product_name, $product_measure_unit)) !== false) {
                    Inventory::updateStock($inventory['ID'], $inventory['stock'] + $product_stock);
                    if ($product_price) {
                        Inventory::updatePrice($inventory['ID'], $product_price);
                    }
                } else {
                    Inventory::insertInventory($product_name, $product_stock, $product_price, $product_measure_unit);
                }
            }

            $header_passed = true;
        }
    }
}

Link::redirect('inventory');
exit;
