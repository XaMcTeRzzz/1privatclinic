<?php get_header(); ?>
<?php
$test_id = get_query_var('covid_test_id');
if ($test_id) {
  global $wpdb;
  $table   = $wpdb->prefix . 'covid_tests_verification';
  $results = $wpdb->get_results($wpdb->prepare(
    "
		SELECT * FROM `$table` WHERE `request_num_int` = '" . $test_id . "' ORDER BY `id` DESC LIMIT 1"
  ), ARRAY_A);
}
if (LOCALE == 'ru') {
  $title           = 'Результаты теста на Covid-19';
  $no_result       = 'Подтверждение не было найдено';
  $patient_name    = 'Имя пациента:';
  $date_request    = 'Дата регистрации:';
  $ispolnitel      = 'Исполнитель:';
  $workplace_name  = 'Анализатор:';
  $validator       = 'Валидатор:';
  $date_validation = 'Дата валидации:';
} else if (LOCALE == 'ua') {
  $title           = 'Результати тесту на Covid-19';
  $no_result       = 'Підтвердження не було знайдено';
  $patient_name    = 'Iм\'я пацієнта:';
  $date_request    = 'Дата реєстрації:';
  $ispolnitel      = 'Виконавець:';
  $workplace_name  = 'Аналізатор:';
  $validator       = 'Валідатор:';
  $date_validation = 'Дата валідації:';
} else {
  $title           = 'Covid-19 test results';
  $no_result       = 'No confirmation found';
  $patient_name    = 'Patient name:';
  $date_request    = 'Registration date:';
  $ispolnitel      = 'Executor:';
  $workplace_name  = 'Analyzer:';
  $validator       = 'Validator:';
  $date_validation = 'Validation date:';
}
?>
  <main role="main" class="content">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><?php
            if (LOCALE == 'ru') {
              echo 'Главная';
            } else if (LOCALE == 'ua') {
              echo 'Головна';
            } else {
              echo 'Home';
            }
            ?></a>
        </li>
        <li class="breadcrumb-item"><span><?= $title ?></span></li>
      </ol>
      <div class="title"><?= ($results) ? $title : $no_result ?></div>
      <div class="results">
        <?php
        if ($results) {
          ?>
          <p><?= $patient_name ?> <span><?= $results[0]['patient_name'] ?></span></p>
          <p><?= $date_request ?>
            <span><?= ($results[0]['date_request'] != '0000-00-00') ? $results[0]['date_request'] : '' ?></span></p>
          <p><?= $ispolnitel ?> <span><?= $results[0]['ispolnitel'] ?></span></p>
          <p><?= $workplace_name ?> <span><?= $results[0]['workplace_name'] ?></span></p>
          <p><?= $validator ?> <span><?= $results[0]['validator'] ?></span></p>
          <p><?= $date_validation ?>
            <span><?= ($results[0]['date_validation'] != '0000-00-00 00:00:00') ? $results[0]['date_validation'] : '' ?></span>
          </p>
          <?php
        } ?>
      </div>
    </div>

  </main>

<?php get_footer(); ?>