<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cache extends FOX_Controller {

	function __construct()
    {
        parent::__construct();
	}
	function index()
	{
		//$this->cache->clean();
      $this->delfile(APPPATH.'cache',2);
	}
  
   public function delfile($dir,$n) //删除DIR路径下N天前创建的所有文件;
  {
  if(is_dir($dir))
    {
   if($dh=opendir($dir))
     {
      while (false !== ($file = readdir($dh))) 
      {
       if($file!="." && $file!="..") 
       {
         $fullpath=$dir."/".$file;
         if(!is_dir($fullpath)) 
         {            
          $filedate=date("Y-m-d", filemtime($fullpath)); 
          $d1=strtotime(date("Y-m-d"));
          $d2=strtotime($filedate);
          $Days=round(($d1-$d2)/3600/24); 
          if($Days>$n)
          unlink($fullpath);  ////删除文件

           }
       }      
      }
     }
     closedir($dh); 
   }
  }
}