<?
fdownload('goods_example_pro.csv', 'goods_example_pro.csv', '../upload/csv', 'csv');
function fdownload($file_name, $file_save_name, $file_path, $file_type)
{
	global $_SERVER;
	if(@fopen($file_path."/".$file_save_name,"r"))
	{
		if(is_int(strpos($file_type, 'image')) || is_int(strpos($file_type, 'text')))
		{
			header("Content-type: $file_type");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		else
		{
			if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $_SERVER[HTTP_USER_AGENT]))
			{
				Header("Content-type: application/octet-stream");
				Header("Content-Length: ".filesize($file_path."/".$file_save_name));
				Header("Content-Disposition: attachment; filename=$file_name");
				Header("Content-Transfer-Encoding: binary");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
			else
			{
				Header("Content-type: file/unknown");
				Header("Content-Length: ".filesize($file_path."/".$file_save_name));
				Header("Content-Disposition: attachment; filename=$file_name");
				Header("Content-Description: PHP3 Generated Data");
				Header("Pragma: no-cache");
				Header("Expires: 0");
			}
		}
		$fp = fopen($file_path."/".$file_save_name, "rb");
		while(!feof($fp))
		{
			echo fread($fp, 100*1024);
			flush();
		}
		fclose ($fp);
	}
}
?>