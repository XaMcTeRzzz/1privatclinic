<?php

add_action('wp_ajax_send_email', 'send_email');
add_action('wp_ajax_nopriv_send_email', 'send_email');

function send_email() {
    $type = $_POST['type'];
    $subject = $_POST['subject'];
    $from = pods('feedback')->field('feedback_email_sender');
    $to = pods('feedback')->field('feedback_email');
    $errors = [];
    if ($type == 1 || $type == "1") {
        $name = $_POST['name'];
        $phone_to_send = $_POST['phone'];
        $phone = preg_replace('/[^0-9.]+/', '', $phone_to_send);
        if (preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name) && trim($name) !="" && strlen($phone) == 12) {
            $headers = 'From: MEDZDRAV <'. $from .'>' . "\r\n";
            $message = 'Имя: ' . $name . "\n" . 'Телефон: ' . $phone_to_send;
            wp_mail($to, $subject, $message, $headers);
            wp_send_json([
                'status' => 1
            ]);
        } else {
            if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name) || trim($name) == "") {
                $errors[] = 'name';
            }
            if (strlen($phone) != 12) {
                $errors[] = 'phone';
            }
            wp_send_json([
                'status' => 0,
                'errors' => $errors
            ]);
        }

    } else if ($type == 2 || $type == "2") {
        $name = $_POST['name'];
        $phone_to_send = $_POST['phone'];
        $phone = preg_replace('/[^0-9.]+/', '', $phone_to_send);
        $email = $_POST['email'];
        $review = $_POST['review'];
        if (preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name) && trim($review) != "") {
            $headers = 'From: MEDZDRAV <'. $from .'>' . "\r\n";
            $message = 'Имя: ' . $name . "\n" . 'Телефон: ' . $phone_to_send . "\n" . 'E-mail: ' . $email . "\n" . 'Отзыв: ' . $review;
            wp_mail($to, $subject, $message, $headers);
            wp_send_json([
                'status' => 1
            ]);
        } else {
            if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/u', $name) || trim($name) == "") {
                $errors[] = 'name';
            }
            if (trim($review) == "") {
                $errors[] = 'review';
            }
            wp_send_json([
                'status' => 0,
                'errors' => $errors
            ]);
        }
    }

}

add_action('wp_ajax_send_mail_two', 'sign_mail_two');
add_action('wp_ajax_nopriv_send_mail_two', 'sign_mail_two');

function sign_mail_two(){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $from = pods('feedback')->field('feedback_email_sender');
        # FIX: Replace this email with recipient email
        $mail_to = pods('feedback')->field('feedback_email');
        $subject = 'Заявка с сайта '. get_bloginfo('name');
        $content = '';
        $errors = [];
        /* Форма Запись на прием */
        if($_POST['sign_up']){
            # Sender Data
            $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
            $phone = $_POST['phone'];
            $doctor = $_POST['doctor'];
            $category = $_POST['category'];
            $selectCategory  = $_POST['select-selected'];

            if (empty($name) OR empty($phone) OR strlen(preg_replace('/[^0-9.]+/', '', $phone)) != 12 OR empty($selectCategory)) {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Пожалуйста заполните все поля";
                exit;
            }
            # Mail Content
            $content = "Отделение: $category\n";
            $content .= "Запись на прием к : $doctor\n\n";
            $content .= "Пациент\n\n";
            $content .= "Имя: $name\n\n";
            $content .= "Телефон: $phone\n\n";
            $messagetgs = urlencode("Отделение: $category\nЗапись на прием к : $doctor\nПациент\nИмя: $name\nТелефон: $phone");
        }

        if($_POST['sign_up_special']){
            # Sender Data
            $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
            $phone = $_POST['phone'];
            $doctor = $_POST['doctor'];
            $selectDoctor  = $_POST['select-selected'];

            if (empty($name) OR empty($phone) OR strlen(preg_replace('/[^0-9.]+/', '', $phone)) != 12 OR empty($selectDoctor)) {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Пожалуйста заполните все поля";
                exit;
            }
            # Mail Content
            $content .= "Запись на прием к : $doctor\n\n";
            $content .= "Пациент\n\n";
            $content .= "Имя: $name\n\n";
            $content .= "Телефон: $phone\n\n";
        }


        /* Форма Обратный звонок */
        if($_POST['call_back']){
            # Sender Data
            $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
            $phone = $_POST['phone'];

            if (empty($name) OR empty($phone) OR strlen(preg_replace('/[^0-9.]+/', '', $phone)) != 12) {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Пожалуйста заполните все поля";
                exit;
            }
            # Mail Content
            $content = "Обратный звонок\n";
            $content .= "Имя: $name\n\n";
            $content .= "Телефон: $phone\n\n";
        }

        if($_POST['ask_question']){
            # Sender Data
            $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
            $phone = $_POST['phone'];
            $doctor = $_POST['doctor'];
            $askText = $_POST['ask_text'];
            $selectCategory  = $_POST['select-selected'];

            if (empty($name) OR empty($phone) OR strlen(preg_replace('/[^0-9.]+/', '', $phone)) != 12 OR empty($selectCategory)) {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Пожалуйста заполните все поля";
                exit;
            }
            # Mail Content
            $content .= "Вопрос для : $doctor\n\n";
            $content .= "Пациент\n\n";
            $content .= "Имя: $name\n\n";
            $content .= "Телефон: $phone\n\n";
            $content .= "Вопрос: $askText\n\n";
        }

        if($_POST['check_up']){
            # Sender Data
            $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
            $phone = $_POST['phone'];
            $data = $_POST['date'];

            if (empty($name) OR empty($phone) OR strlen(preg_replace('/[^0-9.]+/', '', $phone)) != 12 OR empty($data)) {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Пожалуйста заполните все поля";
                exit;
            }
            # Mail Content
            $content .= "Запись на чекап: \n";
            $content .= "Пациент\n\n";
            $content .= "Имя: $name\n\n";
            $content .= "Телефон: $phone\n\n";
            $content .= "Дата: $data\n\n";
        }

        if($_POST['sub_form']){
            # Sender Data
            $email = $_POST['sub_mail'];

            if (empty($email)) {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Пожалуйста заполните все поля";
                exit;
            }
            # Mail Content
            $content .= "Подписка: \n";
            $content .= "email: $email\n\n";
        }



        # email headers.
        $headers = "From: MEDZDRAV <$from>";

        # Send the email.
        $success = wp_mail($mail_to, $subject, $content, $headers);

        if ($success) {
            //создание задачи в crm
//            if ( ! function_exists( 'create_task_in_crm' ) ) require_once(ABSPATH . 'wp-content/themes/privatclinic/core/crm/crm.php');
//            create_task_in_crm('Запись с сайта', $content);
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Ваше сообщение отправлено.";
            echo $mail_to;
            if($_POST['sign_up']){
                $token = '5120204941:AAFOJp1xXjlg6nMePOHNf1SiCzG_qzsvGl8'; // устанавливается также в файле telegram-webhook.php
                $response = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=-761861816&text=$messagetgs");
            }
            die();
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Ой! Что-то пошло не так, нам не удалось отправить ваше сообщение.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Возникла проблема с отправкой, попробуйте еще раз.";
    }
}

function send_cv(){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['cv']) {

        $from = pods('feedback')->field('feedback_email_sender');
        # FIX: Replace this email with recipient email
        $mail_to = pods('feedback')->field('feedback_email');
        $subject = 'Заявка с сайта '. get_bloginfo('name');
        $content = '';
        $errors = [];

        if($_POST['cv']){
            # Sender Data
            $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
            $phone = $_POST['phone'];

            if (empty($name) OR empty($phone) OR strlen(preg_replace('/[^0-9.]+/', '', $phone)) != 12 OR $_FILES['cv']['name'] == '') {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                wp_redirect( home_url('/vakansii/#field-not-empty') );
                exit;
            }

            if($_FILES['cv']['size'] > (5 * 1048576)){
                wp_redirect( home_url('/vakansii/#file-too-large') );
                exit;
            }

            # Mail Content
            $content = "Отклик на вакансию\n\n";
            $content .= "Кандидат\n";
            $content .= "Имя: $name\n";
            $content .= "Телефон: $phone\n";

            if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
            $uploadedfile = $_FILES['cv'];
            $upload_overrides = array( 'test_form' => false );
            $attachments = wp_handle_upload( $uploadedfile, $upload_overrides );
        }



        # email headers.
        $headers = "From: MEDZDRAV <$from>";

        # Send the email.
        $success = wp_mail($mail_to, $subject, $content, $headers, $attachments);

        if ($success) {
            wp_delete_file($attachments['file']);
            wp_redirect( home_url('/vakansii/#thanks') );
            exit;
        } else {
            wp_delete_file($attachments['file']);
            wp_redirect( home_url('/vakansii/#something-went-wrong') );
            exit;
        }
    }
}