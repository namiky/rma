<?php
//twitteroauth.php��ǂݍ��ށB
//�p�X�͂��Ȃ����u�����K�؂ȏꏊ�ɕύX���Ă�������
//cron�ȂǂŎ��s����ꍇ�̓t���p�X�ŏ����Ă������ق����ǂ��Ǝv���c
require_once("twitteroauth.php");
 
//hogemoge�A�v���̃A�v�����
//�����Twitter��Developer�T�C�g�œo�^����Ǝ擾�ł��܂��B
// Consumer key�̒l
$consumer_key = "i06e6MTJChd1FvrEh7HJ5g";
// Consumer secret�̒l
$consumer_secret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
 
//@hogemoge_bot�̃A�J�E���g���
//�����Twitter��Developer�T�C�g�œo�^����Ǝ擾�ł��܂��B
// Access Token�̒l
$access_token = "1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF";
// Access Token Secret�̒l
$access_token_secret = "gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444";
 
// OAuth�I�u�W�F�N�g����
$to = new TwitterOAuth(
        $consumer_key,
        $consumer_secret,
        $access_token,
        $access_token_secret);
 
// Twitter��POST����B�p�����[�^�[�͔z��Ɋi�[����
$req = $to->OAuthRequest(
    "http://api.twitter.com/1/statuses/update.xml",
    "POST",
    array("status"=>"�������ɓ��e���������e���L�q�B")
        );
        ?>