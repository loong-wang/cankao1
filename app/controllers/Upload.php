<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#	FoxCmsBT
#	author :FoxBlue QQ:1183648628 lyoy2008@163.com
#	Copyright (c) 2015 http://www.kuaiwww.com All rights reserved.
#	classname:	Upload
#	scope:		PUBLIC

class upload extends FOX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->config('picset');
		$this->load->library('myclass');
		$this->upload_path_temp = FCPATH.'uploads/file/tmp';
		$this->upload_path = FCPATH.'uploads/file/';
		$this->upload_path_url = base_url().'uploads/file/'.date('Ym').'/';
		$this->path = $this->upload_path.'/'.date('Ym').'/';//这里使用“年-月”格式，可根据需要改为“年-月-日”格式
		if(!file_exists($this->path)){
			mkdir($this->path,0777,true);
		}
	}
	
	function upload_daimages($mo_id='') {

		if(!$this->auth->is_admins())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
			
		$path = 'uploads/mbg/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>$mo_id.'.png',
			'overwrite'=>true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
	}
	
	function upload_renz($mo_id='') {

		if(!$this->fox_scheid)
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
			
		$path = 'uploads/renz/'. $this->fox_scheid .'/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>$mo_id.'.png',
			'overwrite'=>true,
			'max_size' => 6000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >800){
				$config['width'] = 800;
				$ra=number_format((800/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
	}
	
	function upload_mbrenz($fox_scheid,$mo_id='') {

		if(!$fox_scheid)
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
			
		$path = 'uploads/renz/'. $fox_scheid .'/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>$mo_id.'.png',
			'overwrite'=>true,
			'max_size' => 15000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >800){
				$config['width'] = 800;
				$ra=number_format((800/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}
		
	}
	
	function upload_mbrenzbs($fox_scheid,$mo_id='') {

		if(!$fox_scheid)
		{
			die('无权访问此页');
		}

		//if($this->input->post('submit')) {
			
		$path = 'uploads/renz/'. $fox_scheid .'/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		if($mo_id){
			$config = array(
				'allowed_types' => 'jpg|jpeg|gif|png',
				'upload_path' => $path,
				//'encrypt_name' => false,
				'file_name'=>$mo_id.'.png',
				'overwrite'=>true,
				'max_size' => 25000
			);
			
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload(''.$mo_id.'')){
				$data['error'] = $this->upload->display_errors('<p>', '</p>');
				echo json_encode($data);
			} else {			
				$upload_data = $this->upload->data();
				
				$data['status'] = 'success';
				$data['msg']  = '上传成功!';
				//$data['file_url']  = $upload_data['file_name'];
				$data['file_url']  = $path.$upload_data['file_name'];
				
				$config = array(
					'source_image' => $upload_data['full_path'],
					'maintain_ration' => true,
				);
				//图片缩放
				$size = GetImageSize($config['source_image']);
				if ( $size[0] >800){
					$config['width'] = 800;
					$ra=number_format((800/$size[0]),1);
					$config['height']=round($size[1]*$ra);
				}

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				//指定父页面接收上传文件名的元素id
				$datas['result_field'] = 'up_name';
				exit(json_encode($data));
			}
		
			
		}
		
	}
	
	function images() {
		if(!$this->auth->is_admins())
		{
			die('无权访问此页');
		}
		//if($this->input->post('submit')) {
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->path,
			'encrypt_name' => true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($this->input->post('file'))){
			$data['info'] = $this->upload->display_errors();
			exit(json_encode($data));
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['info']  = '上传成功!';
            $data['img']  = $upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >$this->config->item('upimgw')){
				$config['width'] = $this->config->item('upimgw');
				$ra=number_format(($this->config->item('upimgw')/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        $datas['result_field'] = 'up_name';

			exit(json_encode($data));
			
		}

		//}
		
	}

	function upload_pic($node_id='') {

		if(!$this->auth->is_admin())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
			
		$path = 'uploads/ico/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $path,
			'encrypt_name' => false,
			'file_name'=>$node_id.'.png',
			'overwrite'=>true,
			'max_size' => 2000,
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >72){
				$config['width'] = 72;
				$ra=number_format((72/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
	}
	
	function upload_mulu($t_id='',$mulu='word') {

		if(!$this->auth->is_admin())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
			
		$path = 'uploads/'.$mulu.'/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $path,
			'encrypt_name' => false,
			'file_name'=>$t_id.'.png',
			'overwrite'=>true,
			'max_size' => 2000,
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			$size = GetImageSize($config['source_image']);
			if ( $size[0] >300){
				$config['width'] = 300;
				$ra=number_format((300/$size[0]),1);
	  			$config['height']=round($size[1]*$ra);
			}

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
	}
	
	function upload_ads() {

		if(!$this->auth->is_admins())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
		$file=$this->_get_file_path(@$_FILES['img']['name']);
		$path = 'uploads/ads/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'gif|jpg|jpeg|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>@$file['new_file_name'],
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
            
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
	}
	
	function upload_filest() {
		if(!$this->auth->is_login())
		{
			die('无权访问此页');
		}
		$path = 'uploads/image/'.date('Ym').'/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		header('content-type:text/html charset:utf-8');
		header("Access-Control-Allow-Origin:*");
		$file = $_POST["file"];
		list($type, $data) = explode(',', $file);
		// 判断类型
		if(strstr($type,'image/jpeg')!==''){
			$ext = '.jpg';
		}elseif(strstr($type,'image/gif')!==''){
			$ext = '.gif';
		}elseif(strstr($type,'image/png')!==''){
			$ext = '.png';
		}else{
			echo '图片格式不正确';
			exit;
		}
		$data = base64_decode(str_replace('data:image/png;base64,', '', $file));  //截图得到的只能是png格式图片，所以只要处理png就行了
		$name = md5(time()) . '.png';  // 这里把文件名做了md5处理
		$names=$path_url.$name;
		file_put_contents($names, $data);
		
		$fileurl=$path_url.$name;
		//缩略一下
		$wwater_info = getimagesize($fileurl);
		$wwater_w = $wwater_info[0];//取得水印图片的宽
		$wwater_h = $wwater_info[1];//取得水印图片的高
		if ($wwater_w >$this->config->item('upimgw')){
			$this->myclass->makeThumbnail($fileurl,$fileurl,$this->config->item('upimgw'),0,true); 
		}
		if($wwater_w>=$this->config->item('waterw')&&$wwater_h>=$this->config->item('waterh')&&$this->config->item('is_warterok')=='on'){
			$waterImage=$_SERVER['DOCUMENT_ROOT']."/".$this->config->item('water');//水印图片路径
			$this->myclass->FoximageWaterMark($fileurl,$this->config->item('waterz'),$waterImage);
		}
				
		echo base_url().$path.$name;
		exit;
	}
	
	function upload_filess() {
		if(!$this->auth->is_login())
		{
			die('无权访问此页');
		}
		$path = 'uploads/image/'.date('Ym').'/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		header('content-type:text/html charset:utf-8');
		header("Access-Control-Allow-Origin:*");
		$file = $_POST["file"];
		// 获取图片
		list($type, $data) = explode(',', $file);
		// 判断类型
		if(strstr($type,'image/jpeg')!==''){
			$ext = '.jpg';
		}elseif(strstr($type,'image/gif')!==''){
			$ext = '.gif';
		}elseif(strstr($type,'image/png')!==''){
			$ext = '.png';
		}else{
			echo '图片格式不正确';
			exit;
		}
		// 生成的文件名
		$photo = md5(time()).$ext;
		$names=$path_url.$photo;

		// 生成文件
		file_put_contents($names, base64_decode($data), true);
		
		$fileurl=$path_url.$photo;
		//缩略一下
		$wwater_info = getimagesize($fileurl);
		$wwater_w = $wwater_info[0];//取得水印图片的宽
		$wwater_h = $wwater_info[1];//取得水印图片的高
		if ($wwater_w >$this->config->item('upimgw')){
			$this->myclass->makeThumbnail($fileurl,$fileurl,$this->config->item('upimgw'),0,true); 
		}
		if($wwater_w>=$this->config->item('waterw')&&$wwater_h>=$this->config->item('waterh')&&$this->config->item('is_warterok')=='on'){
			$waterImage=$_SERVER['DOCUMENT_ROOT']."/".$this->config->item('water');//水印图片路径
			$this->myclass->FoximageWaterMark($fileurl,$this->config->item('waterz'),$waterImage);
		}

		// 返回
		$ret = 'img|'.base_url().$path.$photo;
		echo json_encode($ret);
		exit;
	}
	
	function upload_filesd() {
		header('content-type:text/html charset:utf-8');
		if(!$this->auth->is_login())
		{
			die('无权访问此页');
		}
		
		$file=$this->_get_file_path(@$_FILES['file']['name']);
		$path = @$file['file_path'];
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'gif|jpg|jpeg|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>@$file['new_file_name'],
			'overwrite'=>true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('file')){
			echo $this->upload->display_errors('', '');
		} else {
			
			$upload_data = $this->upload->data();
           
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			if(in_array(@$file['file_ext'], array('gif','jpg','jpeg','png'))){
				$size = GetImageSize($config['source_image']);
				if ( $size[0] >$this->config->item('upimgw')){
					$config['width'] = $this->config->item('upimgw');
					$ra=number_format(($this->config->item('upimgw')/$size[0]),1);
		  			$config['height']=round($size[1]*$ra);
				}

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}
			$fileurl=$path_url.$upload_data['file_name'];
			$wwater_info = getimagesize($fileurl);
			$wwater_w = $wwater_info[0];//取得水印图片的宽
			$wwater_h = $wwater_info[1];//取得水印图片的高
			if($wwater_w>=$this->config->item('waterw')&&$wwater_h>=$this->config->item('waterh')&&$this->config->item('is_warterok')=='on'){
				$waterImage=$_SERVER['DOCUMENT_ROOT']."/".$this->config->item('water');//水印图片路径
				$this->myclass->FoximageWaterMark($fileurl,$this->config->item('waterz'),$waterImage);
			}
			echo "<textarea>ok|".base_url().$path.$upload_data['file_name']."</textarea>";
		}
	}

	function upload_file() {

		if(!$this->auth->is_login())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
		$file=$this->_get_file_path(@$_FILES['file']['name']);
		$path = @$file['file_path'];
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'gif|jpg|jpeg|png|tiff|swf|flv|mp3|wav|wma|wmv|mid|avi|mpg|asf|rm|rmvb|doc|docx|xls|xlsx|ppt|txt|zip|rar|gz|bz2',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>@$file['new_file_name'],
			'overwrite'=>true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('file')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {
			
			$upload_data = $this->upload->data();
			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
           
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			if(in_array(@$file['file_ext'], array('gif','jpg','jpeg','png','tiff'))){
				$size = GetImageSize($config['source_image']);
				if ( $size[0] >$this->config->item('upimgw')){
					$config['width'] = $this->config->item('upimgw');
					$ra=number_format(($this->config->item('upimgw')/$size[0]),1);
		  			$config['height']=round($size[1]*$ra);
				}

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}

			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
		
	}
	
	function upload_excel() {

		if(!$this->auth->is_login())
		{
			die('无权访问此页');
		}
		
		//print_r($_FILES['file']['name']);
		$file=$this->_get_file_path(@$_FILES['file']['name']);
		$path = 'uploads/excel/';
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'tmp|xls|xlsx|csv',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>@$file['new_file_name'],
			'overwrite'=>true,
			'max_size' => 20000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('file')){
			$data['error'] = $this->upload->display_errors('<p>', '</p>');
			echo json_encode($data);
		} else {			
			$upload_data = $this->upload->data();			
			$pathinfo = pathinfo(FCPATH.$path.$upload_data['file_name']);
			//设置php服务器可用内存，上传较大文件时可能会用到
			if( strtolower($pathinfo[extension])!='csv'){
				$data['msg']  = '上传成功，需要进行格式转换……';
				require_once(APPPATH.'third_party/PHPExcel/IOFactory.php');
				ini_set('memory_limit', '1024M');	
				$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
				$cacheSettings = array( ' memoryCacheSize '  => '8MB');
				PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
				$objPHPExcel = PHPExcel_IOFactory::load(FCPATH.$path.$upload_data['file_name']);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
				$filename=str_replace('.xlsx', '.csv',$upload_data['file_name']);
				$filename=str_replace('.xls', '.csv',$filename);
				$objWriter->save(FCPATH.$path.$filename);
				$data['url']  = $path.$filename;				
				unlink(FCPATH.$path.$upload_data['file_name']);
				echo json_encode($data);
			}else{
				$data['msg']  = '上传成功!';
				$data['url']  = $path.$upload_data['file_name'];
				echo json_encode($data);
			}	
			
		}

		//}
		
		
	}
	
	function upload_images() {

		if(!$this->auth->is_login())
		{
			die('无权访问此页');
		}
		
		//if($this->input->post('submit')) {
		$file=$this->_get_file_path(@$_FILES['file']['name']);
		$path = @$file['file_path'];
		$path_url=FCPATH.$path;
		if(!file_exists($path_url)){
			mkdir($path_url,0777,true);
		}
		$config = array(
			'allowed_types' => 'gif|jpg|jpeg|png',
			'upload_path' => $path,
			//'encrypt_name' => false,
			'file_name'=>@$file['new_file_name'],
			'overwrite'=>true,
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('file')){
			$data['error'] = $this->upload->display_errors();
			echo json_encode($data);
		} else {
			
			$upload_data = $this->upload->data();			
            $data['status'] = 'success';
            $data['msg']  = '上传成功!';
            //$data['file_url']  = $upload_data['file_name'];
            $data['file_url']  = $path.$upload_data['file_name'];
           
			$config = array(
				'source_image' => $upload_data['full_path'],
				'maintain_ration' => true,
			);
			//图片缩放
			if(in_array(@$file['file_ext'], array('gif','jpg','jpeg','png','tiff'))){
				$size = GetImageSize($config['source_image']);
				if ( $size[0] >$this->config->item('upimgw')){
					$config['width'] = $this->config->item('upimgw');
					$ra=number_format(($this->config->item('upimgw')/$size[0]),1);
		  			$config['height']=round($size[1]*$ra);
				}

				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}

			//指定父页面接收上传文件名的元素id
        	$datas['result_field'] = 'up_name';
			exit(json_encode($data));
			
		}

		//}
		
		
	}
	
	function get_images() {
		
		
		//return $images;
	}

	
//	function get_images() {
//		
//		$files = scandir($this->path);
//		$files = array_diff($files, array('.', '..', 'thumbs'));
//		
//		$images = array();
//		
//		foreach ($files as $file) {
//			$images []= array (
//				'url' => $this->upload_path_url . $file,
//				'thumb_url' => $this->upload_path_url . 'thumbs/' . $file
//			);
//		}
//		
//		return $images;
//	}
	

	public function qiniu()
	{
		$this->config->load('qiniu');
		$params =array(
			'accesskey'=>$this->config->item('accesskey'),
			'secretkey'=>$this->config->item('secretkey'),
			'bucket'=>$this->config->item('bucket'),
			'file_domain'=>$this->config->item('file_domain').'/',	
		);
		$this->load->library('qiniu_lib',$params);
		$file=$this->_get_file_path(@$_FILES['file']['name']);
		$new=$this->qiniu_lib->uploadfile(@$file['file_path_url']);
		if (!empty($_FILES)) {
			echo json_encode($new);
		}else{
			$data['title'] = '七牛上传图片测试';
			$this->load->view('qiniu_v',$data);
		}
	}

	function _get_file_path($file){
		//定义允许上传的文件扩展名
		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png','tiff'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		//获得文件扩展名
		$info = pathinfo($file);
		$info['extension']=strtolower($info['extension']);
		$data['file_ext'] = $info['extension']?$info['extension']:'';
		//新文件名
		$data['new_file_name'] = date("YmdHis") . '_' . rand(1, 99999) . '.' . $data['file_ext'];
		$data['folder']=in_array($data['file_ext'],$ext_arr['image'])?'image':(in_array($data['file_ext'],$ext_arr['media'])?'media':'file');
		$data['file_path']='uploads/'.$data['folder'].'/'.date("Ym").'/';
		$data['file_path_url']=$data['file_path'].$data['new_file_name'];
		return $data;
	}


}
