<?php
class Daohao extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model ('zifei_m');
		$this->load->model ('city_m');
		$this->load->model ('haoma_m');
		$this->load->config('haoset');
		$this->config->load('cityset');
		$this->load->library('myclass');
		$this->load->library('form_validation');
	}
	public function index()
	{
		redirect(site_url('admin/daohao/daoru'));
	}
	
	public function getpinpai()
	{
		$city=$this->input->post('city');
		if($city){
			$pinpai=$this->zifei_m->get_all_pinpai_by_city($city);
			if($pinpai){
				foreach($pinpai as $k => $v){
					echo '<label><input name="hao_pinpai" type="radio" class="ace" value="'.$v['id'].'">';
					echo '<span class="lbl"> '.$v['pin_title'].'</span></label>';
				}
			}else{
				echo '<font color="red">未找到，加载失败</font>';
			}
			
		}else{
			echo '<font color="red">品牌加载失败</font>';
		}		
	}
	
	public function daoru()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '批量导入号码';
			$data['siderbar'] = 'admin/daohao';
			$data['submenu'] = 'admin/daohao/daoru';

			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
			}			
			$this->load->view('hao_daoru', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function daorucome($hao_city='',$hao_type='',$hao_excel='',$page=1)
	{

		$masterurl='admin/daohao/daoru';
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '批量导入号码';	
			$data['hao_city'] = $hao_city;	
			$data['hao_type'] = $hao_type;	
			$data['hao_excel'] = str_replace('fox','/',$hao_excel);
			$handle = fopen(FCPATH.$data['hao_excel'], 'r'); 
			$result = $this->haoma_m->input_csv($handle); //解析csv 
			$len_result = count($result); 
			/** 循环读取每个单元格的数据 */
			$limit=5000;
			$start = ($page-1)*$limit;
			if($page==1){
				$nums=$start+2;
			}else{
				$nums=$start+1;
			}
			$starts = $limit*$page;
			if($starts>$len_result){
				$starts = $len_result;
			}
			for ($i = $start; $i < $starts; $i++) { //循环获取各字段值 
				if(!empty($result[$i][1])&&isset($result[$i][1])){
					$hao_pinpai = ($result[$i][0])?$result[$i][0]:0; 
					$hao_title = ($result[$i][1])?$result[$i][1]:0; 
					$hao_jiage = intval(($result[$i][2]))?intval($result[$i][2]):0; 
					$hao_huafei = intval(($result[$i][3]))?intval($result[$i][3]):0;
					if($result[$i][4]){
        		        $encode = mb_detect_encoding($result[$i][4], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5','EUC-CN'));
        		        if($encode != 'UTF-8'){
        		            $result[$i][4]=iconv($encode,'UTF-8',$result[$i][4]);
        		        }
        		    }
					$hao_heyue = ($result[$i][4])?$result[$i][4]:''; //中文转码 
					$hao_beizhu = ($result[$i][5])?$result[$i][5]:''; //中文转码 
					$hao_user = ($result[$i][6])?$result[$i][6]:''; 
					$hao_time = time();
					$data_values .= "($hao_city,$hao_type,$hao_pinpai,'$hao_title',$hao_jiage,$hao_huafei,'$hao_heyue','$hao_beizhu','$hao_user',$hao_time),"; 
					$data_users .= "$hao_user,"; 
				}
			} 
			if($start<$len_result){
				$data_values = substr($data_values,0,-1); //去掉最后一个逗号 
				$data_users = array_unique(explode(',', substr($data_users,0,-1)));
				foreach($data_users as $v){
					$this->haoma_m->check_username(trim($v),$hao_city);
				}
				if ($this->db->query("insert into `{$this->db->dbprefix}haoma` (hao_city,hao_type,hao_pinpai,hao_title,hao_jiage,hao_huafei,hao_heyue,hao_beizhu,hao_user,hao_time) values $data_values"))
				{			
					$this->db->query("delete from `{$this->db->dbprefix}haoma` where id in (select * from (select min(id) from `{$this->db->dbprefix}haoma` group by hao_title having count(hao_title) > 1) as b)");
					$data['page']=$page;
					$data['pages']=ceil($len_result/$limit); 
					$data['hao_excels']=str_replace('/','fox',$data['hao_excel']);
					$data['location'] = site_url('admin/daohao/daorucome/'.$data['hao_city'].'/'.$data['hao_type'].'/'.$data['hao_excels'].'/'.($data['page']+1));
				}
				else
				{
					echo "导入异常停止!";
				}
				fclose($handle); //关闭指针 
			}else{
				$data['page']=0;
			}
			$this->load->view('hao_daorucom', $data);
			
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}
	
	public function get_hao_by_dc()
	{
		$hao_user=$this->input->post('hao_user');
		$hao_city=$this->input->post('hao_city');
		$hao_timea=$this->input->post('hao_timea');
		$hao_timeb=$this->input->post('hao_timeb');
		$hao_type=$this->input->post('hao_type');
		$count = $this->haoma_m->get_count_by_dc($hao_user,$hao_city,$hao_timea,$hao_timeb,$hao_type);
		echo $count;
	}
	
	public function dc_hao_by_dc()
	{
		
		$hao_user=$this->input->post('hao_user');
		$hao_city=$this->input->post('hao_city');
		$hao_timea=$this->input->post('hao_timea');
		$hao_timeb=$this->input->post('hao_timeb');
		$hao_type=$this->input->post('hao_type');
		$hao_ex=$this->input->post('hao_ex');
		if($this->haoma_m->get_list_by_dc($hao_user,$hao_city,$hao_timea,$hao_timeb,$hao_type)){
			$data=$this->haoma_m->get_list_by_dc($hao_user,$hao_city,$hao_timea,$hao_timeb,$hao_type);
			$fileName = "haoma_excel";
			$dates = date("Ymd_His",time());
			$Path='uploads/excel/';
			$savePath=FCPATH.'uploads/excel/';
			$headArr = array("品牌","号码","底价","话费","低消","备注","卖家");
			$ex=$hao_ex;
			if($ex=='2003'){
				$files = $fileName."_".$dates.".xls";
			}elseif($ex=='2007'){
				$files = $fileName."_".$dates.".xlsx";
			}
			getExcel($fileName,$headArr,$data,$ex,$dates,$savePath);
			$arr['success'] = 1;
			$arr['msg'] = '<a target="_blank" href="'.base_url($Path.$files).'">点击下载</a>';
		}else{
			$arr['success'] = 0;
			$arr['msg'] = '';
		}		
		echo json_encode($arr);
	}	
	
	
	public function daochu()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '批量导出号码';
			$data['siderbar'] = 'admin/daohao';
			$data['submenu'] = 'admin/daohao/daochu';

			$data['citys'] = $this->city_m->get_city_all_list();
			if($this->session->userdata('ucity')>0){
				$data['pinpai_list'] =$this->zifei_m->get_all_pinpai_by_city($this->session->userdata('ucity'));
			}			
			$this->load->view('hao_daochu', $data);
			
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
	}

}