<?php

class Log
{
    private $ID;
    private $ID_user;
    private $action;
    private $details;
    private $date;

    /**
     * @param $ID
     * @param $ID_user
     * @param $action
     * @param $details
     * @param $date
     */
    public function __construct($ID, $ID_user, $action, $details, $date)
    {
        $this->ID = $ID;
        $this->ID_user = $ID_user;
        $this->action = $action;
        $this->details = $details;
        $this->date = $date;
    }

    public static function insertLog($ID_user, $action, $details): bool
    {
        $stmt = DbUtils::getInstance()->prepare("INSERT INTO `logs`(`ID_user`, `action`, `details`) VALUES (?, ?, ?)");
        $stmt->execute(array($ID_user, $action, $details));

        return true;
    }

    public static function getLogs($ID_user, $action, $sort, $date_from = false, $date_to = false)
    {
        $sql = 'SELECT `logs`.*, `users`.`first_name` AS `first_name`, `users`.`last_name` AS `last_name` FROM `logs`, `users` WHERE `logs`.`ID_user` = `users`.`ID` AND `logs`.`ID_user` = ? AND `action` = ?';
        if ($date_to && $date_from) {
            $sql .= " AND `date` > '".$date_from.":00' AND `date` < '".$date_to.":00'";
        } else if ($date_from) {
            $sql .= " AND `date` > '".$date_from.":00'";
        } else if ($date_to) {
            $sql .= " AND `date` < '".$date_to.":00'";
        }

        $stmt = DbUtils::getInstance()->prepare($sql.' ORDER BY `ID` '.$sort);
        $stmt->execute([$ID_user, $action]);
        return $stmt->fetchAll();
    }
}
