<?php
error_reporting(E_ERROR);
function request($url, $data = null, $headers = null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if($data):
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if($headers):
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
    endif;

    curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
    return curl_exec($ch);
}
$rand1 = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', mt_rand(1,11))), 1, 11);
$rand2 = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', mt_rand(1,4))), 1, 4);

function getstr($str, $exp1, $exp2)
{
    $a = explode($exp1, $str)[1];
    return explode($exp2, $a)[0];
}

echo "Key ? ";
$key = trim(fgets(STDIN));

click:
$url = "https://api.lunarcrush.com/v2?data=user&action=points-detail&key=$key";
$headaers = array();
$headears[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36";
$headears[] = "Accept: */*";
$headears[] = "Sec-Gpc: 1";
$headears[] = "Sec-Fetch-Site: same-site";
$headears[] = "Sec-Fetch-Mode: cors";
$headears[] = "Sec-Fetch-Dest: empty";
$headears[] = "Accept-Encoding: gzip, deflate";
$headears[] = "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8";
$tau = request($url, $data=null, $headers);
if(strpos($tau, 'Internal server error')!==false)
{
    goto click;
}
else
{
    $click = getstr($tau, '"points":"','"');
    $reff = getstr($tau, '"signUps30Days":',',');
}

$url = "https://api.lunarcrush.com/v2?data=share&key=$key";
$headaers = array();
$headears[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36";
$headears[] = "Accept: */*";
$headears[] = "Sec-Gpc: 1";
$headears[] = "Sec-Fetch-Site: same-site";
$headears[] = "Sec-Fetch-Mode: cors";
$headears[] = "Sec-Fetch-Dest: empty";
$headears[] = "Accept-Encoding: gzip, deflate";
$headears[] = "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8";
$data = '{"ratio":"square","ctxsource":"referral","share":"Referral","title":"Check out LunarCrush!","url":"/","tweet_text":"I use @LunarCrush to track social insights for cryptocurrencies. Check it out!\n\nhttps://lnr.app/s/{{shareId}} #LunarShare","description":"I use LunarCrush to track social insights for cryptocurrencies. Check it out!\n\nhttps://lnr.app/s/{{shareId}}","shareData":"\"url link\""}';
$tau = request($url, $data, $headers);
if(strpos($tau, 'Internal server error')!==false)
{
    goto click;
}
else
{   
    $codereff = getstr($tau, ',"data":"','"');
    echo "Points : $click\nReff : $reff\nCode Reff : $codereff\n";
}
