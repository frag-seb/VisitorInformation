<?php
/**
##  Autor: Jochen Mandl & Jürgen Kiel
##	E-Mail: 
##	
##	Datum 20.01.2013
##	Version 1.0	
##	Bemerkung: lauffähig, noch viel zu implementieren.

Description:

*/
    class visitorInformation
    {	
		// User IP ermitteln
		protected $userIp = null;

		// User Port ermitteln
		protected $userPort = null;

		// User Informationen (extern) ob wir das brauchen ?? mal schauen
		protected $userAgent = null;

		// User Operating System
		protected $userOs = null;

		// User IP ermitteln
		protected $uGetBrowser = null;

		/*	
			HTTP_HOST, HTTP_CONNECTION, HTTP_USER_AGENT, 
			HTTP_ACCEPT, HTTP_REFERER, HTTP_ACCEPT_ENCODING, 
			HTTP_ACCEPT_LANGUAGE, HTTP_ACCEPT_CHARSET, HTTP_COOKIE,
			HTTP_CLIENT_IP, HTTP_X_FORWARDED_FOR
		*/
    		protected $httpHeaders; 
    		
    		//store information from $_SERVER['HTTP_USER_AGENT']
    		private $uAgentInfo;

		/*
		ToDo:
		- setUserPort()
		- setUserAgent()
		
		- Betriebssystem-Erkennung
		- Browser-Erkennung
		- Herkunft (Land)
		- Verweis (wo kommt der User)
		- Provider
		
		- HTTP_CLIENT_IP <- doch noch mal als Erste abfrage einbauen.
		
		- Description im Kopf der Class		
		*/

		function __construct(){

			$this->uAgentInfo = $_SERVER['HTTP_USER_AGENT'];
			$this->uGetBrowser = get_browser(null, true);
			$this->setHttpHeaders();
			$this->setUserIp();
			$this->setUserAgent();
			$this->setUserOs();			

		}
		//setzen des Haeders für weitere verarbeitung 
		protected function setHttpHeaders($httpHeaders = null /*default Wert*/){

			 if(!empty($httpHeaders))
			 {
				$this->httpHeaders = $httpHeaders;
			} else 
			{
				foreach($_SERVER as $key => $value){
					if(substr($key,0,5)=='HTTP_')
					{
						$this->httpHeaders[$key] = $value; // HTTP_X_FORWARDED_FOR

					}elseif(substr($key,0,7)=='REMOTE_')
					{

						$this->httpHeaders[$key] = $value;
					}
				}
			}
		}
		
		// Ermittelung der IP
		protected function setUserIp($userIp = null /*default Wert*/){
			// "HTTP_CLIENT_IP" lass ich mal aussen vor weiß nicht was das genau ausgibt

			if(!empty($userIp))
			{
				$this->userIp = $userIp;
			} else 
			{ 
				$this->userIp = (isset($this->httpHeaders['REMOTE_ADDR'])) ? $this->httpHeaders['REMOTE_ADDR'] : null;

				if(empty($this->userIp)){
					$this->userIp = (isset($this->httpHeaders['HTTP_X_FORWARDED_FOR'])) ? $this->httpHeaders['HTTP_X_FORWARDED_FOR'] : null;
				}				
			}	

 		}

		// Ermittelung der Port
		protected function setUserPort($userPort = null /*default Wert*/){

			if(!empty($userPort))
			{
				$this->userPort = $userPort;
			} else 
			{ 
				$this->userPort = "Diese Methode ist noch nicht fertig. Ihr IP lautet: ". $this->userIp;				
			}

		}

		// Ermittelung des Browsers
		protected function setUserAgent($userAgent = null /*default Wert*/){

			if(!empty($userAgent))
			{
				$this->userAgent = $userAgent;
			} else 
			{ 	
				$this->userAgent = (!empty($this->uGetBrowser['comment']))? $this->uGetBrowser['comment'] : "unbekannt";
			}

   		}	
   		
   		//Ermittlung des Betriebssystemes
   		protected function setUserOs($userOs = null /*default Wert*/) {
   			
   			if(!empty($userOs))
   			{
   				$this->userOs = $userOs;
   			} else
   			{
   				$this->userOs = (!empty($this->uGetBrowser['platform']))? $this->uGetBrowser['platform'] : "unbekannt";
   			}
   		}

		// Rückgabe der IP
		public function getIp() {
			return $this->userIp;
		}

		// Ermittelung des Ports
		public function getPort() {
			return $this->userPort;
		}

		// Ermittelung des Browsers
		public function getUserAgent(){
			return $this->userAgent;
		}


		// Ermittelung des Betriebssystemes
		public function getUserOs(){
			return $this->userOs;
		}

	}	

?>
