<?php

///////////// CONFIG /////////////////
$webhookurl = "https://discord.com/api/webhooks/826908608750157874/gVP6H-9A3FRmgtWm4s8rrZsaob35ccSNpASHw1q7VOj70EVB5UankfhJXS_XDKWj4aHQ"; // Webhook URL
$userid = ''; // buraya takip etmek istediğiniz kullanıcının id'si
$invitecode = ''; // davet bağlantısı
/////////////////////////////////////

date_default_timezone_set('Europe/Istanbul');
$date = date('m/d/Y h:i:s a', time());

$url = 'https://discord.com/api/v8/invites/'.$invitelink.'?with_counts=true';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$json = json_decode($resp, true);


if($json['approximate_presence_count'] == '2' or $json['approximate_presence_count'] == '1'){

$timestamp = date("c", strtotime("now"));
$aga = $json['approximate_presence_count'];
$json_data = json_encode([
    // Message
    "content" => "<@$userid> adlı kullanıcı **$date** tarihinde Discord'da aktifti. Presence count hesaplandı, sonuç $aga çıktı. ",
    "tts" => false,
   
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
curl_close( $ch );
}elseif($json['approximate_presence_count'] == '0'){

$timestamp = date("c", strtotime("now"));

$json_data = json_encode([
    // Message
    "content" => "<@$userid> adlı kullanıcı $date tarihinde aktif değildi.",
    "tts" => false,
   
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
curl_close( $ch );
}
