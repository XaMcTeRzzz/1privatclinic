<?php

function create_task_in_crm($name, $content) {
    $url = API_URL_CRM . '/Task';
    $ch = curl_init();

    $params = json_encode([
        'name' => $name,
        'description' => $content,
        'assignedUserId' => API_ASSIGNED_USER_ID_CRM
    ]);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-Api-Key: " . API_X_API_KEY_CRM,
        "Content-Type: application/json",
    ]);

    curl_exec($ch);
}