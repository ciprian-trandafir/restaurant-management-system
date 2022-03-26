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

if ($action === 'getLogs') {
    $user = trim(htmlspecialchars($_POST['user']));
    $action_user = trim(htmlspecialchars($_POST['action_user']));
    $sort = trim(htmlspecialchars($_POST['sort']));
    $date_from = trim(htmlspecialchars($_POST['date_from']));
    $date_to = trim(htmlspecialchars($_POST['date_to']));

    $date_from = str_replace('T', ' ', $date_from);
    $date_to = str_replace('T', ' ', $date_to);

    $logs = Log::getLogs($user, $action_user, $sort, $date_from, $date_to);

    $output = '';
    foreach ($logs as $log) {
        $output .= '<tr class="table-rows">
                    <td class="table-cell">'.$log['ID'].'</td>
                    <td class="table-cell">'.$log['first_name'].' '.$log['last_name'].'</td>
                    <td class="table-cell">'.$log['action'].'</td>
                    <td class="table-cell">'.$log['details'].'</td>
                    <td class="table-cell">'.$log['date'].'</td>
                </tr>';
    }

    die(json_encode(['response' => $output]));
}

Link::redirect('index');
exit;
