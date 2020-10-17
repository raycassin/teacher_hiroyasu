<?php
    function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
    }

    session_start();
    // セッション情報の保存
    if ( isset ( $_POST['title']) ) {$_SESSION['title'] = $_POST['title'];}
    if ( isset ( $_POST['year']) ) {$_SESSION['year'] = $_POST['year'];}
    if ( isset ( $_POST['month']) ) {$_SESSION['month'] = $_POST['month'];}
    if ( isset ( $_POST['day']) ) {$_SESSION['day'] = $_POST['day'];}
    if ( isset ( $_POST['txt']) ) {$_SESSION['txt'] = $_POST['txt'];}

    // セッション情報の取得
    $title = h($_SESSION['title']);
    $day = h($_SESSION['year']) ."/". h($_SESSION['month'])."/" . h($_SESSION['day']);
    $txt = h($_SESSION['txt']);
    
    
    
    
    
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
<form>
<p>

送信しました
</p>


<p>
        <a href="index.html">
            <button type="button">トップに戻る</button>
        </a>
</p>

</div>
</div>

<a href="index.html">管理画面に戻る</a>
</body>
</html>
