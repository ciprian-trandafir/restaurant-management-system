<?php

foreach (glob('../classes/' . "*.php") as $file) {
    include_once $file;
}

$url_components = parse_url(Link::get_current_url());
parse_str($url_components['query'], $params);

if (!isset($params['action'])) {
    Link::redirect('index');
    exit;
}

session_start();

$action = $params['action'];

if ($action === 'exportInventory') {
    $inventory_products = Inventory::loadInventory();

    $header = array('Product ID', 'Product Name', 'Stock', 'Measure', 'Price', 'Date Updated');
    $csv = array($header);

    foreach ($inventory_products as $inventory_product) {
        $temp = [];
        $temp[] = $inventory_product['ID'];
        $temp[] = $inventory_product['product'];
        $temp[] = $inventory_product['stock'];
        $temp[] = $inventory_product['measure'];
        $temp[] = $inventory_product['price'];
        $temp[] = $inventory_product['date_upd'];

        $csv[] = $temp;
    }

    $file_name = "export_inventory.csv";

    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=$file_name");

    $csv_file = @fopen(__DIR__.'/'.$file_name, 'w');

    foreach ($csv as $row) {
        fputcsv($csv_file, $row);
    }

    fclose($csv_file);

    readfile(__DIR__.'/'.$file_name);
    @unlink(__DIR__.'/'.$file_name);

    exit();
}

if ($action === 'exportTemplate') {
    $header = array('Product Name', 'Stock', 'Price', 'Measure Unit');
    $csv = array($header);

    $file_name = "import_csv_template.csv";

    header('Content-Type: application/force-download');
    header("Content-Disposition: attachment; filename=$file_name");

    $csv_file = @fopen(__DIR__.'/'.$file_name, 'w');

    foreach ($csv as $row) {
        fputcsv($csv_file, $row);
    }

    fclose($csv_file);

    readfile(__DIR__.'/'.$file_name);
    @unlink(__DIR__.'/'.$file_name);

    exit();
}
