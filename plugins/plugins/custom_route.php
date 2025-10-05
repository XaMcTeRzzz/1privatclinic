<?php
/*
Plugin Name: Covid Tests Verification
Version: 1.0.0
*/

class OP_Plugin
{
  
  public function init()
  {
    add_action('init', array($this, 'add_rewrite_rules'));
    add_filter('query_vars', array($this, 'add_query_vars'));
    add_filter('template_include', array($this, 'add_template'));
    add_action('wp', array($this, 'token_activation'));
    add_action('update_file_hook_1', array($this, 'download_file'));
    add_action('wp', array($this, 'token_activation2'));
    add_action('update_file_hook_2', array($this, 'parse_csv'));

    add_action('wp', array($this, 'token_activation3'));
    add_action('update_file_hook_3', array($this, 'download_file'));
    add_action('wp', array($this, 'token_activation4'));
    add_action('update_file_hook_4', array($this, 'parse_csv'));

    add_action('wp', array($this, 'token_activation5'));
    add_action('update_file_hook_5', array($this, 'download_file'));
    add_action('wp', array($this, 'token_activation6'));
    add_action('update_file_hook_6', array($this, 'parse_csv'));
  }
  
  public function token_activation()
  {
    if (!wp_next_scheduled('update_file_hook_1')) {
      wp_schedule_event(strtotime('2020-12-21 05:20:00'), 'twicedaily', 'update_file_hook_1');
    }
  }
  
  public function token_activation2()
  {
    if (!wp_next_scheduled('update_file_hook_2')) {
      wp_schedule_event(strtotime('2020-12-21 05:25:00'), 'twicedaily', 'update_file_hook_2');
    }
  }
  
  public function token_activation3()
  {
    if (!wp_next_scheduled('update_file_hook_3')) {
      wp_schedule_event(strtotime('2020-12-22 12:25:00'), 'daily', 'update_file_hook_3');
    }
  }
  
  public function token_activation4()
  {
    if (!wp_next_scheduled('update_file_hook_4')) {
      wp_schedule_event(strtotime('2020-12-22 12:30:00'), 'daily', 'update_file_hook_4');
    }
  }
  
  public function token_activation5()
  {
    if (!wp_next_scheduled('update_file_hook_5')) {
      wp_schedule_event(strtotime('2020-12-22 15:25:00'), 'daily', 'update_file_hook_5');
    }
  }
  
  public function token_activation6()
  {
    if (!wp_next_scheduled('update_file_hook_6')) {
      wp_schedule_event(strtotime('2020-12-22 15:30:00'), 'daily', 'update_file_hook_6');
    }
  }
  
  public function add_template($template)
  {
    $covid_test_id = get_query_var('covid_test_id');
    if ($covid_test_id) {
      return get_template_directory() . '/covid-tests-verification.php';
    }
    return $template;
  }

//  public function flush_rules()
//  {
//    $this->rewrite_rules();
//    flush_rewrite_rules();
//  }
  
  public function add_rewrite_rules()
  {
    add_rewrite_rule('covid/(.+?)/?$', 'index.php?covid_test_id=$matches[1]', 'top');
  }
  
  public function add_query_vars($vars)
  {
    $vars[] = 'covid_test_id';
    return $vars;
  }

//  public function parse_csv2(){
//    $upload = wp_upload_dir();
//    $csvFile = file($upload['basedir'] . '/somefile.csv');
//    $data = [];
//    foreach ($csvFile as $line) {
//      $data[] = str_getcsv($line, '	');
//    }
//    print_r($data);
//  }
  public function parse_csv()
  {
    global $wpdb;
    $table  = $wpdb->prefix . 'covid_tests_verification';
    $upload = wp_upload_dir();
    
    $all_items = $wpdb->get_results($wpdb->prepare(
      "
		SELECT `request_num_int` FROM `$table`"
    ), ARRAY_A);
    $all_items = array_column($all_items, 'request_num_int');
//    print_r($all_items);
    
    $csvData = file_get_contents($upload['basedir'] . '/csv/dbo_vRequestForQrCode.csv');
    //$csvData = mb_convert_encoding(file_get_contents($upload['basedir'] . '/csv/dbo_vRequestForQrCode.csv'), 'utf-8', 'cp1251');
    //$csvData = iconv('CP1251', 'UTF-8', file_get_contents($upload['basedir'] . '/somefile.csv'));
    
    $lines = explode(PHP_EOL, $csvData);
    $array = array();
    foreach ($lines as $key => $line) {
        if (empty($line) || $key == 0) continue;
        $array[] = str_getcsv($line, ';');
    }

//    print_r($all_items);
    $all_items_current = [];
    foreach ($array as $item) {
      if (in_array($item[0], $all_items)) {
        //$changed_record_count = $wpdb->update($table, $data, array('sl_id' => $sl_id));
//        $wpdb->update( $wpdb->options, array( 'option_value' => $user->user_email ), array( 'option_name' => 'admin_email' ) );
        $changed_record_count = $wpdb->update($table, array(
          //'request_num_int' => $wpdb->prepare(($item[0] != 'null') ? $item[0] : ''),
          'ispolnitel'      => $wpdb->prepare(($item[1] != 'null') ? $item[1] : ''),
          'patient_name'    => $wpdb->prepare(($item[2] != 'null') ? $item[2] : ''),
          'date_request'    => $wpdb->prepare(($item[3] != 'null') ? date("Y-m-d", strtotime($item[3])) : '0000-00-00'),
          'workplace_name'  => $wpdb->prepare(($item[4] != 'null') ? $item[4] : ''),
          'validator'       => $wpdb->prepare(($item[5] != 'null') ? $item[5] : ''),
          'date_validation' => $wpdb->prepare(($item[6] != 'null') ? date("Y-m-d H:i:s", strtotime($item[6])) : '0000-00-00 00:00:00')
          //'result'          => $wpdb->prepare(($item[6] != 'null') ? $item[6] : '')
        ), array('request_num_int' => $item[0]));
//        if (!$changed_record_count) {
//          return new WP_Error('db_update_error', __('Could not insert site into the database.'), $wpdb->last_error);
//        }
      } elseif (!in_array($item[0], $all_items_current)) {
        array_push($all_items_current, $item[0]);
        if (false === $wpdb->insert($table, array(
            'request_num_int' => $wpdb->prepare(($item[0] != 'null') ? $item[0] : ''),
            'ispolnitel'      => $wpdb->prepare(($item[1] != 'null') ? $item[1] : ''),
            'patient_name'    => $wpdb->prepare(($item[2] != 'null') ? $item[2] : ''),
            'date_request'    => $wpdb->prepare(($item[3] != 'null') ? date("Y-m-d", strtotime($item[3])) : '0000-00-00'),
            'workplace_name'  => $wpdb->prepare(($item[4] != 'null') ? $item[4] : ''),
            'validator'       => $wpdb->prepare(($item[5] != 'null') ? $item[5] : ''),
            'date_validation' => $wpdb->prepare(($item[6] != 'null') ? date("Y-m-d H:i:s", strtotime($item[6])) : '0000-00-00 00:00:00')
            //'result'          => $wpdb->prepare(($item[6] != 'null') ? $item[6] : '')
          ))) {
          return new WP_Error('db_insert_error', __('Could not insert site into the database.'), $wpdb->last_error);
        }
      }
    }

  }
  
  public function download_file()
  {
    $host = '82.117.232.233:2229';
    $pass = 'A0WI"X';
    $user = 'mcmed';
    
    $upload = wp_upload_dir();
    
    $remote = "sftp://$user:$pass@$host/home/dbo_vRequestForQrCode.csv";
    $local  = $upload['basedir'] . '/csv/dbo_vRequestForQrCode.csv';
//
//    $test = shell_exec('whoami');
//    $token = '5120204941:AAFOJp1xXjlg6nMePOHNf1SiCzG_qzsvGl8';
//    $response = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=71138554&text=$test");

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $remote);
    curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
    curl_setopt($curl, CURLOPT_USERPWD, "$user:$pass");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    file_put_contents($local, curl_exec($curl));
    curl_close($curl);
  }
  
}

$op_plugin = new OP_Plugin();
$op_plugin->init();
// $op_plugin->download_file();
// $op_plugin->parse_csv();
