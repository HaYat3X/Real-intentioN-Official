<?php

// 登録完了メールの送信
$email = 'hayatesato1@gmail.com';
mb_language('Japanese');
mb_internal_encoding('UTF-8');
$to = $email;
$subject = "メールアドレス認証トークン";
$message = '認証トークンは' . '"' . rand() . '"' . 'です。';
$headers = "From: hayate.syukatu1@gmail.com";
mb_send_mail($to, $subject, $message, $headers);


