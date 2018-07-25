<?php
session_start();

function start_search(){
  $search_name = $_POST['name_4_search'];//찾는 이름
  $start_date = $_POST['date_4_search_start'];//날짜의 시작
  $end_date = $_POST['date_4_search_end'];//날짜의 끝
  //$conn = mysqli_connect("localhost", "id6538259_root", "12301230", "id6538259_lyg");
  $conn = mysqli_connect("localhost", "root", "12301230", "lyg");
  //db 연결하

  if(empty($search_name) == true){//이름이 공란이라면 날짜만으로 검색
    $sql_query = "
    SELECT *
    FROM game_record
    WHERE DATE BETWEEN '$start_date' and '$end_date'
    ";
  }
  else{//이름이 공란이 아니라면 날짜와 and 조건으로 검색
    echo "<script>_player_name='$search_name'</script>";
    $sql_query = "
    SELECT *
    FROM game_record
    WHERE (DATE BETWEEN '$start_date' and '$end_date')
    and (1st_name = '$search_name'
    or 2nd_name = '$search_name'
    or 3rd_name = '$search_name'
    or 4th_name = '$search_name')";
  }
  $result_set = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
  $max = mysqli_num_rows($result_set);
  while($row = mysqli_fetch_array($result_set)){

    $print_game_id = $row['game_id'];
    $print_1st_name = $row['1st_name'];
    $print_2nd_name = $row['2nd_name'];
    $print_3rd_name = $row['3rd_name'];
    $print_4th_name = $row['4th_name'];

    $print_1st_score = $row['1st_score'];
    $print_2nd_score = $row['2nd_score'];
    $print_3rd_score = $row['3rd_score'];
    $print_4th_score = $row['4th_score'];

    $print_1st_star = $row['1st_star'];
    $print_2nd_star = $row['2nd_star'];
    $print_3rd_star = $row['3rd_star'];
    $print_4th_star = $row['4th_star'];

    $date = date_create($row['Date']);
    $print_date = date_format($date,"y-m-d");

    echo "<script>
    print_result_into_cell($print_game_id)

    print_result_into_cell('$print_1st_name')
    print_result_into_cell('$print_2nd_name')
    print_result_into_cell('$print_3rd_name')
    print_result_into_cell('$print_4th_name')

    print_result_into_cell($print_1st_score)
    print_result_into_cell($print_2nd_score)
    print_result_into_cell($print_3rd_score)
    print_result_into_cell($print_4th_score)

    print_result_into_cell($print_1st_star)
    print_result_into_cell($print_2nd_star)
    print_result_into_cell($print_3rd_star)
    print_result_into_cell($print_4th_star)

    print_result_into_cell('$print_date')
    </script>";
  }


}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>검색결과 페이지</title>
</head>
<link rel="stylesheet" href="table.css?ver=0">
<link rel="stylesheet" href="style.css?ver=1">

<script>
var MAX_ROWS = 14;
var _index = 0;
var _rowcount = 1;
var _login_check = false;
var _player_name = "";

function print_result_into_cell(record_result){


  var newDiv=document.createElement('DIV'); // DIV 객체 생성
  newDiv.setAttribute('class','divTableCell'); // class 지정
  if(_index == 0){
    newDiv.setAttribute('id','div_cell_'+_rowcount);
  }
  if(_player_name!=""&&record_result==_player_name){
    newDiv.innerHTML="<b><font color=red>"+record_result+"</b>";
  }
  else{

    newDiv.innerHTML=record_result; // 객체에 포함할 텍스트
  }
  document.getElementsByClassName('divTableRow')[_rowcount].appendChild(newDiv); // _rowcount번쨰 row의 자식 노드로 첨부


  _index ++;
  if(_index==MAX_ROWS){
    if(_login_check==true){//관리자라면 삭제버튼 끝에 추가
      var newBtn=document.createElement('BUTTON');
      var btn_connect_id_cell = document.getElementById('div_cell_'+_rowcount).innerHTML;//버튼과 같은 줄의 이름 셀의 내용을 복사
      newBtn.setAttribute('class', 'delete_btn'+_rowcount);
      newBtn.setAttribute('onclick',"location.href='delete_clicked_record.php?div_cell_"+_rowcount+"="+btn_connect_id_cell+"&rowcount="+_rowcount+"'");
      newBtn.innerHTML="삭제";
      document.getElementsByClassName('divTableRow')[_rowcount].appendChild(newBtn);
    }
    _index=0;

    var newRowDiv=document.createElement('DIV'); // DIV 객체 생성
    newRowDiv.setAttribute('class','divTableRow'); // id 지정
    document.getElementsByClassName('divTableBody')[0].appendChild(newRowDiv);
    _rowcount++;//행말이 될 때마다 테이블몸뚱아리에 하나씩 추가
  }
}
function sidememu_user_or_manager(){
  if(_login_check == false){
      document.getElementById('1st').innerHTML="<a class='vertical' href='index.php'>처음으로</a>";
      document.getElementById('2nd').innerHTML="<span style='color :red;'>전적검색</span>";
      document.getElementById('3rd').innerHTML="<a class='vertical' href='name_reg_page.php'>닉네임 등록</a>";
      document.getElementById('4th').style.visibility='hidden';
  }
}
</script>
<body>
  <h1><a class="title" href="index.php">MADE_BY_LYG</a></h1>
  <h2>검색결과 페이지</h2>
  <hr>
  <div class="wrap_search_record">
    <div class="sidemenu">
      <ul type="">
        <li class="vertical" onclick="window.open('admin_page.php','_self')" id="1st"><a class="vertical">전적등록</a></li>
        <li class="vertical" id="2nd"><span style="color :red;">전적삭제</span></li>
        <li class="vertical" onclick="window.open('refresh_player_record.php','_self')" id="3rd">전적 불러오기(천봉)</li>
        <li class="vertical" onclick="window.open('index.php','_self')" id="4th"><a href="index.php">처음으로</a></li>
      </ul>
    </div>
    <div class="search_table_content">
      <div class="divTable blueTable">
        <div class="divTableHeading">
          <div class="divTableRow">
            <div class="divTableHead">game_id</div>
            <div class="divTableHead">1등</div>
            <div class="divTableHead">2등</div>
            <div class="divTableHead">3등</div>
            <div class="divTableHead">4등</div>
            <div class="divTableHead">1등 점수</div>
            <div class="divTableHead">2등 점수</div>
            <div class="divTableHead">3등 점수</div>
            <div class="divTableHead">4등 점수</div>
            <div class="divTableHead">1등 별</div>
            <div class="divTableHead">2등 별</div>
            <div class="divTableHead">3등 별</div>
            <div class="divTableHead">4등 별</div>
            <div class="divTableHead">일시</div>
          </div>
        </div>
        <div class="divTableBody">
          <div class="divTableRow">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <nav>
      <ul>
        <li class="horizen" onclick="window.open('index.php','_self')">처음으로</li>
        <li class="horizen">young2too13@gmail.com</li>
        <li class="horizen">Tel 010-123-1234</li>
        <li class="horizen">ver MADE_BY_LYG</li>
      </ul>
    </nav>
  </div>
  <?php
  if(empty($_SESSION['is_login']) == false){
    echo "<script>_login_check = true;</script>";
  }
  start_search();
  ?>
</body>
<script>
  sidememu_user_or_manager();
</script>
</html>
