<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TRYPHP!�@Twitter API �F�؃��[�U�[�̃X�e�[�^�X�����X�V���܂��B POST statuses/update</title>
</head>
<body>
 
 
 
<?php
############################################ �����ݒ�
//twitteroauth.php���C���N���[�h���܂��B�t�@�C���ւ̃p�X�͊��ɍ��킹�ċL�q�������B
require_once("twitteroauth.php");
 
//Consumer key�̒l��TwitterAPI�J���҃y�[�W�ł��m�F�������B
$consumerKey = "i06e6MTJChd1FvrEh7HJ5g";
//Consumer secret�̒l���i�[
$consumerSecret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
//Access Token�̒l���i�[
$accessToken = "1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF";
//Access Token Secret�̒l���i�[
$accessTokenSecret = "gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444";
 
//OAuth�I�u�W�F�N�g�𐶐�����
$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);
?>
 
 
 
<?php
############################################ �y�[�W����
?>
 
<h1>Twitter API �F�؃��[�U�[�̃X�e�[�^�X�����X�V���܂��B POST statuses/update</h1>
<!-- �����y�[�Wurl -->
<h3><a href="http://www.tryphp.net/2012/01/11/phpapptwitter-update/">�������͂�����</a></h3>
<hr/>
 
 
 
<?php
############################################ �擾�����f�[�^��W�J
?>
 
<h2>�擾�����f�[�^��W�J</h2>
<div style="background-color:#f8f8f8;margin:20px; padding:20px; border:solid #cccccc 1px;">
 
<!-- // =========================== �������� =========================== -->
 
<?php
//API���s�f�[�^�擾
$vRequest = $twObj->OAuthRequest("https://api.twitter.com/1/statuses/update.xml","POST",array('status' => 'test tweeeet!'));
 
//XML�f�[�^��simplexml_load_string�֐����g�p���ăI�u�W�F�N�g�ɕϊ�����
$oXml = simplexml_load_string($vRequest);
 
//�I�u�W�F�N�g��W�J
if(isset($oXml->error) && $oXml->error != ''){
    echo "���e�ł��܂���ł����B<br/>\n";
    echo "�A�v���P�[�V�����́uRead Write Delete�v�ݒ���m�F���ĉ������B<br/>\n";
    echo "�p�����[�^�[�̎w����m�F���ĉ������B<br/>\n";
    echo "���e����ɂ͓������e�𓊍e�ł��܂���B<br/>\n";
    echo "�G���[���b�Z�[�W:".$oXml->error."<br/>\n";
}else{
    $sCreateAt =             $oXml->created_at; //�Ԃ₫����
    $iStatusId =             $oXml->id; //�Ԃ₫�X�e�[�^�XID
    $sText =                 $oXml->text; //�Ԃ₫
 
    $iUserId =                 $oXml->user->id; //���[�U�[ID
    $sScreenName =             $oXml->user->screen_name; //screen_name
 
    echo "<p><b>����(".$sCreateAt.") statusid(".$iStatusId.") text(".$sText.")</b>
    <br/><a href=\"http://twitter.com/".$sScreenName."/status/".$iStatusId."\">���̂Ԃ₫�̃p�[�}�����N</a><br/>\n".$sText."</p>\n";
}
?>
 
<!-- =========================== �����܂� =========================== // -->
</div>
<hr/>
 
 
 
<?php
#########################################
### �擾�����I�u�W�F�N�g�̓��e
?>
 
<h1>�擾�����I�u�W�F�N�g�̓��e</h1>
<pre>
<?php
var_dump($oXml);
?>
<\/pre>
<hr/>
 
 
 
</body>
</html>