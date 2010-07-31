<?php

class ExceptionalEnvironment
{
	
	private static $environment;
	
	public static function to_array()
	{		
		if (!self::$environment) {
			$env = $_SERVER;
			$vars = array("PHPSELF", "SCRIPT_NAME", "SCRIPT_FILENAME", "PATH_TRANSLATED", "DOCUMENT_ROOT", "PHP_SELF", "argv", "argc", "REQUEST_TIME");
			foreach ($vars as $var) {
				if (!isset($env[$var])) continue;
				unset($env[$var]);
			}
		
			self::$environment =  array(
		        "client" => array(
		          "name" => Exceptional::$client_name,
		          "version" => Exceptional::$version,
		          "protocol_version" => Exceptional::$protocol_version
		        ),
		        "application_environment" => array(
		          "environment" => "",
		          "env" => $env,
		          "host" => php_uname("n"),
		          "run_as_user" => self::get_username(),
		          "application_root_directory" => $_SERVER["PWD"],
		          "language" => "ruby",
		          "language_version" => "1.8.7",
		          "framework" => "",
		          "libraries_loaded" => array()
				)
	        );
		}

		return self::$environment;
	}
	
	public static function get_username() {
		$vars = array("LOGNAME", "USER", "USERNAME", "APACHE_RUN_USER");
		foreach ($vars as $var) {
			if (getenv($var)) {
				return getenv($var);
			}
		}
		return "UNKNOWN";
	}
	
}