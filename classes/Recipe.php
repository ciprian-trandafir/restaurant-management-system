<?php

class Recipe
{
    private $id;
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
        $user = $stmt->fetch();

        $this->name = $user['name'];
        $this->price = $user['price'];
        $this->date_upd = $user['date_upd'];

        $this->loadIngredients();
    }

    public function loadIngredients()
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT ri.`ID` AS recipe_ing_id, ri.*, i.* FROM `recipes_ingredients` ri, `inventory` i WHERE i.`ID` = ri.`id_recipe`  AND `id_recipe` = ?");
        $stmt->execute(array($this->id));
        $recipe_ingredients = $stmt->fetchAll();

        $this->ingredients = $recipe_ingredients;
    }

    public static function loadRecipes()
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `recipes`");
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
