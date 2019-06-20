<?php

class KIU_Connection {
    
//	protected $URL='https://ssl00.kiusys.com/ws3/';
        protected $URL='https://ssl00.kiusys.com/ws3/';
	protected $user='2I';
	protected $pass='nuo8noo0dooMJain';
	protected $ErrorCode;
	protected $ErrorMsg;
        protected $ch;

	public function Connection() {
		//open connection
		$this->ch = curl_init();
                $ip = $_SERVER["REMOTE_ADDR"];
                $browser_id = "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3";
		//set the url, number of POST vars, POST data
		curl_setopt($this->ch,CURLOPT_URL, $this->URL);
                curl_setopt($this->ch,CURLOPT_POST, 1);
		curl_setopt($this->ch,CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($this->ch, CURLOPT_USERAGENT, $browser_id);
                curl_setopt($this->ch,CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($this->ch,CURLOPT_HTTPHEADER, array(
			'Connection: Keep-Alive',
			'Keep-Alive: 30'
		));
                curl_setopt($this->ch, CURLOPT_REFERER, $ip);
		if (curl_errno($this->ch)) $this->catchError(curl_error($this->ch));//throw new Exception(curl_error($this->ch));
		
	}

	public function CloseConnection() {
		//close connection
		curl_close($this->ch);
	}

	public function SendMessage($xml) {
//		curl_setopt($this->ch, CURLOPT_VERBOSE, true);
//		$verbose = fopen('php://temp', 'rw+');
//		curl_setopt($this->ch, CURLOPT_STDERR, $verbose);
		$xml = str_replace('+', '%20', urlencode($xml));
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, "user=" . $this->user . "&password=" . $this->pass . "&request=$xml");

		//execute post
		$result = curl_exec($this->ch);
		//Check errors
		if (curl_errno($this->ch)) $this->catchError(curl_error($this->ch));//throw new Exception(curl_error($this->ch));

		//Get Info
		$info = curl_getinfo($this->ch);
		//Check response code is OK
		if ($info['http_code'] != 200) $this->catchError("Invalid response code $info[http_code]");//throw new Exception("Invalid response code $info[http_code]");
		
//		rewind($verbose);
//		$verboseLog = stream_get_contents($verbose);
//		echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
		return $result;
	}
        
	public function catchError($ErrorMsg){
		$this->ErrorCode = 1;
		$this->ErrorMsg = $ErrorMsg;
	}
}

?>