<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);
  $errors['bdate'] = !empty($_COOKIE['bdate_error']);
  $errors['superpowers'] = !empty($_COOKIE['superpowers_error']);
  $errors['data_saved'] = !empty($_COOKIE['save_error']);

  // Массив для временного хранения сообщений пользователю.
  $messages = array();
  $messages['name'] = '';
  $messages['email'] = '';
  $messages['gender'] = '';
  $messages['limbs'] = '';
  $messages['bio'] = '';
  $messages['checkbox'] = '';
  $messages['superpowers'] = '';
  $messages['bdate'] = '';
  $messages['data_saved'] = '';

  // Выдаем сообщения об ошибках.
  if ($errors['name'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages['name'] = 'Заполните имя';
  }
  else if ($errors['name'] == '2') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages['name'] = 'Используйте латинский алфавит или "-"';
  }
  if ($errors['email'] == '1') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages['email'] = 'Заполните email';
  }
  else if ($errors['email'] == '2') {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('email_error', '', 100000);
    // Выводим сообщение.
    $messages['email'] = 'Заполните email в формате test@test.com используя английский алфавит и цифры';
  }
  if ($errors['limbs']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('limbs_error', '', 100000);
    // Выводим сообщение.
    $messages['limbs'] = 'Заполните число конечностей';
  }
  if ($errors['gender']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('gender_error', '', 100000);
    // Выводим сообщение.
    $messages['gender'] = 'Заполните пол';
  }
  if ($errors['bio']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bio_error', '', 100000);
    // Выводим сообщение.
    $messages['bio'] = 'Заполните биографию';
  }
  if ($errors['superpowers']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('superpowers_error', '', 100000);
    // Выводим сообщение.
    $messages['superpowers'] = 'Нелегальная сверхспособность';
  }
  if ($errors['bdate']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('bdate_error', '', 100000);
    // Выводим сообщение.
    $messages['bdate'] = 'Выберите год рождения';
  }
  if ($errors['checkbox']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('checkbox_error', '', 100000);
    // Выводим сообщение.
    $messages['checkbox'] = 'Согласитесь';
  }
  if ($errors['data_saved']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save_error', '', 100000);
    $messages['data_saved'] = "Ошибка отправки: " . $_COOKIE['save_error'];
  }

  // Выдаем сообщение об успешном сохранении.
  if (array_key_exists('save', $_GET) && $_GET['save']) {
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages['data_saved'] = 'Спасибо, результаты сохранены.';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['bdate'] = empty($_COOKIE['bdate_value']) ? '' : $_COOKIE['bdate_value'];
  $superpowers = empty($_COOKIE['superpowers_value']) ? array() : json_decode($_COOKIE['superpowers_value'], true);
  $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (!preg_match("/[\w-]+/i", $_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if (!preg_match("/[a-z0-9]+@[a-z0-9]+\.[a-z]+/i", $_POST['email'])) {
    // Выдаем куку на день с флажком об ошибке в поле email.
    setcookie('email_error', '2', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['gender'])) {
    // Выдаем куку на день с флажком об ошибке в поле gender.
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['limbs']) && $_POST['limbs'] !== '0') {
    // Выдаем куку на день с флажком об ошибке в поле limbs.
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['bio'])) {
    // Выдаем куку на день с флажком об ошибке в поле bio.
    setcookie('bio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['checkbox'])) {
    // Выдаем куку на день с флажком об ошибке в поле checkbox.
    setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['bdate'])) {
    // Выдаем куку на день с флажком об ошибке в поле bdate.
    setcookie('bdate_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bdate_value', $_POST['bdate'], time() + 30 * 24 * 60 * 60);
  }
  if (!empty($_POST['superpowers']) && !preg_match("/Бессмертие|Прохождение сквозь стены|Левитация/", implode(",", $_POST['superpowers']))) {
    // Выдаем куку на день с флажком об ошибке в поле superpowers.
    setcookie('superpowers_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('superpowers_value', json_encode($_POST['superpowers']), time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('bdate_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('superpowers_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('checkbox_error', '', 100000);
  }

  // Сохранение в XML-документ.
  try {
    $user = 'u41031';
    $pass = '1232344';
    $db = new PDO('mysql:host=localhost;dbname=u41031', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $stmt1 = $db->prepare("INSERT INTO form (name, email, bdate, gender, limbs, bio) SET name = ?, email = ?, bdate = ?, gender = ?, limbs = ?, bio = ?");
    $stmt1 -> execute([
      $_POST['name'],
      strtolower($_POST['email']),
      $_POST['bdate'],
      $_POST['gender'],
      $_POST['limbs'],
      $_POST['bio']
    ]);
    $stmt2 = $db->prepare("INSERT INTO super (id, ability) SET id = ?, ability = ?");
    $id = $db->lastInsertId();
    foreach ($_POST['superpowers'] as $s)
      $stmt2 -> execute([$id, $s]);
  }
  catch (PDOException $e) {
    setcookie('save_error', '$e->getMessage()', 100000);
    header('Location: index.php');
    exit();
  }

  // Делаем перенаправление.
  header('Location: index.php?save=1');
}
?>