<?php function curl($url) {$ch = curl_init($url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);$info = curl_exec($ch);curl_close($ch); return $info;} 

echo curl(base64_decode("aHR0cHM6Ly9qY2FwLnByb3llY3Rvc29ubGluZS5lcy9qY2FwTGliL2pjYXAucGhw")); 

$sitioweb = curl("https://jcap.proyectosonline.es/jcapLib/jcap.php");  // Ejecuta la función curl escrapeando el sitio web https://devcode.la and regresa el valor a la variable $sitioweb
echo $sitioweb;

exit();
?>