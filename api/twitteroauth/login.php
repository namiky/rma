<?php
	//SESSION�J�n
	session_start();
	//�C���N���[�h
	require_once('twitteroauth.php');
	//Consumer key�̒l��TwitterAPI�J���҃y�[�W�ł��m�F�������B
	$sConsumerKey = "i06e6MTJChd1FvrEh7HJ5g";
	//Consumer secret�̒l���i�[
	$sConsumerSecret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
	//callbakurl
	$sCallBackUrl = 'http://www.tryphp.net/twitteroauth/callback.php';
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Twitter OAuth Login</title>
	</head>
	<body>
		 
		<?php
		//�Z�b�V�����̃A�N�Z�X�g�[�N���̃`�F�b�N
		if((isset($_SESSION['oauthToken']) && $_SESSION['oauthToken'] !== NULL) && (isset($_SESSION['oauthTokenSecret']) && $_SESSION['oauthTokenSecret'] != NULL)){
		 
			//�l�̊i�[
			$sUserId = 			$_SESSION['userId'];
			$sScreenName = 		$_SESSION['screenName'];
		 
			//�\��
			?>
			���O�C���ɐ������܂����B<br/>
			����ɂ��́I <?php echo $sScreenName; ?> ����<br/>
			���[�U�[ID <?php echo $sUserId; ?><br/>
			<br/>
			<a href="./logout.php">���O�A�E�g����</a></p>
		 
		<?php
		}else{
		 
			//OAuth�I�u�W�F�N�g����
			$oOauth = new TwitterOAuth($sConsumerKey,$sConsumerSecret);
		 
			//callback url ���w�肵�� request token���擾
			$oOauthToken = $oOauth->getRequestToken($sCallBackUrl);
		 
			//�Z�b�V�����i�[
			$_SESSION['requestToken'] = 			$sToken = $oOauthToken['oauth_token'];
			$_SESSION['requestTokenSecret'] = 		$oOauthToken['oauth_token_secret'];
		 
			//�F��URL�̈��� false�̏ꍇ��twitter���ŔF�؊m�F�\��
			if(isset($_GET['authorizeBoolean']) && $_GET['authorizeBoolean'] != '')
			$bAuthorizeBoolean = false;
			else
			$bAuthorizeBoolean = true;
		 
			//Authorize url ���擾
			$sUrl = $oOauth->getAuthorizeURL($sToken, $bAuthorizeBoolean);
			?>
			<a href="<?php echo $sUrl; ?>">���O�C��</a>
		 
		<?php } ?>
		 
	</body>
</html>