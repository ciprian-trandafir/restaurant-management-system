<?php

foreach (glob('../classes/' . "*.php") as $file)
{
    include_once $file;
}

if (!isset($_POST['action'])) {
    Link::redirect('index');
    exit;
}

session_start();

$action = trim(htmlspecialchars($_POST['action']));

if ($action === 'updatePassword') {
    $update_password = User::changePassword(trim(htmlspecialchars($_POST['old_password'])), trim(htmlspecialchars($_POST['new_password'])));
    die(json_encode(['response' => $update_password]));
}

Link::redirect('index');
exit;
