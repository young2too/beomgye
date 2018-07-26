<?php
function get_info_from_db(){
  $conn = mysqli_connect("localhost", "root", "12301230", "lyg");
  //$conn = mysqli_connect("localhost", "id6538259_root", "12301230","id6538259_lyg");
  $query_str = "
  SELECT NAME
  FROM player_record
  ";

  $result_set = mysqli_query($conn, $query_str);
  while($row=mysqli_fetch_array($result_set)){
    $name_input = $row['NAME'];
    echo "<script>make_dropdown('$name_input');</script>";
  }
}

function calc_player2_first_rate($p1_min,$name,$DBcon){
  $sql_get_min_date_query="
  SELECT MIN(Date) as md
  FROM game_record
  WHERE 1st_name='$name'
  or 2nd_name='$name'
  or 3rd_name='$name'
  or 4th_name='$name'
  ";

  $p2_min = mysqli_fetch_array(mysqli_query($DBcon,$sql_get_min_date_query))['md'];

  $p2_result = 0;

  if(strtotime($p2_min)<=strtotime($p1_min)){
    $p2_result += calc_rating_by_date($p2_min,$name,$DBcon);
    $p2_min = date("Y-m-d", strtotime($p2_min."+1day"));
  }
  return $p2_result;

}

//날짜를 인수로 그 날짜의 레이팅변화량을 구하는 함수
function calc_rating_by_date($date,$name,$DBcon){
  $game_count_on_date = mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT COUNT(*) as GC
  FROM game_record
  WHERE (1st_name='$name'
  or 2nd_name='$name'
  or 3rd_name='$name'
  or 4th_name='$name')
  and Date='$date'
  "))['GC'];


  $temp_1st_sum=mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT IFNULL(SUM(game_record.1st_score),0) as 1sum
  FROM game_record
  WHERE game_record.1st_name='$name'
  and game_record.Date='$date'
  "))['1sum'];

  $temp_2nd_sum=mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT IFNULL(SUM(game_record.2nd_score),0) as 2sum
  FROM game_record
  WHERE game_record.2nd_name='$name'
  and Date='$date'
  "))['2sum'];

  $temp_3rd_sum=mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT IFNULL(SUM(game_record.3rd_score),0) as 3sum
  FROM game_record
  WHERE game_record.3rd_name='$name'
  and Date='$date'
  "))['3sum'];

  $temp_4th_sum=mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT IFNULL(SUM(game_record.4th_score),0) as 4sum
  FROM game_record
  WHERE game_record.4th_name='$name'
  and Date='$date'
  "))['4sum'];

  $sum_score = $temp_1st_sum+$temp_2nd_sum+$temp_3rd_sum+$temp_4th_sum;

  $temp_1st = mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT COUNT('1st_name') as 1st
  FROM game_record
  WHERE game_record.1st_name = '$name'
  and game_record.Date = '$date'
  "))['1st'];

  $temp_2nd = mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT COUNT('2nd_name') as 2nd
  FROM game_record
  WHERE game_record.2nd_name = '$name'
  and game_record.Date = '$date'
  "))['2nd'];

  $temp_3rd = mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT COUNT('3rd_name') as 3rd
  FROM game_record
  WHERE game_record.3rd_name = '$name'
  and game_record.Date = '$date'
  "))['3rd'];

  $temp_4th = mysqli_fetch_array(mysqli_query($DBcon,"
  SELECT COUNT('4th_name') as 4th
  FROM game_record
  WHERE game_record.4th_name = '$name'
  and game_record.Date = '$date'
  "))['4th'];

  $result = (($sum_score - 25000*$game_count_on_date)/1000)+$temp_1st*30 + $temp_2nd*10 - $temp_3rd*10 - $temp_4th*30;

  return $result;
}

function get_data_from_db(){
  $conn = mysqli_connect("localhost", "root", "12301230", "lyg");
  //$conn = mysqli_connect("localhost", "id6538259_root", "12301230","id6538259_lyg");

  $p1_name = $_GET['p1_name'];
  $p2_name = $_GET['p2_name'];
  $start_date = $_GET['std'];

  echo "<script>player1_name='$p1_name'</script>";
  echo "<script>start_date='$start_date'</script>";

  echo "<script>push_array_set('Date','$p1_name','$p2_name');</script>";//첫쨰 행 날짜-p1-p2로 초기화 앞으로 넣을 데이터는 이 포맷을 만족

  $init1_value = calc_rating_by_date($start_date,$p1_name,$conn);
  $init2_value = calc_player2_first_rate($start_date,$p2_name,$conn);

  $rating_array = array();
  array_push($rating_array,[$start_date,$init1_value,$init2_value]);
  while(strtotime($start_date)<=strtotime(date('y-m-d'))){
    $start_date = date("Y-m-d", strtotime($start_date."+1day"));
    $init1_value += calc_rating_by_date($start_date,$p1_name,$conn);
    $init2_value += calc_rating_by_date($start_date,$p2_name,$conn);
    array_push($rating_array,[$start_date,$init1_value,$init2_value]);
  }

  for($i=0;$i<count($rating_array);$i++){
    $date = $rating_array[$i][0];
    $rate1 = $rating_array[$i][1];
    $rate2 = $rating_array[$i][2];
    echo "<script>push_array_set('$date',$rate1,$rate2)</script>";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>상대전적</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">

  var draw_array = new Array();
  var player1_name;
  var player2_name;
  var start_date;

  function set_p2_data(p2){
    player2_name=p2;

    window.open('Relative_Rating_chart.php?p1_name='+player1_name+'&p2_name='+player2_name+'&std='+start_date,'_self');
  }

  function push_array_set(date,p1,p2){
    sub_arr = new Array();
    sub_arr.push(date);
    sub_arr.push(p1);
    sub_arr.push(p2);
    draw_array.push(sub_arr);
  }

  function drawChart() {
    var data = google.visualization.arrayToDataTable(
      draw_array
    );

    var options = {
      title: '상세 전적',
      curveType: 'function',
      vAxis : {title : '레이팅'},
      hAxis : {title : '날짜', textPosition : 'none'},
      pointSize : 5,
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
  }

  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function make_dropdown(name){
    var x = document.getElementsByClassName('find_another_user_select');
    var i = 0;
    var option = document.createElement("OPTION");
    option.text=name;
    x[0].add(option);
  }
  </script>
</head>
<body>
  <div class="wrap_content">
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
    <div class="another_player">
      상대 전적 비교 :
      <select class="find_another_user_select" name="find_another" id="player2">
        <option value="" selected = true></option>
      </select>
      <input type="button" name="confirm" value="확인" onclick="set_p2_data(document.getElementById('player2').value)">
    </div>
  </div>

  <?php
  get_data_from_db();//차트를 만들기 위해 db의 데이터를 받아오는 함수
  get_info_from_db();//콤보박스를 채우는 php함수
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
    $('.find_another_user_select').select2({
      placeholder:"이름 선택",
      allowClear :true
    });
  });</script>

</body>
</html>
