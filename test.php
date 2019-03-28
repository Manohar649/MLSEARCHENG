<?php  
$options['host'] = "localhost";   
$options['port'] = 5984;  
// Creating connection  
$couch = new CouchSimple($options);   
$couch->send("GET", "/");   
// Create a new database "javatpoint".  
$couch->send("PUT", "/java");   
// Create a new document in the database.  
$f="h";
$couch->send("PUT", "/java/$f", '{"_id":"j","name":"John"}');   
// Fetching document  
$resp = $couch->send("GET", "/java/$f");   
echo $resp;   
class CouchSimple {  
function CouchSimple($options) {  
foreach($options AS $key => $value) {  
$this->$key = $value;  
}  
}   
function send($method, $url, $post_data = NULL) {  
$s = fsockopen($this->host, $this->port, $errno, $errstr);   
if(!$s) {  
echo "$errno:$errstr\n";   
return false;  
}   
$request = "$method $url HTTP/1.0\r\nHost: $this->host\r\n";   
if (@$this->user) {  
$request .= "Authorization: Basic ".base64_encode("$this->user:$this->pass")."\r\n";   
}  
if($post_data) {  
$request .= "Content-Length: ".strlen($post_data)."\r\n\r\n";   
$request .= "$post_data\r\n";  
}   
else {  
$request .= "\r\n";  
}  
fwrite($s, $request);   
$response = "";   
while(!feof($s)) {  
$response .= fgets($s);  
}  
list($this->headers, $this->body) = explode("\r\n\r\n", $response);   
return $this->body;  
}  
}  
?>  