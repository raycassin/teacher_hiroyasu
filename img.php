<?php

	//=======================================================================
	// 動作に必要な設定
	//=======================================================================
	/** このファイルを配置するURL(最後のスラッシュは付けないでください) */
	define('URL', 'https://tagency.jp/edit');
	/** 表示されるタイトル */
	define('TITLE', '画像アップロード');
	/** このファイルの名前 */
	define('FILE_NAME', 'img.php');
	/** ファイル選択のフィールド数 */
	define('FILE_NUM', 2);
	/** すべてのファイルをJPEGに変換するか(1:変換する 0:変換しない) */
	define('ALL_JPEG', 1);
	/** 縮小処理する閾値 */
	define('MAX_SIZE', 800);
	/** 画像の保存ディレクトリ名 */
	define('DIR_IMAGE', 'images');
	/** ひとつのファイルの最大サイズ(バイト) */
	define('MAX_FILE_SIZE', 5120000 );

	//=======================================================================
	// サムネイルの設定
	//=======================================================================
	/** サムネイル画像の横幅 */
	define('THUMBNAIL_WIDTH', 300);
	/** サムネイル画像の保存ディレクトリ名 */
	define('DIR_THUMBNAIL', 'images/thumbnail');
	/** サムネイルクリック時のウィンドウ制御('_self':同一画面 '_blank':新規ウィンドウ) */
	define('WINDOW_TARGET', '_blank');

	//=======================================================================
	// データベースの接続設定
	//=======================================================================
	/** データベース接続ユーザ名 */
	define('USERNAME', 'LAA0754935');
	/** データベース接続パスワード */
	define('PASSWORD', '2001');
	/** データベース接続データベース名 */
	define('DBNAME', 'LAA0754935-tagencyimg');
	/** データベース接続ホスト名 */
	define('HOST', 'mysql146.phy.lolipop.lan');

	//=======================================================================
	// ここより実際の動作、基本的に修正する必要はありません
	//=======================================================================
	session_start();

	$isCheck = file_exists(DIR_IMAGE);
	$mode = isset($_POST['mode']) ? $_POST['mode'] : NULL;
	$setup = isset($_GET['mode']) ? $_GET['mode'] : NULL;
	if ( (!is_null($setup) && $setup === 'setup') || !$isCheck ) {
		setup();
		exit;
	}
	if ( !is_null($mode) ) {
		try {
			if ( $mode === 'regist' ) {
				// 登録処理
				regist($_FILES);
			} else if ( $mode === 'delete' ) {
				delete($_POST['pid']);
			}
		} catch ( Exception $e ) {
			$_SESSION['error_message'] = $e->getMessage();
		}
		header('Location: ' . URL . '/' . FILE_NAME);
		exit;
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Expires" content="0"> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title><?php echo TITLE ?></title>
	<style type="text/css">
	div.container { width: 800px; }
	h2 {
		margin: 0; padding: 2px 0;
		background-color: #f7b9b9;
		font-size: 1.0em;
		text-align: center;
	}
	div.container table { width: 100%; margin-bottom: 25px; }
	table.form td.file { text-align: right; background-color: #f9dbdb; }
	table.form td.button { text-align: right; }
	p.error { margin: 0; padding: 0; color: #f00; font-size: 0.85em; font-weight: bold; }
	table thead th { background-color: #f9dbdb; }
	table.list td { background-color: #f9dbdb; }
	table.list td.no { text-align: center; }
	table.list td.delete { text-align: center; }
	.box1 {
		padding:15px 0px 15px 15px;
		width:800px;
		background-color: #cccccc;
		font-size:12px;
	}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	$(function() {
		$(document).on('click', 'button[name="upload_img"]', function() {
			$('button').prop('disabled', true);
			$(this).parents('form').submit();
		});
		$(document).on('click', 'button.btn-delete', function() {
			if ( confirm('削除しますか？\n(削除したデータは復活させることができません。)') ) {
				// 削除処理
				$(this).parent().submit();
			}
		});
	});
</script>
</head>
<body>
	<div class="container">
		<h2>画像アップロード　　　※アップ可能なデータは画像の種類は(jpg,gif,png)です。</h2>
		<form action="" method="post" enctype="multipart/form-data">
			<table class="form">
<?php for ( $i = 0; $i < FILE_NUM; $i ++ ) : ?>
				<tr>
					<td class="file">
						<input type="file" name="img[]">
					</td>
				</tr>
<?php endfor; ?>
				<tr>
					<td colspan="2" class="button">
						<?php echo showErrorMessage(); ?>
						<button type="submit" name="upload_img">upload_image</button>
					</td>
				</tr>
			</table>
			<input type="hidden" name="mode" value="regist">
		</form>
		<!--list------->
		<h2>画像リスト</h2>
		<table class="list">
			<thead>
				<tr>
					<th>番号</th><th width="100">該当画像</th><th>画像URL(元画像サイズ)</th><th>画像削除</th>
				</tr>
			</thead>
			<tbody>
				<?php echo imageList(); ?>
			</tbody>
		</table>
		<div class="box1">
			■使用について<br />
			HPで使用したい画像ファイルをフォームよりアップロード下さい。<br />
			アップ可能なデータは画像(jpg,gif,png)です。<br />
			デジカメのデータなど膨大なデータは圧縮し使用下さい。
		</div>
		<p><a href="index.html">管理画面に戻る</a></p>
	</div>
</body>
</html>
<?php


	/**
	 * 登録されている画像リスト表示用のHTMLを生成します。
	 *
	 * @return	string		表示用のHTML
	 */
	function imageList() {
		try {
			$db = db();
		} catch ( PDOException $e ) {
			$html = '<tr><td colspan="4"><p class="error">データベースの接続に失敗しました。接続設定を確認してください。</p></td></tr>';
			return $html;
		}
		$sql = 'select * from IMAGE_UPLOAD';
		$sql .= ' order by pid desc';
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array());

		$html = '';
		while($record = $stmt->fetch(PDO::FETCH_ASSOC)){
			$fileName = $record['FILEID'];
			$url = URL.'/'.DIR_IMAGE.'/'.$fileName.'.'.getExt($record['FILETYPE']);
			$html .= '<tr>';
			$html .= '<td class="no">'.$record['PID'].'</td>';
			$html .= '<td><a href="'.$url.'" target="'.WINDOW_TARGET.'"><img src="'.DIR_THUMBNAIL.'/'.$fileName.'.jpg" width="'.THUMBNAIL_WIDTH.'"></a></td>';
			$html .= '<td class="url"><a href="'.$url.'" target="'.WINDOW_TARGET.'">'.$url.'</a></td>';
			$html .= '<td class="delete"><form action="" method="post">';
			$html .= '<button type="button" class="btn-delete">削除</button>';
			$html .= '<input type="hidden" name="pid" value="'.$record['PID'].'"><input type="hidden" name="mode" value="delete"></form></td>';
			$html .= '</tr>';
		}
		return $html;
	}


	/**
	 * ファイルの登録処理を実行します。
	 *
	 * @param	array	$files		postされたデータ
	 */
	function regist($files) {
		$max = count($files['img']['tmp_name']);
		$file = $files['img'];
		$fileList = array();
		for ( $i = 0; $i < $max; $i ++ ) {
			if ( $file['tmp_name'][$i] == '' ) continue;
			$type = exif_imagetype($file['tmp_name'][$i]);
			$size = $file['size'][$i];
			if ( $size > MAX_FILE_SIZE )
				throw new Exception('制限された容量より大きいファイルが含まれています。(MAX='.number_format(MAX_FILE_SIZE).'byte)');
				
			if ( $type !== IMAGETYPE_GIF && $type !== IMAGETYPE_JPEG && $type !== IMAGETYPE_PNG )
				throw new Exception('対応しない形式のファイルが含まれています。');
			$fileList[] = array($file['tmp_name'][$i],$type);
		}
		try {
			$db = db();
		} catch ( PDOException $e ) {
			throw new Exception('データベースの接続に失敗しました。接続設定を確認してください。');
		}
		$sql = 'insert into IMAGE_UPLOAD(FILEID,FILENAME,FILESIZE,FILETYPE,IPADDRESS,USERAGENT,REGIST_DATE)';
		$sql .= 'values( :FILEID, :FILENAME, :FILESIZE, :FILETYPE, :IPADDRESS, :USERAGENT, now() )';
		for ( $i = 0; $i < count($fileList); $i ++ ) {
			$filePath = $fileList[$i][0];
			$type = $fileList[$i][1];
			// 一意な名前を取得
			$fileId = uniqid();
			// サムネイルの作成
			// 画像サイズの取得
			list($origWidth, $origHeight) = getimagesize($filePath);
			// サムネイルの横幅
			$thumbWidth = THUMBNAIL_WIDTH;
			$minWidth = MAX_SIZE;
			// 比率を算出
			$proportion = $origWidth / $origHeight;
			// 比率から縦を算出
			$thumbHeight = $thumbWidth / $proportion;
			$minHeight = $minWidth / $proportion;
			if ( $proportion < 1 ) {
				// 縦横の入れ替え
				$thumbHeight = $thumbWidth;
				$minHeight = $minWidth;
				$thumbWidth = $thumbWidth * $proportion;
				$minWidth = $minWidth * $proportion;
			}
			// サムネイルの土台を生成
			$newImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
			if ( $type == IMAGETYPE_JPEG ) {
				// jpegファイルの処理
				$ext = 'jpg';
				$origImage = imagecreatefromjpeg($filePath);
			} else if ( $type == IMAGETYPE_GIF ) {
				// gifファイルの処理
				$ext = 'gif';
				$origImage = imagecreatefromgif($filePath);
			} else if ( $type == IMAGETYPE_PNG ) {
				// pngファイルの処理
				$ext = 'png';
				$origImage = imagecreatefrompng($filePath);
			}
			// サムネイル画像の生成と書き込み
			imagecopyresampled($newImage, $origImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);
			imagejpeg($newImage,DIR_THUMBNAIL.'/'.$fileId.'.jpg');
			if ( $origWidth > MAX_SIZE || $origHeight > MAX_SIZE ) {
				// 縮小対象の場合
				$newImage2 = imagecreatetruecolor($minWidth, $minHeight);
				imagecopyresampled($newImage2, $origImage, 0, 0, 0, 0, $minWidth, $minHeight, $origWidth, $origHeight);
				$fileName = DIR_IMAGE.'/'.$fileId;
				if ( $type === IMAGETYPE_JPEG || ALL_JPEG === 1 ) {
					imagejpeg($newImage2, $fileName.'.jpg');
				} else if ( $type === IMAGETYPE_GIF ) {
					imagegif($newImage2, $fileName.'.gif');
				} else if ( $type === IMAGETYPE_PNG ) {
					imagepng($newImage2, $fileName.'.png');
				}
				imagedestroy($newImage2);
			} else {
				if ( ALL_JPEG === 1 ) {
					// すべてをJPEGに変換する場合
					imagejpeg($origImage,DIR_IMAGE.'/'.$fileId.'.jpg');
				} else {
					// ファイルのコピー
					move_uploaded_file($filePath,DIR_IMAGE.'/'.$fileId.'.'.$ext);
				}
			}
			// 解放
			imagedestroy($newImage);
			imagedestroy($origImage);

			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			$ipAddress = $_SERVER['REMOTE_ADDR'];
			// データベースへの登録を実行
			$stmt = $db->prepare($sql);
			$result = $stmt->execute(
				array(
					':FILEID'=>$fileId,
					':FILENAME'=>'aiueo',
					':FILESIZE'=>$size,
					':FILETYPE'=>ALL_JPEG === 1 ? 2 : $type,
					':IPADDRESS'=>$ipAddress,
					':USERAGENT'=>$userAgent
				)
			);
		}
	}


	/**
	 * 削除を実行します。
	 *
	 * @param	string		$id		削除対象のPID
	 */
	function delete($id) {

		try {
			$db = db();
		} catch ( PDOException $e ) {
			throw new Exception('データベースの接続に失敗しました。接続設定を確認してください。');
		}
		// 削除対象のファイル名を取得
		$sql = 'select FILEID, FILETYPE from IMAGE_UPLOAD';
		$sql .= ' where pid=:PID';
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':PID'=>$id));
		$fileName = '';
		$thumbName = '';
		while($record = $stmt->fetch(PDO::FETCH_ASSOC)){
			$fileName = $record['FILEID'].'.'.getExt($record['FILETYPE']);
			$thumbName = $record['FILEID'].'.jpg';
		}
		if ( $fileName === '' ) {
			throw new Exception('削除対象のデータが取得できませんでした。');
		}
		// データベース上のデータを削除
		$sql = 'delete from IMAGE_UPLOAD';
		$sql .= ' where pid=:PID';
		$stmt = $db->prepare($sql);
		$result = $stmt->execute(array(':PID'=>$id));
		// 実ファイルを削除
		$isDelete1 = unlink(DIR_IMAGE.'/'.$fileName);
		// サムネイルを削除
		$isDelete2 = unlink(DIR_THUMBNAIL.'/'.$thumbName);

		if ( !$isDelete1 || !$isDelete2 ) {
			if ( !$isDelete1 )
				$errorMessage = '実ファイルの削除に失敗しました。';
			if ( !$isDelete2 )
				$errorMessage .= 'サムネイルの削除に失敗しました。';
			throw new Exception($errorMessage);
		}

	}


	/**
	 * エラーメッセージ表示用のHTMLを返します。
	 *
	 * @param	string		エラーメッセージ
	 */
	function showErrorMessage() {
		$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : NULL;
		if ( is_null($errorMessage) ) return '';
		unset($_SESSION['error_message']);
		return '<p class="error">'.$errorMessage.'</p>';
	}


	/**
	 * データベースへの接続を実行します。
	 */
	function db() {
		$dns = 'mysql:dbname='.DBNAME.';host=' . HOST;
		return new PDO($dns, USERNAME, PASSWORD);
	}


	/**
	 * ファイルタイプより拡張子を取得します。
	 *
	 * @param	integer		$type		ファイルタイプ
	 * @return	string	拡張子
	 */
	function getExt($type) {
		if ( $type == IMAGETYPE_JPEG ) {
			return 'jpg';
		} else if ( $type == IMAGETYPE_GIF ) {
			return 'gif';
		} else if ( $type == IMAGETYPE_PNG ) {
			return 'png';
		} else {
			return 'none';
		}
	}

	//====================================================================================
	// セットアップ関連
	// 初回セットアップ時に利用します。
	//====================================================================================
	function setup() {
		$message = '';
		$execute = isset($_POST['execute']) ? $_POST['execute'] : NULL;
		if ( !is_null($execute) && $execute === 'execute' ) {
			try {
				// ディレクトリの作成を実行
				if ( !file_exists(DIR_IMAGE) ) {
					mkdir(DIR_THUMBNAIL, 0705, true);
					$message .= '<p style="color:#00f;">動作に必要なディレクトリ['.DIR_IMAGE.']を作成しました。</p>';
					$message .= '<p style="color:#00f;">動作に必要なディレクトリ['.DIR_THUMBNAIL.']を作成しました。</p>';
				} else {
					$message .= '<p style="color:#090;">動作に必要なディレクトリ['.DIR_IMAGE.']は作成済みです。</p> ';
					$message .= '<p style="color:#090;">動作に必要なディレクトリ['.DIR_THUMBNAIL.']は作成済みです。</p> ';
				}
				$db = db();
				$result = $db->query('show tables');
				$tables = $result->fetchALL(PDO::FETCH_COLUMN);
				if ( in_array('image_upload',$tables) ) {
					$message .= '<p style="color:#090;">動作に必要な[IMAGE_UPLOAD]は作成済みです。</p>';
				} else {
$sql =<<< SQL
CREATE TABLE IMAGE_UPLOAD (
PID					INT			AUTO_INCREMENT,
FILEID				VARCHAR(13),
FILENAME			VARCHAR(60),
FILESIZE			INT,
FILETYPE			TINYINT,
IPADDRESS			VARCHAR(20),
USERAGENT			VARCHAR(200),
REGIST_DATE			DATETIME				default current_timestamp				NOT NULL,
UPDATE_DATE			TIMESTAMP				NOT NULL,
PRIMARY KEY(PID)
);
SQL;
					$db->query($sql);
					$message .= '<p style="color:#00f;">動作に必要な[IMAGE_UPLOAD]を作成しました。</p>';
					$message .= '<p><a href="'.FILE_NAME.'">'.TITLE.'へ</a></p>';
				}
			} catch ( PDOException $e ) {
				$message = '<p style="color:#f00;">データベースの接続に失敗しました。接続設定を確認してください。</p>';
			}
		}
echo <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>セットアップ</title>
</head>
<body>
	<form action="?mode=setup" method="post">
		<p>この操作により動作に必要なテーブル、ディレクトリが作成されます。</p>
		<p>初回または画像保存用のディレクトリが無い状態の場合このページが表示されます。</p>
		<button type="submit">初回セットアップを実行</button>
HTML;
		echo $message;
echo <<<HTML
		<input type="hidden" name="execute" value="execute">
	</form>
</body>
</html>
HTML;
	}
