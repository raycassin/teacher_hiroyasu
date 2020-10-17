<?php
session_start();

if( isset($_COOKIE['cookieA']['visitcount']) ){ $visit = $_COOKIE['cookieA']['visitcount'];} else{$visit = 0;}
$visit++; // カウント値+1

if( isset($_COOKIE['cookieA']['pcname']) ){
	$pcname=$_COOKIE['cookieA']['pcname'];
	}else{
	$chrs = "abcdefghijklmnopqrstuvwxyz0123456789";
	$chrs_ar = "abcdefghijklmnopqrstuvwxyz";
	$ch = "";
	$ch1 = "";
	for ($i=0; $i<6; $i++) $ch .= $chrs[mt_rand(0, strlen($chrs)-1)];
	for ($i=0; $i<2; $i++) $ch1 .= $chrs_ar[mt_rand(0, strlen($chrs_ar)-1)];
	$pcname=$ch1."_".$ch;
}

$name = "1";
$mail ="2@";
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ua = "";
$ua = $ua;
$expire = time() + 15 * 60;

setcookie('cookieA[visitcount]', $visit,$expire);
setcookie('cookieA[pcname]', $pcname,$expire);
setcookie('cookieA[mail]', $mail,$expire);
setcookie('cookieA[host]', $host,$expire);
setcookie('cookieA[ua]', $ua,$expire);
?>
<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0"> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
$id="tagency";
$pw="2001";

function line1($b){
$flag1 = $b;
echo <<<LOGINFORM
<div style="text-align:center">
<p>管理画面</p>$flag1
<form action="{$_SERVER["PHP_SELF"]}" method="POST">
		<table align="center">
		<tr>
		<td>ユーザー名</td><td width="120px"><input type="text" name="id" size="18" style="width:150px;"></td>
		</tr>
		<tr>
		<td>パスワード</td><td width="120px"><input type="password" name="pw" size="18" style="width:150px;"></td>
		</tr>
		<tr>
		<td colspan="2" style="text-align:right;"><input type="submit" name="login" value="ログイン"></td>
		</tr>
		</table>
	</form>
</div>
LOGINFORM;
}

function line2(){
echo <<<LOGINFORM
■ライバーニュースページ編集<br />
<a href="edit_newtopics.php?editpagename=toppage&site_ad=http://ichida-clinic.com/">新規作成</a><br />
<a href="edit_topics.php?editpagename=toppage&site_ad=http://ichida-clinic.com/">記事一覧から編集</a><br />
<a href="edit_topics.php?editpagename=toppage&site_ad=http://ichida-clinic.com/">記事削除</a><br />
<br />
<a href="img.php">画像管理</a><br />
<br />
<br />
<br />
<a href="{$_SERVER["PHP_SELF"]}?logout=on">ログアウト</a><br />
LOGINFORM;
}

$login_id=htmlspecialchars(@$_POST["id"]);
$login_pw=htmlspecialchars(@$_POST["pw"]);



if(isset($_GET["logout"])){
$_SESSION= array();
session_destroy();
echo <<<LOGINFORM
<a href="{$_SERVER["PHP_SELF"]}">login</a><br />
LOGINFORM;
}

if(empty($login_id) && empty($login_pw)&& empty($_SESSION['key'])&&!isset($_GET["logout"])){
$flag1="<p></p>";
line1($flag1);
}else{
//if(!empty($login_id) && !empty($login_pw)){
if(isset($_POST["id"])&&isset($_POST["pw"])){
if(@$login_pw==$pw && $login_id==$id){
if(empty($_SESSION['key'])){$_SESSION['key']= mt_rand();}
}else{ 
$flag1="<p style=\"color:red;\">誤りがあります</p>";
line1($flag1);
}
}}

if(isset($_SESSION['key'])){
echo line2();
}

?>

<br />
<br />
<a href="http://tagency.jp/">http://tagency.jp/</a><br />
</body>
</html>