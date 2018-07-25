<?php
session_start();
function is_logined(){

  if(empty($_SESSION['is_login']) == false){
    echo ("<script>change_form_logout2login()</script>");
    return true;
  }
  else{
    echo ("<script>change_form_login2logout()</script>");
    return true;
  }
}

function show_ranking(){
  $row_num = 1;
  $conn = mysqli_connect("localhost", "id6538259_root", "12301230", "id6538259_lyg");//웹호스팅시 비밀번호
  //$conn = mysqli_connect("localhost", "root", "12301230", "lyg");
  $sql_ranking_query = "
  SELECT  *
  FROM `player_record`
  ORDER BY `player_record`.`UMA` DESC
  ";
  $result_set = mysqli_query($conn, $sql_ranking_query) or die(mysqli_error($conn));
  while($row = mysqli_fetch_array($result_set)){
    $print_Name = $row['NAME'];

    $print_1st = mysqli_fetch_array(mysqli_query($conn,"
    SELECT COUNT('1st_name') as 1st
    FROM game_record
    WHERE game_record.1st_name='$print_Name'
    "))['1st'];

    $print_2nd = mysqli_fetch_array(mysqli_query($conn,"
    SELECT COUNT('2nd_name') as 2nd
    FROM game_record
    WHERE game_record.2nd_name='$print_Name'
    "))['2nd'];
    $print_3rd = mysqli_fetch_array(mysqli_query($conn,"
    SELECT COUNT('3rd_name') as 3rd
    FROM game_record
    WHERE game_record.3rd_name='$print_Name'
    "))['3rd'];

    $print_4th = mysqli_fetch_array(mysqli_query($conn,"
    SELECT COUNT('4th_name') as 4th
    FROM game_record
    WHERE game_record.4th_name='$print_Name'
    "))['4th'];
    $print_Game_Count = $print_1st+$print_2nd+$print_3rd+$print_4th;

    $temp_1st_score_sum = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.1st_score),0) as 1st_sum
    FROM game_record
    WHERE game_record.1st_name='$print_Name')
    "))['1st_sum'];
    $temp_2nd_score_sum = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.2nd_score),0) as 2nd_sum
    FROM game_record
    WHERE game_record.2nd_name='$print_Name')
    "))['2nd_sum'];
    $temp_3rd_score_sum = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.3rd_score),0) as 3rd_sum
    FROM game_record
    WHERE game_record.3rd_name='$print_Name')
    "))['3rd_sum'];
    $temp_4th_score_sum = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.4th_score),0) as 4th_sum
    FROM game_record
    WHERE game_record.4th_name='$print_Name')
    "))['4th_sum'];

    $print_Sum_Score = $temp_1st_score_sum+$temp_2nd_score_sum+$temp_3rd_score_sum+$temp_4th_score_sum;



    $temp_1st_star = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.1st_star),0) as 1st_star
    FROM game_record
    WHERE game_record.1st_name='$print_Name')
    "))['1st_star'];
    $temp_2nd_star = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.2nd_star),0) as 2nd_star
    FROM game_record
    WHERE game_record.2nd_name='$print_Name')
    "))['2nd_star'];
    $temp_3rd_star = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.3rd_star),0) as 3rd_star
    FROM game_record
    WHERE game_record.3rd_name='$print_Name')
    "))['3rd_star'];
    $temp_4th_star = mysqli_fetch_array(mysqli_query($conn,"
    (SELECT IFNULL(SUM(game_record.4th_star),0) as 4th_star
    FROM game_record
    WHERE game_record.4th_name='$print_Name')
    "))['4th_star'];



    $print_Star = $temp_1st_star+$temp_2nd_star+$temp_3rd_star+$temp_4th_star;

    $print_UMA = ($print_Sum_Score-($print_Game_Count*25000))/1000+($print_1st*30+$print_2nd*10-$print_3rd*10-$print_4th*30);


    if($print_Game_Count!=0){
      $print_Ave_Score = round($print_Sum_Score/$print_Game_Count,2);
      $print_Ave_UMA = round($print_UMA/$print_Game_Count,2);
    }
    else{
      $print_Ave_Score=0;
      $print_Ave_UMA=0;
    }



    echo "<script>
    print_result_into_cell('$row_num')
    print_result_into_cell('$print_Name')
    print_result_into_cell('$print_Ave_Score')
    print_result_into_cell('$print_Sum_Score')
    print_result_into_cell('$print_UMA')
    print_result_into_cell('$print_Star')
    print_result_into_cell('$print_Ave_UMA')
    print_result_into_cell('$print_1st')
    print_result_into_cell('$print_2nd')
    print_result_into_cell('$print_3rd')
    print_result_into_cell('$print_4th')
    print_result_into_cell('$print_Game_Count')
    </script>";
    $row_num++;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>
    마작기록사이트
  </title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="table.css">
</head>
<script>
var MAX_ROWS = 12;
var _index = 0;
var _rowcount = 1;

function getCookie(name){
  var wcname = name + '=';
  var wcstart, wcend, end;
  var i = 0;

  while(i <= document.cookie.length) {
    wcstart = i;
    wcend   = (i + wcname.length);
    if(document.cookie.substring(wcstart, wcend) == wcname) {
      if((end = document.cookie.indexOf(';', wcend)) == -1)
      end = document.cookie.length;
      return document.cookie.substring(wcend, end);
    }

    i = document.cookie.indexOf('', i) + 1;

    if(i == 0)
    break;
  }
  return '';
}

if(getCookie('record_site') != 'rangs') {
  window.open('pop_up_index.html','','width=380,height=300,top=0,left=0');
}

function login_ok() {
  var input_id = document.getElementById('loginid').value;
  var input_pw = document.getElementById('loginpw').value;
  if (input_id == "" || input_pw == "") {
    alert("아이디 또는 비밀번호를 입력하십시오.");
    return;
  }
  else{
    document.getElementById('login_form').submit();
  }
}

function check_admin() {
  var pass = prompt("최고관리자 비밀번호를 입력");
  super_pw_frm.location.href ="./check_super_admin.php?admin_pass="+pass;
}

function change_form_logout2login(){
  var logdiv = document.getElementById('loginform');
  logdiv.style.visibility = "hidden";
  var logeddiv = document.getElementById('loginedform');
  logeddiv.style.visibility = "visible";
}

function change_form_login2logout(){
  var logdiv = document.getElementById("loginform");
  logdiv.style.visibility = "visible";
  var logeddiv = document.getElementById("loginedform");
  logeddiv.style.visibility = "hidden";
}



function print_result_into_cell(record_result){
  var newDiv=document.createElement('DIV'); // DIV 객체 생성
  newDiv.setAttribute('class','divTableCell'); // class 지정
  newDiv.innerHTML=record_result; // 객체에 포함할 텍스트
  document.getElementsByClassName('divTableRow')[_rowcount].appendChild(newDiv); // row의 자식 노드로 첨부 (필수)
  _index ++;
  if(_index==MAX_ROWS){
    _index=0;
    var newRowDiv=document.createElement('DIV'); // DIV 객체 생성
    newRowDiv.setAttribute('class','divTableRow'); // id 지정
    document.getElementsByClassName('divTableBody')[0].appendChild(newRowDiv);
    _rowcount++;
  }
}

function join_room(){
  var room_no = prompt("방번호 입력");
  if(room_no>1000&&room_no<10000){
    window.open("http://tenhou.net/0/?"+room_no,"_blank","width=750,height=650,top=300,left=500");
  }
  else{
    alert("1000이상, 10000이하의 숫자 입력");
  }

}
</script>
<body>
  <h1><a class="title" href="index.php">MADE_BY_LYG</a></h1>
  <h2>메인 페이지</h2>
  <hr>
  <div class="grid1">
    <div class="adminlogin">
      <div class="loginedform" id="loginedform">
        <div class="login_manager_text_div">
          <?php
          if(isset($_SESSION['is_login'])==true){
            echo $_SESSION['admin_name'] . " 관리자님 로그인 되었습니다";
          }
          ?>
          <br>
        </div>
        <div class="wrapping_index_btn">
          <input type="button" name="score_reg" value="관리자메뉴" onclick="window.location.href='admin_page.php'">
          <input type="button" name="logout" value="로그아웃" onclick="location.href='logout.php'">
        </div>
        <hr>
      </div>
      <div class="loginform" id="loginform">
        <div class="admin_login_is_here_div">
          관리자 로그인
        </div>
        <form action="validate_login_page.php" accept-charset="utf-8" id="login_form" method="POST">
          <input type="text" placeholder="관리자 ID 입력" id="loginid" name="loginid"><br>
          <input type="password" id="loginpw" name="loginpw"><br>
          <input type="button" value="&nbsp&nbsp&nbsp 로그인 &nbsp&nbsp" name="loginok" onclick="login_ok()">
          <input type="button" value="관리자등록" name="reg_admin" onclick="check_admin()">
        </form>
        <hr>
      </div>
      <div class="sidemenu">
        <ul>
          <li class="vertical" onclick="window.open('index.php','_self')"><a class="vertical" >처음으로</a></li>
          <li class="vertical" onclick="window.open('search_record_user.html','_self')"><a class="vertical">전적검색</a></li>
          <li class="vertical" onclick="window.open('name_reg_page.php','_self')"><a class="vertical">닉네임 등록</a></li>
          <li class="vertical" onclick="window.open('float_chat.html','_blank', 'width=500,height=400, top=500, left=1000')"><a class="vertical">채팅방 열기</a></li>
          <li class="vertical" onclick="join_room()"><a class="vertical">게임방 들어가기</a></li>
        </ul>
      </div>
    </div>

    <div class="main_content">
      <div class="divTable blueTable">
        <div class="divTableHeading">
          <div class="divTableRow">
            <div class="divTableHead">순위</div>
            <div class="divTableHead">이름</div>
            <div class="divTableHead">평점</div>
            <div class="divTableHead">전체점수</div>
            <div class="divTableHead">우마</div>
            <div class="divTableHead">별</div>
            <div class="divTableHead">평우마</div>
            <div class="divTableHead">1등</div>
            <div class="divTableHead">2등</div>
            <div class="divTableHead">3등</div>
            <div class="divTableHead">4등</div>
            <div class="divTableHead">대국 수</div>
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

  <iframe id="super_pw_frm" scrolling="no" frameborder="no" width="0" height="0" name="super_pw_frm"></iframe>
  <?php
  is_logined();
  show_ranking();
  ?>
</body>

</html>
<!-- <table id="record">
<tr><td>등수</td><td>이름</td><td>평점</td><td style="width:120px">전체점수</td><td>우마</td><td>전체별</td><td>평순위</td><td style="width:50px">1등</td>
<td style="width:50px">2등</td><td style="width:50px">3등</td><td style="width:50px">4등</td><td>대국 수</td></tr>
<tr><td>1</td><td>2</td><td>3</td></tr>
<tr><td>4</td><td>5</td><td>6</td></tr>
<tr><td>7</td><td>8</td><td>9</td></tr>
<tr><td>10</td><td>11</td><td>12</td></tr>
</table> -->
