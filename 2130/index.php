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
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>
    내가 만드는 기록사이트
  </title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="table.css?ver=1">
</head>
<script>


function login_ok() {
  var input_id = document.getElementById('loginid');
  var input_pw = document.getElementById('loginpw');
  if (input_id == "" || input_pw == "") {
    alert("아이디 또는 비밀번호를 입력하십시오.");
  }
  else{
    document.getElementById('loginform').submit();
  }
}

function check_admin() {
  var pass = prompt("관리자 비밀번호를 입력");
  console.log("%s",pass);
  if (pass == "1230") {
    alert("관리자 인증되었습니다");
    window.open("admin_reg_page.html");
  } else {
    alert("틀렸습니다");
  }
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
        <input type="button" name="logout" value="점수등록" onclick="window.location.href='admin_page.html'">
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
          <li><a class="vertical" href="">Home</a></li>
          <li><a class="vertical" href="">Home2</a></li>
          <li><a class="vertical" href="">Home3</a></li>
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
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell_name">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
          </div>
          <div class="divTableRow">
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell_name">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
          </div>
          <div class="divTableRow">
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell_name">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
          </div>
          <div class="divTableRow">
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell_name">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
            <div class="divTableCell">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="footer">
    <nav>
      <ul>
        <li class="horizen">Menu1</li>
        <li class="horizen">Menu2</li>
        <li class="horizen">Menu3</li>
        <li class="horizen">Menu4</li>
      </ul>
    </nav>
  </div>
  <?php
    is_logined();
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
