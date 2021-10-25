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

Echo "Reff ? ";
$reff = trim(fgets(STDIN));



echo "How Many Reff ? ";
$loop = trim(fgets(STDIN));
for ($i = 1; $i < $loop; $i++){

echo "[1] Getting Token : ";
gettoken:
$url = "https://api.lunarcrush.com/v2?requestAccess=lunar&platform=web&device=Firefox&deviceId=LDID-d092fdae-0348-4837-a777-21a05a1ee23c&validator=r0pvhr0t0TnZnZTO0OOOvf0050fttvTS&clientVersion=lunar-20211013&userAgent=Mozilla%2F5.0%20(Windows%20NT%2010.0%3B%20Win64%3B%20x64%3B%20rv%3A87.0)%20Gecko%2F20100101%20Firefox%2F87.0&viewportSize=1920x938&screenSize=1920x1080&locale=id&token=null";
$headers = array();
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0";
$headers[] = "Accept: */*";
$headers[] = "Accept-Language: id,en-US;q=0.7,en;q=0.3";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Dnt: 1";
$headers[] = "Te: trailers";
$getToken = request($url, $data = null, $headers);
if(strpos($getToken, 'token')!==false)
{
    $token = getstr($getToken, 'token":"','"');
    echo "$token\n";
}
else if(strpos($getToken, 'Internal server error')!==false)
{
    goto gettoken;
}
else
{
    echo "Error get Token\n";
    echo $getToken;
}

echo "[2] Getting Email : ";
$url = "https://api.internal.temp-mail.io/api/v3/email/new";
$headers = array();
$headears[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0";
$headears[] = "Accept: application/json, text/plain, */*";
$headears[] = "Accept-Language: id,en-US;q=0.7,en;q=0.3";
$headears[] = "Accept-Encoding: gzip, deflate";
$headears[] = "Content-Type: application/json;charset=utf-8";
$headears[] = "Application-Name: web";
$headears[] = "Application-Version: 2.2.14";
$headears[] = "Dnt: 1";
$headears[] = "Te: trailers";
$data = '{"min_name_length":10,"max_name_length":10}';
$getEmail = request($url, $data, $headers);
$email = getstr($getEmail, '"email":"','"');
echo "$email\n";


echo "[3] Request OTP : ";
reqotp:
$url = "https://api.lunarcrush.com/v2?data=auth&action=get-code&email=$email&key=$token";
$headers = array();
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0";
$headers[] = "Accept: */*";
$headers[] = "Accept-Language: id,en-US;q=0.7,en;q=0.3";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Dnt: 1";
$headers[] = "Pragma: no-cache";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Te: trailers";
$reqOTP = request($url, $data=null, $headers);
if(strpos($reqOTP, 'get-code')!==false)
{
    echo "Sent!\n";
    $id = getstr($reqOTP, '"id":"','"');
}
else if(strpos($reqOTP, 'Internal server error')!==false)
{
    goto reqotp;
}
else
{
    echo "Error!\n";
    echo $reqOTP;
    exit();
}

echo "[4] Getting OTP : ";
otp:
$url = "https://api.internal.temp-mail.io/api/v3/email/$email/messages";
$headers = array();
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Accept-Language: id,en-US;q=0.7,en;q=0.3";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Application-Name: web";
$headers[] = "Application-Version: 2.2.14";
$headers[] = "Dnt: 1";
$headers[] = "Te: trailers";
$getOTP = request($url, $data=null, $headers);
if(strpos($getOTP, 'There is a request to sign in to your account from')!==false)
{
    $otp = getstr($getOTP, 'device.*\n\n','\n\nTeam');
    echo "$otp\n";
}
else
{
    goto otp;
}


echo "[5] Try to Login : ";
login:
$url = "https://api.lunarcrush.com/v2?data=auth&action=login&challenge=$id&code=$otp&share=$reff&referral=&key=$token";
$headers = array();
$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0";
$headers[] = "Accept: */*";
$headers[] = "Accept-Language: id,en-US;q=0.7,en;q=0.3";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Dnt: 1";
$headers[] = "Pragma: no-cache";
$headers[] = "Cache-Control: no-cache";
$headers[] = "Te: trailers";
$login = request($url, $data=null, $headers);
if(strpos($login, '"success":true')!==false)
{
    echo "Success!\n\n";
    echo "[$i/$loop] Account Created\n\n";
}
else if(strpos($login, 'Internal server error')!==false)
{
    goto login;
}
else
{
    echo "Error!\n";
    echo $login;
}
}
