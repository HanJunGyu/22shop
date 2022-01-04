<?
if(!defined("__INCLUDE_CONFIG_PHP"))
{
	define("__INCLUDE_CONFIG_PHP",1);

	require_once "db_info.php";
	require_once "db_conn.php";

	$MySQL = new MySQL();
	$MySQL->db_connect($arrDBINFO);

	$SENDMAIL_PATH = "/usr/lib/sendmail";

	define("__DEMOPAGE", "0");	//데모페이지는 1

	if(__DEMOPAGE == 1)
	{
		$demo_readonly = "readonly style='background-color:#eeeeee'";
	}

	if(!empty($HTTP_GET_VARS)) $_GET = $HTTP_GET_VARS;
	if(!empty($HTTP_POST_VARS)) $_POST = $HTTP_POST_VARS;
	if(!empty($HTTP_COOKIE_VARS)) $_COOKIE = $HTTP_COOKIE_VARS;
	if(!empty($HTTP_SESSION_VARS)) $_SESSION= $HTTP_SESSION_VARS;
	if(!empty($HTTP_POST_FILES)) $_FILES = $HTTP_POST_FILES;
	if(!empty($HTTP_SERVER_VARS)) $_SERVER = $HTTP_SERVER_VARS;
	if(!empty($HTTP_ENV_VARS)) $_ENV = $HTTP_ENV_VARS;

	if(count($_GET)) extract($_GET);
	if(count($_POST)) extract($_POST);
	if(count($_SERVER)) extract($_SERVER);
	if(count($_SESSION)) extract($_SESSION);
	if(count($_COOKIE)) extract($_COOKIE);
	if(count($_FILES))
	{
		while(list($key,$value)=each($_FILES))
		{
			$$key = $_FILES[$key][tmp_name];
			$str = "$key"."_name";
			$$str = $_FILES[$key][name];
			$str = "$key"."_size";
			$$str = $_FILES[$key][size];
		}
	}
}
?>