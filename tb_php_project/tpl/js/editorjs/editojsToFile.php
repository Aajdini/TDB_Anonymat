<?php
/*$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
*/
$marks = array("Peter"=>65, "Harry"=>80, "John"=>78, "Clark"=>90);
$json_data = json_encode($marks);
file_put_contents('myfile.json', $json_data);