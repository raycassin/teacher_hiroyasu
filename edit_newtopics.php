<?php
session_start();
if(!isset($_SESSION['key'])){header("Location: https://tagency.jp/edit/index.html");}
if(isset($_GET['site_ad'])){$_SESSION['site_ad']=htmlspecialchars($_GET['site_ad']);}
if(isset($_GET['editpagename'])){$_SESSION['editpagename']=htmlspecialchars($_GET['editpagename']);}
?>
<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0"> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8">


<style type="text/css">
body{
}
.box1 {
padding:15px 0px 15px 15px;
width:800px;
background-color: #cccccc;
font-size:12px;
}

.centering{
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
	background-color: #F2F2F2;
}
.text_box{
  width: 500px;
  height: 500px;
	padding:30px;
	background-color: #ffffff;
}
</style>



</head>
<body>

<div class="centering">
<div class="text_box">
<h1>新規記事作成</h1>

<form id="contact-form" action="edit_newtopics2.php" method="post">
<p>
<label for="kanso">●タイトル</label><br>
<input type="text" name="title" size="40" maxlength="30" placeholder="ニュースタイトル（最大文字数30文字）">
</p>

<p>
<label for="kanso">●記事日付</label><br>

<label for="language">年:</label>
<select id="language" name="year">
<option value="2020">2020</option>
<option value="2021">2021</option>
<option value="2022">2022</option>
<option value="2023">2023</option>
<option value="2024">2024</option>
<option value="2025">2025</option>
</select>　
<label for="language">月:</label>
<select name="month">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>　
</select>
<label for="language">日:</label>
<select name="day">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
</select>
</p>

<p>
<label for="kanso">●記事本文</label><br>
<textarea id="kanso" name="txt" cols="50" rows="6" maxlength="1000" placeholder="ニュース記事本文"></textarea>
</p>


<p>
<input type="submit" value="送信する">
</p>
</form>
</div>
</div>

<a href="index.html">管理画面に戻る</a>
</body>
</html>
