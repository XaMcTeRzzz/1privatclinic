<?php

require_once get_template_directory() . '/core/telegram/Telegram.php';

add_action('wp_ajax_send_tg_message', 'send_tg_message');
add_action('wp_ajax_nopriv_send_tg_message', 'send_tg_message');

function send_tg_message() {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];
    $status = 1;

    if (!phoneValidate($phone)) {
        $status = 0;
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