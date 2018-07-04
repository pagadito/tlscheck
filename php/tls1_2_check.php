<?php

$end_of_line = PHP_EOL;
if (!empty($_SERVER['HTTP_HOST'])) {
    $end_of_line = "<br/>";
}

$curl_version = curl_version();
echo "System Info" . $end_of_line;
echo "---------------------------" . $end_of_line;
echo "Host: " . $curl_version['host'] . $end_of_line;
echo "Operating System: " . PHP_OS . $end_of_line;
echo "PHP version: " . phpversion() . $end_of_line;
echo "cURL Version: " . $curl_version['version'] . $end_of_line;
echo "SSL Version: " . $curl_version['ssl_version'] . $end_of_line;
echo $end_of_line;

echo "Trying connection with Pagadito..." . $end_of_line;
echo "---------------------------" . $end_of_line;
echo "TLS test(default ". get_tls_default() .") :" . tls_check() . $end_of_line;
echo "TLS test(TLSv1.1) :" . tls_check(5) . $end_of_line;//CURL_SSLVERSION_TLSv1_1
echo "TLS test(TLSv1.2) :" . tls_check(6) . $end_of_line;//CURL_SSLVERSION_TLSv1_2
echo $end_of_line;

function tls_check($tls_version = null)
{
    $endpoint = 'https://sandbox.pagadito.com/comercios/apipg/charges.php';
    $cClient = curl_init($endpoint);

    curl_setopt($cClient, CURLOPT_HEADER, 0);
    curl_setopt($cClient, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cClient, CURLOPT_POSTFIELDS, "operation=f3f191ce3326905ff4403bb05b0de150&uid=211faa6c2fd4063d396ef94984869129&wsk=8541908c998d455320745b9f0271b44a&format_return=php");
    curl_setopt($cClient, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($cClient, CURLOPT_SSL_VERIFYHOST, 0);
    if ($tls_version != null) {
        curl_setopt($cClient, CURLOPT_SSLVERSION, $tls_version);
    }
    $response = curl_exec($cClient);
    if ($response) {
        return "OK";
    } else {
        return "CURL Error! #" . curl_errno($cClient)." : ".curl_error($cClient);
    }
    curl_close($cClient);
}

function get_tls_default()
{
    $cClient = curl_init();
    curl_setopt($cClient, CURLOPT_URL, "https://www.howsmyssl.com/a/check");
    curl_setopt($cClient, CURLOPT_RETURNTRANSFER, true);
    $rbody = curl_exec($cClient);
    if ($rbody === false) {
        return "";
    } else {
        $response = json_decode($rbody);
        curl_close($cClient);
        return $response->tls_version;
    }
}
