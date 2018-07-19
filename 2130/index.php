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
  $conn = mysqli_connect("localhost", "root", "picopica", "lyg");
  $sql_ranking_query = "
  SELECT  *
  FROM `player_record`
  ORDER BY `player_record`.`UMA` DESC
  ";
  $result_set = mysqli_query($conn, $sql_ranking_query) or die(mysqli_error($conn));
  while($row = mysqli_fetch_array($result_set)){


    $print_Name = $row['NAME'];
    $print_Ave_Score = $row['AVE_SCORE'];
    $print_Sum_Score = $row['SUM_SCORE'];
    $print_UMA = $row['UMA'];
    $print_Star = $row['STAR'];
    $print_Ave_UMA = $row['AVE_UMA'];
    $print_1st = $row['1ST'];
    $print_2nd = $row['2ND'];
    $print_3rd = $row['3RD'];
    $print_4th = $row['4TH'];
    $print_Game_Count = $row['GAME_COUNT'];

    echo "<script>
    print_result_into_cell($row_num)

    print_result_into_cell($print_Name)
    print_result_into_cell($print_Ave_Score)
    print_result_into_cell($print_Sum_Score)
    print_result_into_cell($print_UMA)

    print_result_into_cell($print_Star)
    print_result_into_cell($print_Ave_UMA)
    print_result_into_cell($print_1st)
    print_result_into_cell($print_2nd)

    print_result_into_cell($print_3rd)
    print_result_into_cell($print_4th)
    print_result_into_cell($print_Game_Count)

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
    내가 만드는 기록사이트
  </title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="table.css">
</head>
<script>
var MAX_ROWS = 12;
var _index = 0;
var _rowcount = 1;

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


</script>

<body>
  <h1><a class="title" href="index.php">0.0.1</a></h1>
  <hr>
  <div class="grid1">
    <div class="adminlogin">
      <div class="loginedform" id="loginedform">
        <?php
        if(isset($_SESSION['is_login'])==true){
          echo $_SESSION['admin_name'] . " 관리자님 로그인 되었습니다";
        }
        ?>
        <br>
        <input type="button" name="score_reg" value="관리자메뉴" onclick="window.location.href='admin_page.html'">
        <input type="button" name="logout" value="로그아웃" onclick="location.href='logout.php'">
      </div>
      <div class="loginform" id="loginform">
        <form action="validate_login_page.php" accept-charset="utf-8" id="login_form" method="POST">
          <input type="text" placeholder="관리자 ID 입력" id="loginid" name="loginid"><br>
          <input type="password" id="loginpw" name="loginpw"><br>
          <input type="button" value="&nbsp&nbsp&nbsp 로그인 &nbsp&nbsp" name="loginok" onclick="login_ok()">
          <input type="button" value="관리자등록" name="reg_admin" onclick="check_admin()">
        </form>
      </div>
      <hr>
      <div class="sidemenu">
        <ul>
          <li><a class="vertical" href="index.php">처음으로</a></li>
          <li><a class="vertical" href="search_record_user.html">전적검색</a></li>
          <li><a class="vertical" href="name_reg_page.php">닉네임 등록</a></li>
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
        <li class="horizen">가로메뉴 연습</li>
        <li class="horizen">young2too13@gmail.com</li>
        <li class="horizen">Tel 010-123-1234</li>
        <li class="horizen">ver 0.0.1</li>
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
