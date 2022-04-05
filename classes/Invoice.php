<?php

class Invoice
{
    public $id;
    public $id_user;
    public $total;
    public $mentions;
    public $date_add;
    public $date_paid;
    public $products;

    public function __construct($id = false)
    {
        if ($id) {
            $this->id = $id;
            $this->load_details($id);
        }
    }

    private function load_details($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `invoices` WHERE `ID` = ?");
        $stmt->execute(array($id));
        $invoice = $stmt->fetchAll();

        $this->id_user = $invoice[0]['ID_user'];
        $this->total = $invoice[0]['total'];
        $this->mentions = $invoice[0]['mentions'];
        $this->date_add = $invoice[0]['date_add'];
        $this->date_paid = $invoice[0]['date_paid'];

        $this->loadProducts();
    }

    private function loadProducts()
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `invoices_products` WHERE `id_invoice` = ?");
        $stmt->execute(array($this->id));
        $this->products = $stmt->fetchAll();
    }

    public static function checkInvoice($id_invoice)
    {
        $sql = 'SELECT * FROM `invoices` WHERE `paid` = 0 AND `ID` = ? AND `ID_user` = ?';

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute(array($id_invoice, $_SESSION['id_user']));
        return $stmt->fetchAll();
    }

    public static function addInvoiceProduct($id_invoice, $id_product, $qty)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `invoices_products`(`id_invoice`, `id_product`, `amount`) VALUES (?, ?, ?)");
        $stmt->execute(array($id_invoice, $id_product, $qty));

        Inventory::downStock($id_product, $qty);
    }

    public static function addInvoiceRecipe($id_invoice, $id_recipe, $qty, $recipe)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `invoices_products`(`id_invoice`, `id_recipe`, `amount`) VALUES (?, ?, ?)");
        $stmt->execute(array($id_invoice, $id_recipe, $qty));

        foreach ($recipe->getIngredients() as $ingredient) {
            Inventory::downStock($ingredient['id_product'], floatval($qty * $ingredient['quantity']));
        }
    }

    public static function getTodayInvoices()
    {
        $sql = 'SELECT * FROM `invoices` WHERE `paid` = 1 AND `date_paid` < ? AND `date_paid` > ?';

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute(array(date('Y-m-d').' 23:59:59', date('Y-m-d').' 00:00:00'));
        return $stmt->fetchAll();
    }

    public static function getPendingInvoices()
    {
        $sql = 'SELECT * FROM `invoices` WHERE `paid` = 0 AND `ID_user` = ?';

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute(array($_SESSION['id_user']));
        return $stmt->fetchAll();
    }

    public static function setPrice($id, $price)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `invoices` SET `total` = ? WHERE `ID` = ?");
        $stmt->execute(array($price, $id));
    }

    public static function payInvoice($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `invoices` SET `paid` = 1, `date_paid` = CURRENT_TIMESTAMP() WHERE `ID` = ?");
        $stmt->execute(array($id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'pay invoice', 'paid invoice id '.$id);
    }

    public static function createInvoice($data, $mentions)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `invoices`(`ID_user`, `mentions`, `date_add`) VALUES (?, ?, CURRENT_TIMESTAMP())");
        $stmt->execute(array($_SESSION['id_user'], $mentions));
        $id_invoice = DbUtils::getInstance(true)->lastInsertId();

        $total_price = 0;
        foreach ($data as $product) {
            if ($product['type'] == 1) {
                $total_price += ((new Inventory($product['id']))->getPrice()) * $product['qty'];
                Invoice::addInvoiceProduct($id_invoice, $product['id'], $product['qty']);
            } else {
                $recipe = new Recipe($product['id']);
                $total_price += ($recipe->getPrice()) * $product['qty'];
                Invoice::addInvoiceRecipe($id_invoice, $product['id'], $product['qty'], $recipe);
                KitchenRequest::createRequest($id_invoice, $product['id']);
            }
        }

        Invoice::setPrice($id_invoice, $total_price);

        //insert log
        Log::insertLog($_SESSION['id_user'], 'create invoice', 'created invoice id '.$id_invoice);
    }
}
