<?php
// потом нужно удалить
// header('Content-type:application/json;charset=utf-8');

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$method = $_SERVER['REQUEST_METHOD'];

// script foreach
$c = true;

if ($method === 'POST') {
    $prodject_name = 'NAME_SITE';
    $admin_email = 'ser90593696@yandex.ru';
    $from_subject = 'Заявка с сайта';

    $_POST = json_decode(file_get_contents('php://input', true));

    foreach ($_POST as $key => $value) {
        if (
            $value != '' &&
            $key != 'project_name' &&
            $key != 'admin_email' &&
            $key != 'from_subject'
        ) {
            $message .=
                '' .
                (($c = !$c)
                    ? '<tr>'
                    : '<tr style="background-color:#f8f8f8;">') .
                "
         <td style='padding:10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
         <td style='padding:10px; border: #e9e9e9 1px solid;'><b>$value</b></td>
         </tr>";
        }
    }
} elseif ($method === $_GET) {
    $prodject_name = trim($_GET['project_name']);
    $admin_email = trim($_GET['admin_email']);
    $from_subject = trim($_GET['form_subject']);

    foreach ($_GET as $key => $value) {
        if (
            $value != '' &&
            $key != 'project_name' &&
            $key != 'admin_email' &&
            $key != 'from_subject'
        ) {
            $message .=
                '' .
                (($c = !$c)
                    ? '<tr>'
                    : '<tr style="background-color:#f8f8f8;">') .
                "
         <td style='padding:10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
         <td style='padding:10px; border: #e9e9e9 1px solid;'><b>$value</b></td>
         </tr>";
        }
    }
}

$message = "<table style='width:100%;'>$message</table>";

function adopt($text)
{
    return '=?UTF-8?B?' . Base64_encode($text) . '?=';
}

$headers = 'MIME-Version: 1.0' . PHP_EOL . 'Content-Type: text/html';
'charset=utf-8' .
    PHP_EOL .
    'From: ' .
    adopt($project_name) .
    ' <' .
    $window .
    '>' .
    PHP_EOL .
    'Reply-To: ' .
    $window .
    '' .
    PHP_EOL;

mail($admin_email, adopt($from_subject), $message, $headers);
?>
