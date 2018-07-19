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
  <title>닉네임 등록 페이지</title>
</head>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="table.css?ver=2">
</head>
<script>
var is_check_dupe=false;
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
  var pass = prompt("관리자 비밀번호를 입력");
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

function check_name(){
  if(document.getElementById("user_name").value==""){
    alert("이름을 입력하지 않았습니다");
    return document.getElementById("user_name").focus();
  }
  else{
    var tempname = document.getElementById("user_name").value;
    dupe_frm2.location.href ="./check_name_dupe.php?user_name="+tempname;
    if(is_check_dupe==true){
      document.getElementById('dupe_confirm_btn').disabled = true;
    }
  }
}

function check_name_submit(){
  if(document.getElementById("user_name")==""){
    alert("이름을 입력하지 않았습니다!");
    return document.getElementById("user_name").focus();
  }
  else if(is_check_dupe==false){
    alert("중복확인 해주세요!");
  }
  else{
    document.getElementById("name_reg_form").submit();
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
          <li><a class="vertical" href="name_reg_page.php"><span style="color :red;">닉네임 등록</span></a></li>
        </ul>
      </div>
    </div>
    <div class="main_content">
      <div class="reg">
        <form action="name_reg.php" method="post" id="name_reg_form" name="name_reg_form">
          <fieldset>
            <legend>닉네임 등록</legend>
            <label for="user_name">이름:<input type="text" id="user_name" name="user_name"></label>
            <input type="button" id="dupe_confirm_btn" value="중복확인" onclick="check_name()"><br>
            <input type="button" value="확인" id="name_confirm_btn" name="name_confirm_btn" onclick="check_name_submit()">
          </fieldset>
        </form>
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
  <iframe id="dupe_frm2" scrolling="no" frameborder="no" width="0" height="0" name="dupe_frm2"></iframe>
  <?php
  is_logined();
  ?>
</body>
</html>
