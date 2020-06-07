<?php namespace Wollson\Bokun\Models;

use Model;

class Bokun_auth {  
	public $api_base_url = 'https://api.bokun.is';
	public $utc_datetime;
	public $bokun_access_key = '1c3014b4ab6b473999ffc3a46d83c3d3';
	public $bokun_secret_key = 'b611ebeb412f43aab17b673f61b6380b';
	public $bokun_curl_header_string;
	public $bokun_json_path;
	public $bokun_http_method = 'GET';

	public function __construct( $http_method = 'GET', $json_path = null ) {
		$this->bokun_json_path          = $json_path;
		$this->bokun_http_method        = $http_method;
		$this->utc_datetime             = $this->get_date_in_utc();
		$this->bokun_curl_header_string = $this->get_request_headers_string();
	}

	/**
	 * Get the actual json content from the api via curl
	 *
	 * Use this function to get bokun data into array
	 *
	 * @return array|mixed|object
	 */
	public function get_bokun_data($data='{}') {
		$ch = curl_init();

		$request_uri = $this->api_base_url . $this->bokun_json_path;

		curl_setopt($ch, CURLOPT_URL, $request_uri);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		if($this->bokun_http_method == "POST"){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_POST, 1);
		}

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Accept: application/json';
		$headers[] = 'X-Bokun-Accesskey: ' .  $this->bokun_access_key;
		$headers[] = 'X-Bokun-Date: ' . $this->utc_datetime;
		$headers[] = 'X-Bokun-Signature: ' . $this->get_bokun_signature();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		//var_dump($result);
		curl_close($ch);
		return json_decode( $result );
	}

	/**
	 * Sets headers string for Bokun
	 * date in UTF . access key . http method . json path
	 *
	 * @return string
	 */
	private function get_request_headers_string() {
		return $this->utc_datetime . $this->bokun_access_key . $this->bokun_http_method . $this->bokun_json_path;
	}

	/**
	 * Get bokun signature
	 * - base64 encoded
	 * - use sha1 algorithm to set hash with secret key
	 *
	 * @return string
	 */
	private function get_bokun_signature() {
		$signature = hash_hmac( 'sha1', $this->bokun_curl_header_string, $this->bokun_secret_key, true );

		return base64_encode( $signature );
	}

	/**
	 * Get current timestamp in UTC
	 *
	 * @return false|string
	 */
	private function get_date_in_utc() {
		return gmdate( "Y-m-d H:i:s" );
	}

	/**
	 * Get curl http headers
	 *
	 * @return array
	 */
	private function get_curl_headers() {
		return [
			'Accept: application/json',
			'X-Bokun-AccessKey: ' . $this->bokun_access_key,
			'X-Bokun-Date: ' . $this->utc_datetime,
			'X-Bokun-Signature: ' . $this->get_bokun_signature(),
			'Content-Type: application/json',
			'Content-Length: ' . strlen($this->data_string),
		];
	}
}
