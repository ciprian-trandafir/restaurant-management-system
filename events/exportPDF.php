<?php

include_once '../fpdf.php';
foreach (glob('../classes/' . "*.php") as $file) {
    if (strpos($file, 'index') === false) {
        include_once $file;
    }
}

$url_components = parse_url(Link::get_current_url());
parse_str($url_components['query'], $params);

if (!isset($params['id_invoice'])) {
    Link::redirect('index');
    exit;
}

User::check_page(1);

if (Invoice::checkInvoice($params['id_invoice'])) {
    Invoice::payInvoice($params['id_invoice']);

    $file_name = 'invoice_'.$params['id_invoice'].'.pdf';
    $invoice = new Invoice($params['id_invoice']);

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    //header
    $pdf->Cell(40, 10, "Invoice no #".$params['id_invoice']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Mentions: ".$invoice->mentions);
    $pdf->Ln();
    $pdf->Ln();

    //products_table
    // Colors, line width and bold font
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(128,0,0);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('','B');

    $w = array(60, 40, 40, 40);
    $header = array('Product', 'Price', 'Amount', 'Total');
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
    }

    $pdf->Ln();
    // Color and font restoration
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    $fill = false;

    $total = 0;
    foreach ($invoice->products as $product) {
        $product_name = '';
        $product_price = 0;
        if ($product['id_product']) {
            $product_obj = new Inventory($product['id_product']);
            $product_name = $product_obj->getProduct();
            $product_price = $product_obj->getPrice();
        } else {
            $recipe_obj = new Recipe($product['id_recipe']);
            $product_name = $recipe_obj->getName();
            $product_price = $recipe_obj->getPrice();
        }

        $pdf->Cell($w[0], 6, $product_name, 'LR', 0, 'L', $fill);
        $pdf->Cell($w[1], 6, $product_price, 'LR', 0, 'L', $fill);
        $pdf->Cell($w[2], 6, $product['amount'], 'LR', 0, 'R', $fill);
        $pdf->Cell($w[3], 6, $product['amount'] * $product_price, 'LR', 0, 'R', $fill);
        $pdf->Ln();
        $fill = !$fill;
        $total += $product['amount'] * $product_price;
    }
    // Closing line
    $pdf->Cell(array_sum($w), 0, '', 'T');
    $pdf->Ln();

    //total
    $pdf->Cell(40, 10, "Total: ".$total);

    //author
    $pdf->Ln();
    $pdf->Ln();
    $user = User::getDetails($_SESSION['id_user']);
    $pdf->Cell(40, 10, "by ".$user['first_name'].' '.$user['last_name']);

    //date
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(40, 10, "Date placed ".$invoice->date_add);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Date paid ".$invoice->date_paid);

    //save & open file
    $filepath = '../pdf/'.$file_name;
    $pdf->Output($filepath, 'F');
    $pdf->Output();
} else {
    Link::redirect('pending_invoices');
    exit;
}
