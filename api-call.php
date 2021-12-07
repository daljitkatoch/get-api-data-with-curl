<?php
function callAPI($method, $url, $data){
   error_reporting(E_ALL);
   $data = '['.$data.']';
   $curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   
	//curl_setopt($ch, CURLOPT_SSLVERSION, 6);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'apiKey: enter_api_key_here',
      'Content-Type: application/json',
   ));

   // OPTIONS:
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   
   //curl_setopt($ch, CURLOPT_CAINFO, FCPATH . "cacert.pem");

	
   // EXECUTE:

   $result = curl_exec($curl);

  $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  if( $httpCode != 200 ){
		echo "Return code is {$httpCode} \n".curl_error($curl);
	} else {
		echo "<span style='display:none'><pre>".htmlspecialchars( $result)."</pre></span>";
	}
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}
?>
