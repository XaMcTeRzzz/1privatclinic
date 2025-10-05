<?php

add_action('wp_ajax_send_tg_message', 'send_tg_message');
add_action('wp_ajax_nopriv_send_tg_message', 'send_tg_message');

function send_tg_message() {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $date = $_POST['date'];
    $status = 1;

    if (!phoneValidate($phone) || empty(trim($date))) {
        $status = 0;
    } else {
        if (empty(trim($email))) {
            $email = '-';
        }
        if (empty(trim($comment))) {
            $comment = '-';
        }
        if (sendMessage($email, $phone, $comment, $date)) {
            $status = 1;
        } else {
            $status = 2;
        }
    }
    $response = ['status' => $status];
    wp_send_json($response);
}

function phoneValidate($phone){
    $phone = str_replace(' ', '', $phone);
    $phone = str_replace('_', '', $phone);
    $phone = str_replace('(', '', $phone);
    $phone = str_replace(')', '', $phone);
    if (strlen($phone) != 12) {
        return false;
    }
    return true;
}

function sendMessage($email, $phone, $comment, $date) {
    global $wpdb;

//    $token = '1267580343:AAHxJ-DPDYy1BcAE-gOD4T6XXngC0IS93g4'; // устанавливается также в файле telegram-webhook.php
    $token = '5120204941:AAFOJp1xXjlg6nMePOHNf1SiCzG_qzsvGl8'; // устанавливается также в файле telegram-webhook.php

    $date = date_create($date);
    $date = date_format($date, 'd.m.Y');

    $message = urlencode("Поступила новая заявка на тестирование на COVID-19.\n\nТелефон: $phone\nДата: $date\nEmail: $email\nКомментарий: $comment");

//    $chats = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tg_covid_subscrabers WHERE check_password = 1", ARRAY_A);
    $response = false;
//    foreach ($chats as $chat) {
//        $response = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id={$chat['chat_id']}&text=$message");
//    }
    
    $response = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=-761861816&text=$message");
    return $response;
}