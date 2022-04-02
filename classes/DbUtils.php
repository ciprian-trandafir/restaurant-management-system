<?php

class DbUtils
{
    private static $conn;

/*    protected static $server = "localhost";
    protected static $user_name = "ct224";
    protected static $password = "vta8nmgu";
    protected static $database = "ct224";*/

    protected static $server = "localhost";
    protected static $user_name = "root";
    protected static $password = "";
    protected static $database = "restaurant";

/*    protected static $server = "localhost";
    protected static $user_name = "lt142";
    protected static $password = "cbd0po8k";
    protected static $database = "lt142";*/

    public static function getInstance($return = false)
    {
        if (self::$conn != null) {
            return self::$conn;
        }

        try {
            self::$conn = new PDO("mysql:dbname=".self::$database."; host=".self::$server, self::$user_name, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            if ($return) {
                return self::$conn;
            }
        } catch (PDOException $e) {
            @file_put_contents('error_log', @file_get_contents('error_log') .date('Y-m-d H:i:s').' '. $e->getMessage() . "\n");
            die('Eroare DB.');
        }
    }

    public static function deleteRow($id, $table)
    {
        //insert log
        switch($table) {
            case 'recipes_ingredients':
                $stmt = DbUtils::getInstance(true)->prepare("SELECT `id_recipe` FROM `recipes_ingredients` WHERE `ID` = ?");
                $stmt->execute(array($id));
                $ingredient = $stmt->fetchAll();

                Log::insertLog($_SESSION['id_user'], 'delete', 'deleted ingredient with id '.$id.' from recipe '.$ingredient[0]['id_recipe']);
                break;
            case 'inventory':
                $inventory = new Inventory($id);
                Log::insertLog($_SESSION['id_user'], 'delete', 'deleted inventory product with id '.$id.' and name '.$inventory->getProduct());
                break;
            default:
                break;
        }

        //delete row
        $stmt = DbUtils::getInstance(true)->prepare("DELETE FROM `$table` WHERE `ID` = $id");
        $stmt->execute();
    }
}
