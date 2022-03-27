<?php

class Inventory
{
    private $id;
    private $product;
    private $stock;
    private $measure;
    private $price;
    private $date_upd;

    public function __construct($id = false)
    {
        if ($id) {
            $this->id = $id;
            $this->load_inventory($id);
        }
    }

    private function load_inventory($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `inventory` WHERE `ID` = ?");
        $stmt->execute(array($id));
        $inventory = $stmt->fetch();

        $this->product = $inventory['product'];
        $this->stock = $inventory['stock'];
        $this->measure = $inventory['measure'];
        $this->price = $inventory['price'];
        $this->date_upd = $inventory['date_upd'];
    }

    public static function updateStock($id, $stock)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `inventory` SET `stock` = ? WHERE `ID` = ?");
        $stmt->execute(array($stock, $id));
    }

    public static function updatePrice($id, $price)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `inventory` SET `price` = ? WHERE `ID` = ?");
        $stmt->execute(array($price, $id));
    }

    public static function loadInventory($name = false, $stock_from = false, $stock_to = false)
    {
        $sql = 'SELECT * FROM `inventory`';
        if ($stock_from && $stock_to) {
            $sql .= " WHERE `stock` > $stock_from AND `stock` < $stock_to";
        } else if ($stock_from) {
            $sql .= " WHERE `stock` > $stock_from";
        } else if ($stock_to) {
            $sql .= " WHERE `stock` < $stock_to";
        }

        if ($name) {
            if (strpos($sql, 'WHERE') === false) {
                $sql .= ' WHERE';
            }

            if (strpos($sql, 'stock') !== false) {
                $sql .= ' AND ';
            }

            $sql .= " `product` LIKE '%".$name."%'";
        }

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return mixed
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getDateUpd()
    {
        return $this->date_upd;
    }
}
