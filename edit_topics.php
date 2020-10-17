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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.config.toolbar = [
 ,['Source'],['Image','Link','Unlink','Anchor'],['Undo','Redo']
 ,['FontSize'],['TextColor'],['Bold','Italic','Underline']
 ,['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']
 ,['Table']
];
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
// テキストエリアの幅
CKEDITOR.config.width  = '800px';
// テキストエリアの高さ
CKEDITOR.config.height = '450px';
</script>

<style type="text/css">
.box1 {
padding:15px 0px 15px 15px;
width:800px;
background-color: #cccccc;
font-size:12px;
}
</style>



</head>
<body>


<h1>記事編集</h1>
<table>
<tr>
<td>非表示</td>
<td></td>
<td>タイトル</td>
<td>日付</td>
<td>本文</td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="riyu" value="2"></td>
<td>編集</td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="riyu" value="2"></td>
<td>編集</td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="riyu" value="2"></td>
<td>編集</td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="riyu" value="2"></td>
<td>編集</td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="riyu" value="2"></td>
<td>編集</td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td></td>
</tr>
<tr>
<td><input type="checkbox" name="riyu" value="2"></td>
<td>編集</td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td><input type="text" name="namae" size="40" maxlength="20"></td>
<td></td>
</tr>
</table>



<br>
<br>
<br>
<br>
<br>


<?php
// 接続設定（サーバ／データベース／ユーザ／パスワード）
$sv = "mysql147.phy.lolipop.lan";
$dbname = "LAA0754935-tagencynews";
$user = "LAA0754935";
$pass = "2001";
// データベースに接続する
$link = mysqli_connect($sv, $user, $pass,$dbname) or die('接続エラー');
$link->set_charset("utf8");
/* 接続状況をチェックします */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//edit page name
$editpagename = $_SESSION['editpagename'];
$site_ad = $_SESSION['site_ad'];


if(isset($_POST["open_select"])){
$id = $_POST["select_id"];

$query = "SELECT * FROM $editpagename WHERE id = $id";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result, MYSQLI_BOTH);

echo "　<span style=\"color:#ff0000;\"><strong>過去の入力内容表示中</strong>(保存するにはuploadをクリック)</span>";
}
else{
$query = "SELECT * FROM $editpagename  ORDER BY id DESC LIMIT 1";
$result = mysqli_query($link, $query);
/* 数値添字配列 */
$row = mysqli_fetch_array($result, MYSQLI_BOTH);
}


?>

<?php
//submit_upd_done
if(isset($_POST["submit_upd"])){
$editpagename=$_POST["editpagename"];
$datetime = date("Y/m/d H:i:s");
$txt = $_POST["txt"];
$str = nl2br($txt);
$txt = htmlspecialchars($txt);
$_SESSION['editpagename']=$editpagename;
$_SESSION['site_ad']=$site_ad;


if (@$_COOKIE['cookieA']['visitcount']) {$vc = $_COOKIE['cookieA']['visitcount'];}else {$vc = "no_vc";}
if (@$_COOKIE['cookieA']['pcname']) {$pcname = $_COOKIE['cookieA']['pcname'];}else {$pcname = "no_pcname";}
if (@$_SERVER['REMOTE_ADDR']) {$ip = $_SERVER['REMOTE_ADDR'];}else {$ip = "no_ADDR";}
if (@$_SERVER['HTTP_USER_AGENT']) {$ua = $_SERVER['HTTP_USER_AGENT'];}else {$ua = "no_ua";}
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

// データベースに接続する
try {
$pdo = new PDO("mysql:dbname=$dbname;host=$sv","$user","$pass",
	array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"));
		} catch (PDOException $e) {
      exit("データベースに接続できませんでした".$e->getMessage());
}

$st = $pdo->prepare("INSERT INTO $editpagename (html_source,ip,ua,pcname,vc,host,datetime)  VALUES (:txt,:ip,:ua,:pcname,:vc,:host,:datetime)");
$st->bindParam(':txt',$txt, PDO::PARAM_STR);//テキスト
$st->bindParam(':ip',$ip, PDO::PARAM_INT);//ip
$st->bindParam(':ua',$ua, PDO::PARAM_STR);//ユーザーエージェント
$st->bindParam(':pcname',$pcname, PDO::PARAM_STR);//PC
$st->bindParam(':vc',$vc, PDO::PARAM_STR);//カウント
$st->bindParam(':host',$host, PDO::PARAM_STR);//接続ホスト
$st->bindParam(':datetime',$datetime, PDO::PARAM_STR);//日時
$st->execute();

echo "<p style=\"background-color: #bde9ba;width:800px;\"><b>アップロード完了</b></p>";
echo '<meta http-equiv="Refresh" content="2">';
}
?>

<!--//--------------------------------------------------------------------
edit textarea
<div  style="width:80px; ">
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST" style="display: inline;">
<input type="hidden" name="editpagename" value="<?php echo $editpagename ?>" >
<textarea class="ckeditor" name="txt" cols="70" rows="50" style="width: 50%;height: 100px;" >
<?php echo $row[1] ?></textarea>
<div  style="text-align: right; "><input type="submit" name="submit_upd" value="upload"></div>
</form>
</div>
<br />
<br />
<br />
//---------------------------------------------------------------------->




<!--//--------------------------------------------------------------------
selectbox
//---------------------------------------------------------------------->
<form action="<?php echo $_SERVER["PHP_SELF"]?> " method="POST" style="display: inline;">
<input type="hidden" name="editpagename" value="<?php echo $editpagename ?>" >
<?php

$query = "SELECT * FROM " . $editpagename . " ORDER BY id DESC LIMIT 0 , 50";
$a = mysqli_query($link, $query);

//echo "過去の入力内容に戻す <select name=\"select_id\">";
while ($ptxt = mysqli_fetch_array($a)){
$id = $ptxt["id"];
$datetime = $ptxt["datetime"];
$memo = $ptxt["memo"];
//print <<< DOC_END
//<option value="$id"> $datetime $memo </option>
//DOC_END;
}

/* 結果セットを開放します */
mysqli_free_result($result);
mysqli_free_result($a);

/* 接続を閉じます */
mysqli_close($link);
?>
</select>
<!--
<input type="hidden" name="editpagename" value="<?php echo $editpagename ?>" >
<input type="submit" name="open_select" value="go">
-->
</form>


<div class="box1">
■使用について<br />
入力フォーム右下をクリックし枠を広げ使用下さい。<br />
レイアウトや幅を揃えたい時などは右上の表ボタンから表を作成し、作業後に右クリックのメニューから表のラインを消し作業下さい。<br />
定期的にローカルPCにもコピーし保存をおすすめします。<br />
<br />
■画像の貼付方法<br />
１，<a href="img.php" target="_blank">画像管理</a>ページからURLをコピー<br />
２，左上2番目の画像挿入ボタンよりURLを貼りつけ。<br />
<br />
</div>

<a href="index.html">管理画面に戻る</a>
</body>
</html>
