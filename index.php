<?php
	session_start();
	ini_set('display_errors', 1);
	error_reporting(~0);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 100%">
<head>
	<title>DocuVieware Demo - PHP.</title>
</head>
<body style="overflow: hidden; margin: 0; height: 100%;">
	<div style="width: 100%; height: 100%;">
	<?php
		require_once(__DIR__ . '/passportpdfsdk/vendor/autoload.php'); //this is the path where PassportPDF SDK has been installed using "composer install".

		$apiKey = '';
		
		if($apiKey == ''){
		  echo "Please enter your API key into the apiKey variable";
		  return;
		}
		
		$data = Array(
				'sessionID'     => session_id(),
				'controlState' => Array(
				'controlID'     => 'DocuVieware1',
				'UserLanguages' => [substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)],
				'documentURI'   => 'https://www.docuvieware-demo.com/download_document.aspx?src=st_exupery_le_petit_prince.pdf'
				)
		);

		try {
			$client = new GuzzleHttp\Client(['headers' => ['X-PassportPDF-API-Key' => $apiKey]]);
      $config = OpenAPI\Client\Configuration::getDefaultConfiguration();

			$docuviewareApi = new OpenAPI\Client\Api\DocuViewareApi($client, $config);

			$response = $docuviewareApi->docuViewareGetControl($data);
			
			if($response['error'] != null){
				echo "an error occured: " . $response['error'];
			}
      else{
			   echo $response['element'];
		  }

		} catch(\OpenAPI\Client\ApiException $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
			echo 'HTTP response headers: ', print_r($e->getResponseHeaders(), true), "\n";
			echo 'HTTP response body: ', print_r($e->getResponseBody(), true), "\n";
			echo 'HTTP status code: ', $e->getCode(), "\n";
		}
	?>
	</div>
</body>
</html>