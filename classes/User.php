<?php

class User
{
    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $access_level;
    private $active;

    public function __construct($id = false)
    {
        if ($id) {
            $this->id = $id;
            $this->load_profile($id);
        }
    }

    private function load_profile($id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `users` WHERE `ID` = ?");
        $stmt->execute(array($id));
        $user = $stmt->fetch();

        $this->first_name = $user['first_name'];
        $this->last_name = $user['last_name'];
        $this->email = $user['email'];
        $this->access_level = $user['access_level'];
        $this->active = $user['active'];
    }

    public static function checkEmail($email, $id_user = false): bool
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `users` WHERE `email` = ? ".($id_user ? ' AND `ID` <> '.$id_user : ''));
        $stmt->execute(array($email));
        $user = $stmt->fetch();

        if ($user) {
            return true;
        }

        return false;
    }

    public static function login($email, $password): int
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->execute(array($email));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt_ = DbUtils::getInstance(true)->prepare('UPDATE `users` SET `password` = ? WHERE `ID` = ?');
                $stmt_->execute(array($hash, $user['ID']));
            }

            if ($user['active'] == 0) {
                return 2;
            }

            //insert log
            Log::insertLog($user['ID'], 'login', 'logged in from IP '.$_SERVER['REMOTE_ADDR']);

            //update session ID
            $_SESSION['id_user'] = $user['ID'];

            return 3;
        }

        return 1;
    }

    public static function update($user, $email, $first_name, $last_name): int
    {
        if (!User::checkEmail($email, $user['ID'])) {
            if ($email != $user['email'] || $first_name != $user['first_name'] || $last_name != $user['last_name']) {
                User::updateDetails($first_name, $last_name, $email, $user['ID']);
            }

            return 1;
        }

        return 0;
    }

    private static function updateDetails($first_name, $last_name, $email, $id)
    {
        $stmt = DbUtils::getInstance(true)->prepare("UPDATE `users` SET `email` = ?, `first_name` = ?, `last_name` = ? WHERE `ID` = ?");
        $stmt->execute(array($email, $first_name, $last_name, $id));
    }

    public static function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION['id_user']);
        Link::redirect('login');
    }

    public static function register($first_name, $last_name, $email, $password, $access_level): bool
    {
        if (!User::checkEmail($email)) {
            $stmt = DbUtils::getInstance(true)->prepare("INSERT INTO users(`first_name`, `last_name`, `password`, `email`, `access_level`) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(array($first_name, $last_name, password_hash($password, PASSWORD_DEFAULT), $email, $access_level));
            return true;
        }

        return false;
    }

    public static function check_page() {
        session_start();

        if (!isset($_SESSION['id_user'])) {
            User::logout();
        }
    }

    public static function getDetails($id): array
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT * FROM `users` WHERE `ID` = ?");
        $stmt->execute(array($id));
        $user = $stmt->fetch();

        $data = [];
        $data['ID'] = $user['ID'];
        $data['first_name'] = $user['first_name'];
        $data['last_name'] = $user['last_name'];
        $data['email'] = $user['email'];
        $data['access_level'] = $user['access_level'];

        return $data;
    }

    public static function checkAccessLevel($id_user, $access_level)
    {
        $user = User::getDetails($id_user);
        if ($user['access_level'] != $access_level) {
            Link::redirect('403');
        }
    }

    public static function changePassword($old_password, $new_password): bool
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT `password` FROM `users` WHERE `ID` = ?");
        $stmt->execute(array($_SESSION['id_user']));
        $user = $stmt->fetch();

        if ($user && password_verify($old_password, $user['password'])) {
            $stmt = DbUtils::getInstance(true)->prepare("UPDATE `users` SET `password` = ? WHERE `ID` = ?");
            $stmt->execute(array(password_hash($new_password, PASSWORD_DEFAULT),$_SESSION['id_user']));
            return true;
        }

        return false;
    }

    public static function getUsers()
    {
        $stmt = DbUtils::getInstance(true)->prepare("SELECT `ID`, `first_name`, `last_name` FROM `users`");
        $stmt->execute();
        $users = $stmt->fetchAll();

        $output = [];
        foreach ($users as $user) {
            $output[] = [
                'ID' => $user['ID'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            ];
        }

        return $output;
    }

    /**
     * @return mixed
     */
    public function getAccessLevel()
    {
        return $this->access_level;
    }
}
