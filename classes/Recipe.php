<?php

class Recipe
{
    public $id;
    private $name;
    private $price;
    private $date_upd;
    private $ingredients;

    public function __construct($id = false)
    {
        if ($id) {
            $this->id = $id;
            $this->load_recipe($id);
        }
    }

    private function load_recipe($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `recipes` WHERE `ID` = ?");
        $stmt->execute(array($id));
        $recipe = $stmt->fetchAll();

        if ($recipe) {
            $this->name = $recipe[0]['name'];
            $this->price = $recipe[0]['price'];
            $this->date_upd = $recipe[0]['date_upd'];

            $this->loadIngredients();
        }
    }

    public static function editRecipe($id, $name, $price)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `recipes` SET `name` = ?, `price` = ?, `date_upd` = CURRENT_TIMESTAMP() WHERE `ID` = ?");
        $stmt->execute(array($name, $price, $id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'update recipe', 'updated id '.$id);
    }

    public static function insertRecipe($recipe_name, $price)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `recipes`(`name`, `price`, `date_upd`) VALUES (?, ?, CURRENT_TIMESTAMP())");
        $stmt->execute(array($recipe_name, $price));

        $inserted_id = DbUtils::getInstance()->lastInsertId();

        //insert log
        Log::insertLog($_SESSION['id_user'], 'insert recipe', 'inserted id '.$inserted_id);

        return $inserted_id;
    }

    public static function updateIngredientQty($ing_id, $qty)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `recipes_ingredients` SET `quantity` = ? WHERE `ID` = ?");
        $stmt->execute(array($qty, $ing_id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'update ingredient', 'updated id '.$ing_id);
    }

    public static function addIngredient($id_recipe, $id_product, $qty)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `recipes_ingredients` (`id_recipe`, `id_product`, `quantity`) VALUES (?, ?, ?)");
        $stmt->execute(array($id_recipe, $id_product, $qty));

        $inserted_id = DbUtils::getInstance()->lastInsertId();

        //insert log
        Log::insertLog($_SESSION['id_user'], 'insert ingredient', 'inserted id '.$inserted_id);

        return $inserted_id;
    }

    public function loadIngredients()
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT ri.`ID` AS recipe_ing_id, ri.*, i.* FROM `recipes_ingredients` ri, `inventory` i WHERE i.`ID` = ri.`id_product`  AND `id_recipe` = ? ORDER BY ri.`ID` DESC");
        $stmt->execute(array($this->id));

        $this->ingredients = $stmt->fetchAll();
    }

    public static function loadRecipes()
    {
        $sql = "SELECT * FROM `recipes`";

        if (isset($_COOKIE['recipeFilters'])) {
            $filters = json_decode($_COOKIE['recipeFilters'], true);

            if ($filters['price_from'] == $filters['price_to'] && $filters['price_from'] !== '' && $filters['price_to'] !== '') {
                $sql .= " WHERE `price` = ".$filters['price_from'];
            } elseif ($filters['price_from'] && $filters['price_to']) {
                $sql .= " WHERE `price` > ".$filters['price_from']." AND `price` < ".$filters['price_to'];
            } elseif ($filters['price_from']) {
                $sql .= " WHERE `price` > ".$filters['price_from'];
            } elseif ($filters['price_to']) {
                $sql .= " WHERE `price` < ".$filters['price_to'];
            }

            if ($filters['name']) {
                if (strpos($sql, 'WHERE') === false) {
                    $sql .= ' WHERE';
                }

                if (strpos($sql, 'price') !== false) {
                    $sql .= ' AND ';
                }

                $sql .= ' `name` LIKE "%'.$filters['name'].'%"';
            }
        }

        $stmt = DbUtils::getInstance(true)->prepare($sql.' ORDER BY `ID` DESC');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}
