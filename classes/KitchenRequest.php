<?php

class KitchenRequest
{
    public static function getKitchenPendingRequests()
    {
        $sql = 'SELECT * FROM `kitchen_requests` WHERE `date_finished` IS NULL';

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPendingRequests($finished = false)
    {
        $sql = 'SELECT * FROM `kitchen_requests` 
        WHERE `request_user` = ? AND '.($finished ? '`date_finished` + interval 5 minute > CURRENT_TIMESTAMP()' : '`date_finished` IS NULL');

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute(array($_SESSION['id_user']));
        return $stmt->fetchAll();
    }

    public static function getAllPendingRequests()
    {
        $sql = 'SELECT * FROM `kitchen_requests` 
        WHERE (`date_finished` + interval 5 minute > CURRENT_TIMESTAMP() OR `date_finished` IS NULL) AND `request_user` = ?';

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute(array($_SESSION['id_user']));
        return $stmt->fetchAll();
    }

    public static function getAmountByDetails($id_invoice, $id_recipe)
    {
        $sql = 'SELECT `amount` FROM `invoices_products` WHERE `id_invoice` = ? AND `id_recipe` = ?';

        $stmt = DbUtils::getInstance(true)->prepare($sql);
        $stmt->execute(array($id_invoice, $id_recipe));
        return $stmt->fetchAll();
    }

    public static function createRequest($id_invoice, $id_recipe)
    {
        $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO `kitchen_requests`(`id_invoice`, `id_recipe`, `request_user`, `date_add`) VALUES (?, ?, ?, CURRENT_TIMESTAMP())");
        $stmt->execute(array($id_invoice, $id_recipe, $_SESSION['id_user']));
    }

    public static function finishRequest($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `kitchen_requests` SET `respondent_user` = ?, `date_finished` = CURRENT_TIMESTAMP() WHERE `ID` = ?");
        $stmt->execute(array($_SESSION['id_user'], $id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'finish kitchen request', 'finish id '.$id);
    }
}
