<?php

namespace Telegram;

class Telegram
{

    public $token;
    public $chatID;
    public $message;

    public function __construct($token, $chatID, $message) {
        $this->token = $token;
        $this->chatID = $chatID;
        $this->message = $message;
    }

    public function commandsHandler($token, $chatID, $message) {
        if ($message == '/start') {
            $this->addChatIdToDb($token, $chatID, $message);
        } else if ($message == '/stop') {
            $this->removeChatIdFromDb($token, $chatID, $message);
        } else if ($message == 'CovidMedzdravTest') { // пароль для доступа
            $this->checkPassword($token, $chatID, $message);
        }  else {
            $this->send($token, $chatID, "Неизвестная команда.");
        }
    }

    public function checkPassword($token, $chatID, $message) {
        global $wpdb;
        $selectResult = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tg_covid_subscrabers WHERE chat_id = $chatID && check_password = 0");
        if (!empty($selectResult)) {
            $query = "UPDATE {$wpdb->prefix}tg_covid_subscrabers SET check_password = 1 WHERE chat_id = $chatID";
            $wpdb->query($query);
            $this->send($token, $chatID, "Вы успешно подписались на рассылку о заявках на тестирование COVID-19. Чтобы отписаться, введите и отправьте /stop");
        } else {
            $this->send($token, $chatID, "Вы уже подписаны на рассылку о заявках на тестирование.");
        }
    }

    public function addChatIdToDb($token, $chatID, $message) {
        global $wpdb;
        $selectResult = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tg_covid_subscrabers WHERE chat_id = $chatID");
        if (empty($selectResult)) {
            $query = 'INSERT INTO '. $wpdb->prefix .'tg_covid_subscrabers (chat_id) VALUES (' . $chatID . ')';
            $wpdb->query($query);
            $this->send($token, $chatID, "Введите и отправьте пароль, чтобы подписаться на рассылку о заявках на тестирование.");
        } else {
            $this->send($token, $chatID, "Вы уже подписаны на рассылку о заявках на тестирование.");
        }
    }

    public function removeChatIdFromDb($token, $chatID, $message) {
        global $wpdb;
        $selectResult = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}tg_covid_subscrabers WHERE chat_id = $chatID");
        if (!empty($selectResult)) {
            $query = 'DELETE FROM '. $wpdb->prefix .'tg_covid_subscrabers WHERE chat_id = ' . $chatID . ';';
            $wpdb->query($query);
            $this->send($token, $chatID, "Вы успешно отписались от рассылки. Чтобы подписаться снова, введите и отправьте /start");
        } else {
            $this->send($token, $chatID, "Вы не подписаны на рассылку о заявках на тестирование.");
        }
    }

    public function send($token ,$chatID, $message) {
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chatID&text=$message");
    }

}