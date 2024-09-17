<?php
defined('s@>J$qw$i8_5rvY=6d{Z@!,V%J[J4Z^8C3q*bO$%/_db~iy6Fz=eTL/^O-@VKJU{E=U^x,JfooR19xKpgQ*,A/Dbg+9@>J1%.T[sL9#-4!-A8]t') or die('Доступ запрещён!');

function log_to_file_db($txt, $type = 'ERROR')
{
  $log_file_path = __DIR__  . '/../logs/db_error.log';
  $f = fopen($log_file_path, 'a');
  fwrite($f, date('Y-m-d H:i:s') . ' ' . $type . ' > ' . $txt . ' ; ' . PHP_EOL);
  fclose($f);
}

$data = date("Y-m-d H:i:s");

//----------------------------PDO---------------------------------------
$opt_p = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
  PDO::MYSQL_ATTR_FOUND_ROWS => true
];

try {
  $conn = new PDO('mysql:host=' . BD_HOST . ';dbname=' . BD_NAME . ';charset=utf8mb4', BD_USER, BD_PASS, $opt_p); //utf8mb4
  // $conn = new PDO('mysql:host=' . "localhost" . ';dbname=' . "project" . ';charset=utf8mb4', "root", "", $opt_p); //utf8mb4
} catch (PDOException $e) {
  log_to_file_db('Подключение не удалось: ' . $e->getMessage());
  die('Подключение не удалось: ' . $e->getMessage());
 
}

/*
Для группировки нескольких транзакций
если хоть в одной произойдет ошибка, остальные тоже откатятся
$conn->beginTransaction();
insert 1
insert 2
insert n

if(ok){
	//завершаем
	$conn->commit();
}else{
	//откатываем
	$conn->rollBack();
}
*/

/* 
//----------------------------MYSQL---------------------------------------
$conn = mysqli_connect(BD_HOST, BD_USER, BD_PASS, BD_NAME);
if (mysqli_connect_errno()) {
    die("Не удалось подключиться: %s\n", mysqli_connect_error());
}
mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET character_set_client = 'utf8'");
mysqli_query($conn, "SET character_set_connection = 'utf8'");
mysqli_query($conn, "SET character_set_results = 'utf8'"); 
*/


//-------------------------functions db-----------------------------
function selectId($table, $condition, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT `id` FROM $table WHERE $condition LIMIT 1");
  //$row = mysqli_fetch_assoc($sql);

  $stmt = $conn->prepare("SELECT `id` FROM $table WHERE $condition LIMIT 1");
  $stmt->execute($arr_param);
  $row = $stmt->fetch();
  if (!empty($row['id'])) {
    return $row['id'];
  } else {
    return false;
  }
}

function selectIdArr($table, $condition = 1, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT `id` FROM $table WHERE $condition");
  $stmt = $conn->prepare("SELECT `id` FROM $table WHERE $condition");
  $stmt->execute($arr_param);
  $all = [];
  while ($row = $stmt->fetch()) {
    $all[] = $row['id'];
  }
  return $all;
}

function selectColumn($table, $column, $condition, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT $column FROM $table WHERE $condition LIMIT 1");
  //$row = mysqli_fetch_assoc($sql);

  $stmt = $conn->prepare("SELECT $column FROM $table WHERE $condition LIMIT 1");
  $stmt->execute($arr_param);
  if ($row = $stmt->fetch()) {
    return $row;
  } else {
    return false;
  }
}

function selectColumnAll($table, $column, $condition = 1, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT $column FROM $table WHERE $condition");

  $stmt = $conn->prepare("SELECT $column FROM $table WHERE $condition");
  $stmt->execute($arr_param);
  if ($stmt) {
    $all = [];
    while ($row = $stmt->fetch()) {
      $all[] = $row;
    }
    return $all;
  } else {
    return [];
  }
}

function selectColumnAllOrder($table, $column, $condition, $arr_param, $order_by, $order = 'ASC')
{
  global $conn;
  $stmt = $conn->prepare("SELECT $column FROM $table WHERE $condition ORDER BY $order_by $order");
  $stmt->execute($arr_param);
  if ($stmt) {
    $all = [];
    while ($row = $stmt->fetch()) {
      $all[] = $row;
    }
    return $all;
  } else {
    return [];
  }
}

function selectColumnAllInnerJoin($table_field1, $table_field2, $table1, $table2, $condition, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT `table1`.`filed1`,`table1`.`filed2`, `table2`.`filed1`,`table2`.`filed2`, FROM `table1` INNER JOIN `table2` ON $condition");
  //$sql = mysqli_query($conn, "SELECT $table_field1, $table_field2 FROM $table1 INNER JOIN $table2 ON $condition");

  $stmt = $conn->prepare("SELECT $table_field1, $table_field2 FROM $table1 INNER JOIN $table2 ON $condition");
  $stmt->execute($arr_param);
  if ($stmt) {
    $all = [];
    while ($row = $stmt->fetch()) {
      $all[] = $row;
    }
    return $all;
  } else {
    return false;
  }
}

function selectCount($table, $column, $condition = 1, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT COUNT($column) FROM $table WHERE $condition");
  //$row = mysqli_fetch_row($sql);

  $stmt = $conn->prepare("SELECT COUNT($column) as `count` FROM $table WHERE $condition");
  $stmt->execute($arr_param);
  $row = $stmt->fetch();
  return (!empty((INT)$row['count'])) ? (INT)$row['count'] : 0;
}

function selectCountGroup($table, $column, $group, $condition = 1, $arr_param = [])
{
  global $conn;
  //$sql = mysqli_query($conn, "SELECT COUNT($column) FROM $table WHERE $condition");
  //$row = mysqli_fetch_row($sql);

  $stmt = $conn->prepare("SELECT COUNT($column) as `count`, `$group` FROM $table WHERE $condition GROUP BY `$group`");
  $stmt->execute($arr_param);
  if ($stmt) {
    $all = [];
    while ($row = $stmt->fetch()) {
      $all[$row[$group]] = $row['count'];
    }
    return $all;
  } else {
    return [];
  }
}

function updateColumn($table, $column, $condition = 1, $arr_param = [])
{
  global $conn;

  try {
    // $arr_param = del_js_code($arr_param);//trim js code
    $stmt = $conn->prepare("UPDATE $table SET $column WHERE $condition");
    $stmt->execute($arr_param);
    return $stmt;
//    return $stmt->rowCount();
    //return mysqli_query($conn, "UPDATE $table SET $column WHERE $condition");
  } catch (Exception $e) {
    $fields_for_log = [
      'table' => $table,
      'column' => $column,
      'condition' => $condition,
      'arr_param' => implode(',', $arr_param)
    ];

    log_to_file_db( 'updateColumn > ' . $e->getMessage() . ' > ' . implode('|', $fields_for_log) );
  }

  return false;
}

function updateColumnAll($update_sql, $arr_param = [])
{
  $arr_param = del_js_code($arr_param);//trim js code

  global $conn;
  $stmt = $conn->prepare($update_sql);
  $stmt->execute($arr_param);
  return $stmt;
  /*
  UPDATE `table` SET `uid` = CASE
    WHEN id = 1 THEN 2952
    WHEN id = 2 THEN 4925
    WHEN id = 3 THEN 1592
    ELSE `uid`
    END
  WHERE id  in (1,2,3)
  */
}

function insertTable($table, $column, $values, $arr_param = [], $ignore = false)
{
  global $conn;
  $ignore_bd = $ignore === true ? 'IGNORE' : '';

  try {
    //mysqli_query($conn, "INSERT $ignore_bd INTO $table ($column) Values $values");
    //$id_ins = mysqli_insert_id($conn);
    // $arr_param = del_js_code($arr_param);//trim js code

    $stmt = $conn->prepare("INSERT $ignore_bd INTO $table ($column) VALUES $values");
    $stmt->execute($arr_param);
    $id_ins = $conn->lastInsertId();
    if ($id_ins > 0) {
      return (INT)$id_ins;
    }
  } catch (Exception $e) {
    $fields_for_log = [
      'table' => $table,
      'column' => $column,
      'values' => $values,
      'arr_param' => (is_array($arr_param)) ? implode(',', $arr_param) : $arr_param,
      'ignore' => $ignore,
    ];
	
    log_to_file_db( 'insertTable > ' . $e->getMessage() . ' > ' . implode('|', $fields_for_log) );
  }

  return false;
}

function insertTableOnUpdate($table, $column_name, $column_val_insert, $column_val_update, $arr_param = [])
{
  global $conn;

  //INSERT INTO `tbl` (`id`, `name`, `age`) VALUES ('1', 'Helen', 24),('2', 'Katrina', 21) ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `age` = VALUES(`age`)
  $arr_param = del_js_code($arr_param);//trim js code

  $stmt = $conn->prepare("INSERT INTO $table ($column_name) VALUES $column_val_insert ON DUPLICATE KEY UPDATE $column_val_update");
  $stmt->execute($arr_param);
  $id_ins = $conn->lastInsertId();
  if ($id_ins > 0) {
    return (INT)$id_ins;
  } else {
    return $stmt;
  }
}

function insertTableCopy($table_new, $table_old, $column_new, $column_old, $condition, $arr_param = [])
{
  global $conn;

  try {
    //mysqli_query($conn, "INSERT INTO newTable (col1, col2, col3) SELECT column1, column2, column3 FROM oldTable WHERE $condition");
    //$id_ins = mysqli_insert_id($conn);

    $stmt = $conn->prepare("INSERT INTO $table_new ($column_new) SELECT $column_old FROM $table_old WHERE $condition");
    $stmt->execute($arr_param);
    $id_ins = $conn->lastInsertId();
    if ($id_ins > 0) {
      return (INT)$id_ins;
    }
  } catch (Exception $e) {
    $fields_for_log = [
      'sql' => "INSERT INTO $table_new ($column_new) SELECT $column_old FROM $table_old WHERE $condition",
    ];
	
    log_to_file_db( 'insertTable > ' . $e->getMessage() . ' > ' . implode('|', $fields_for_log) );
  }

  return false;
}

function deleteRow($table, $condition = 1, $arr_param = [])
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM $table WHERE $condition");
  $stmt->execute($arr_param);
  return $stmt;
  //return mysqli_query($conn, "DELETE FROM $table WHERE $condition");
}

function deleteWithCount($table, $condition = 1, $arr_param = [])
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM $table WHERE $condition");
  $stmt->execute($arr_param);

  if ($stmt->rowCount()) {
    return $stmt->rowCount();
  }

  return false;
}

function selectQuery($pstms, $param = [])
{
  global $conn;
  $stmt = $conn->prepare($pstms);
  $stmt->execute($param);
  if ($stmt) {
    $all = [];
    while ($row = $stmt->fetch()) {
      $all[] = $row;
    }
    return $all;
  } else {
    return [];
  }
}

function updateQuery($pstms, $param = [])
{
  global $conn;
  $stmt = $conn->prepare($pstms);
  $stmt->execute($param);
  if ($stmt->rowCount()) {
    return $stmt->rowCount();
  }

  return false;
}

//  Этот список должен учитывать параметры фильтрации (по участкам текущего объекта и по имени рабочего), плюс пагинации.
//  Также он должен быть отсортирован по времени создания по убыванию.
function selectTimeSheet($param)
{
  global $conn;

  $pstms =
    "with B as (select max(id) as last_id from time_sheet where object_id = :object_id group by worker_id)" .
    " select SQL_CALC_FOUND_ROWS TS.id, TS.worker_id, R.fio, R.doljn, R.sector_id, TS.ts," .
    " concat(TIME_FORMAT(R.smena_s, '%H:%i'), '-', TIME_FORMAT(R.smena_do, '%H:%i')) as workShift," .
    " (select name from sector where id = TS.sector_id) as sector_name" .
    " from B" .
    " inner join time_sheet TS on B.last_id = TS.id" .
    " and TS.is_start = 1" .
    " inner join users_rab R on TS.worker_id = R.id" .
    (isset($param['sector_id']) ? " and R.sector_id = :sector_id" : "") .
    (isset($param['fio_mask']) ? " and upper(R.fio) like :fio_mask" : "") .
    " order by TS.ts DESC" .
    (isset($param['limit']) ? " limit :limit" : "") .
    (isset($param['offset']) ? " offset :offset" : "");

  $stmt = $conn->prepare($pstms);
  $stmt->execute($param);
  if ($stmt) {
    $data = [];
    while ($row = $stmt->fetch()) {
      $data[] = [
        'id' => $row['id'],
        'workerId' => $row['worker_id'],
        'workerName' => $row['fio'],
        'position' => $row['doljn'],
        'sector' => $row['sector_name'],
        'startsAs' => $row['ts'],
        'workShift' => $row['workShift']
      ];
    }

    $count = $conn->query("SELECT FOUND_ROWS()")->fetchColumn();

    return [
      'count' => $count,
      'data' => $data
    ];
  } else {
    return [];
  }
}
