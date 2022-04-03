<?php

class Invoice
{
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

    public static function payInvoice($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `invoices` SET `paid` = 1, `date_paid` = CURRENT_TIMESTAMP() WHERE `ID` = ?");
        $stmt->execute(array($id));

        //insert log
        Log::insertLog($_SESSION['id_user'], 'pay invoice', 'paid invoice id '.$id);
    }
}
