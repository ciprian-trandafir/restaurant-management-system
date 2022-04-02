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
        $inventory = $stmt->fetchAll();

        $this->product = $inventory[0]['product'];
        $this->stock = $inventory[0]['stock'];
        $this->measure = $inventory[0]['measure'];
        $this->price = $inventory[0]['price'];
        $this->date_upd = $inventory[0]['date_upd'];
    }

    public static function getByNameAndMeasureUnit($product_name, $measure_unit)
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `inventory` WHERE `product` = ? AND `measure` = ?");
        $stmt->execute(array($product_name, $measure_unit));
        return $stmt->fetch();
    }

    public static function insertInventory($product_name, $stock, $price, $measure_unit)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `inventory`(`product`, `stock`, `measure`, `price`, `date_upd`) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP())");
        $stmt->execute(array($product_name, $stock, $measure_unit, $price));

        $inserted_id = DbUtils::getInstance()->lastInsertId();

        //insert log
        Log::insertLog($_SESSION['id_user'], 'insert inventory', 'inserted id '.$inserted_id);

        return $inserted_id;
    }

    public static function updateStock($id, $stock)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `inventory` SET `stock` = ?, `date_upd` = CURRENT_TIMESTAMP() WHERE `ID` = ?");
        $stmt->execute(array($stock, $id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'update inventory', 'updated stock - id '.$id);
    }

    public static function updatePrice($id, $price)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `inventory` SET `price` = ?, `date_upd` = CURRENT_TIMESTAMP() WHERE `ID` = ?");
        $stmt->execute(array($price, $id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'update inventory', 'updated price - id '.$id);
    }

    public static function loadInventory($name = false, $stock_from = false, $stock_to = false)
    {
        $sql = 'SELECT * FROM `inventory`';
        if ($stock_from == $stock_to && $stock_to !== false && $stock_from !== false) {
            $sql .= " WHERE `stock` = $stock_to";
        } elseif ($stock_from && $stock_to) {
            $sql .= " WHERE `stock` > $stock_from AND `stock` < $stock_to";
        } elseif ($stock_from) {
            $sql .= " WHERE `stock` > $stock_from";
        } elseif ($stock_to) {
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

        $stmt = DbUtils::getInstance(true)->prepare($sql.' ORDER BY `ID` DESC');
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
