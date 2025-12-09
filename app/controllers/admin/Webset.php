<?php
class Webset extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('myclass');
		$this->load->library('form_validation');
		$this->config->load('mobanset');
	}

	public function index()
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '设置';
		$data['siderbar'] = 'webset';
		$data['submenu'] = 'webset';
		redirect(site_url('admin/webset/allset'));
	}
	
	public function delcaches()
	{
		/** 检查登陆 */
		if(!$this->auth->is_admin())
		{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$data['title'] = '设置';
		$data['siderbar'] = 'webset';
		$data['submenu'] = 'webset';
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$this->cache->clean();
		show_message('清理全站缓存成功',site_url('admin/login'),1);
	}
	
	
	
	public function allset()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '通用配置';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/webset/allset';
			if($_POST){
				if($this->input->post('moban_list')){
					if(strstr($this->input->post('moban_list'), '|')){
						foreach(explode("|",$this->input->post('moban_list')) as $mb){
							if(!is_dir(APPPATH.'views/'.$mb)){
								show_message('请检查是否有不存在的模板目录');
							}
						}
					}else{
						if(!is_dir(APPPATH.'views/'.$this->input->post('moban_list'))){
							show_message('模板目录并不存在，请检查');
						}
					}
				}
				$config['site_name'] = $this->input->post('site_name');
				$config['site_domain'] = $this->input->post('site_domain');
				$config['dsfox_domain'] = $this->input->post('dsfox_domain');
				$config['site_keywords'] = $this->input->post('site_keywords');
				$config['site_description'] = $this->input->post('site_description');
				$config['site_search'] = $this->input->post('site_search');
				$config['sub_folder'] = $this->input->post('sub_folder');
				$config['themes'] = $this->input->post('themes');
				$config['adminthemes'] = $this->input->post('adminthemes');
				$config['weblogo'] = $this->input->post('weblogo');
				$config['telpic'] = $this->input->post('telpic');
				$config['wxpic'] = $this->input->post('wxpic');
				$config['encryption_key'] = $this->input->post('encryption_key');
				$config['webtel'] = $this->input->post('webtel');
				$config['webqq'] = $this->input->post('webqq');
				$config['webdress'] = $this->input->post('webdress');
				$config['fahuo_type'] = $this->input->post('fahuo_type');
				$config['shoukuan_type'] = $this->input->post('shoukuan_type');
				$config['kuaidi_type'] = $this->input->post('kuaidi_type');
				$config['is_rewrite'] = $this->input->post('is_rewrite');
				if($this->input->post('is_rewrite')=='on'){
					$config['index_page']='';
				} else {
					$config['index_page']='index.php';
				}
				$config['show_captcha'] = $this->input->post('show_captcha');
				$config['is_guest'] = $this->input->post('is_guest');
				$config['is_member'] = $this->input->post('is_member');
				$config['is_ip'] = $this->input->post('is_ip');
				$config['site_stats'] = $this->input->post('site_stats');
				$config['webnums'] = $this->input->post('webnums');
				$config['beian'] = $this->input->post('beian');
				$config['zhan_email'] = $this->input->post('zhan_email');
				$config['zhan_tel'] = $this->input->post('zhan_tel');
				$config['zhan_email_me'] = $this->input->post('zhan_email_me');
				$config['zhan_shouji_me'] = $this->input->post('zhan_shouji_me');
				$this->config->set_item('webset', $config);
				$this->config->save('webset',$config);
				if(!in_array($this->input->post('site_domain'),explode("|",$this->config->item('site_domains')))){
					$site_domains=$this->config->item('site_domains').$this->input->post('site_domain').'|';
					$this->config->update('domainset','site_domains', $site_domains);
				}
				if($this->input->post('moban_list')){
					$this->config->update('mobanset','moban_list', $this->input->post('moban_list'));
				}
				show_message('通用配置更新成功',site_url('admin/webset/allset'),1);
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		
		$this->load->view('webset_allset', $data);
	}
	
	public function email()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '邮箱配置';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/webset/email';
			$this->load->config('mailset');
			if($_POST){
				$config['mail_type'] = $this->input->post('mail_type');
				$config['smtp_host'] = $this->input->post('smtp_host');
				$config['smtp_port'] = ($this->input->post('smtp_port'))?$this->input->post('smtp_port'):'25';
				$config['smtp_user'] = $this->input->post('smtp_user');
				$config['smtp_pass'] = $this->input->post('smtp_pass');
				$config['mail_reg'] = $this->input->post('mail_reg');
				$config['mail_order'] = $this->input->post('mail_order');
				$config['mail_order_me'] = $this->input->post('mail_order_me');
				$config['mail_question'] = $this->input->post('mail_question');
				
				$this->config->set_item('mailset', $config);
				$this->config->save('mailset',$config);
				show_message($data['title'].'更新成功',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		
		$this->load->view('webset_mailset', $data);
	}
	
	public function sendemail()
	{
		if($this->auth->is_admin()){
			$this->load->config('mailset');
			$toemail=$this->input->post('toemail');
			$subject='这是一封来自'.$this->config->item('site_name').'的测试邮件';
			$message='接收邮箱为'.$toemail.'<br/>您不必要回复此邮件<br/><br/>-- <br/>'.$this->config->item('site_name').'即将上线';
			send_mail($toemail,$subject,$message);
			echo '发送成功，稍候请查看邮箱['.$toemail.']是否接收到';
		}
	}
	
	public function pay()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '支付设置';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/webset/pay';
			$this->load->config('cityset');
			$this->load->config('payset');
			if($_POST){
				if( is_array($this->input->post('city_pays'))){
					$city_pays=implode(',',$this->input->post('city_pays'));
				}else{
					$city_pays=$this->input->post('city_pays');
				}
				$config['city_pays'] = $city_pays;
				$config['ali_payemail'] = $this->input->post('ali_payemail');
				$config['ali_payid'] = $this->input->post('ali_payid');
				$config['ali_paykey'] = $this->input->post('ali_paykey');
				$config['ali_paytype'] = $this->input->post('ali_paytype');
				$config['wx_appid'] = $this->input->post('wx_appid');
				$config['wx_mchid'] = $this->input->post('wx_mchid');
				$config['wx_key'] = $this->input->post('wx_key');
				$config['wx_appsecret'] = $this->input->post('wx_appsecret');
				
				$this->config->set_item('payset', $config);
				$this->config->save('payset',$config);
				show_message($data['title'].'更新成功',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		
		$this->load->view('webset_payset', $data);
	}
	
	public function sms()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '短信接口';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/webset/sms';
			$this->load->config('smsset');
			if($_POST){
				if( is_array($this->input->post('city_pays'))){
					$city_pays=implode(',',$this->input->post('city_pays'));
				}else{
					$city_pays=$this->input->post('city_pays');
				}
				
				$config['sms_type'] = $this->input->post('sms_type');
				$config['sms_user'] = $this->input->post('sms_user');
				$config['sms_key'] = $this->input->post('sms_key');
				$config['sms_moban_jihuo'] = $this->input->post('sms_moban_jihuo');
				$config['sms_moban_order'] = $this->input->post('sms_moban_order');
				$config['sms_moban_order_me'] = $this->input->post('sms_moban_order_me');
				$config['shouji_order'] = $this->input->post('shouji_order');
				$config['shouji_order_me'] = $this->input->post('shouji_order_me');
				
				$this->config->set_item('smsset', $config);
				$this->config->save('smsset',$config);
				show_message($data['title'].'更新成功',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		
		$this->load->view('webset_smsset', $data);
	}
	
	public function sendsms()
	{
		if($this->auth->is_admin()){
			$this->load->config('smsset');
			$shouji=$this->input->post('shouji');
			if(checkMobile($shouji) && $this->config->item('sms_type')=='on'){  
				$shoujbody = str_replace('【变量】','【'.$shouji.'】',$this->config->item('sms_moban_jihuo'));
				if(SendShouji($this->config->item('sms_user'),$this->config->item('sms_key'),$shouji,$shoujbody,date('Y-m-d H:i:s',time()))){
					echo '发送成功，稍候请查看['.$shouji.']是否接收到';
				}else{
					echo '失败，请检查是否开启发送或手机号：'.$shouji;
				}				
			}else{
				echo '失败，请检查是否开启发送或手机号：'.$shouji;
			}
		}
	}
	
	private function validate_zhana_form(){
		$this->form_validation->set_rules('cname', '城市名称' , 'trim|required|min_length[1]|max_length[10]|xss_clean');
		$this->form_validation->set_rules('ctitle', '网站标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('cnums', '默认系数' , 'trim|required|numeric');
		$this->form_validation->set_rules('sid', '省区' , 'trim|required|integer');
		$this->form_validation->set_rules('ctel', '电话' , 'trim|required');
		$this->form_validation->set_rules('cqq', 'QQ' , 'trim|required');
		$this->form_validation->set_rules('cdomain', '域名' , 'trim|required|valid_url');
		$this->form_validation->set_rules('cthemes', '网站模板' , 'trim|min_length[2]|max_length[50]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function city_name_check($str)
	{  
		$this->load->model('city_m');
		if($this->city_m->city_name_check($str)){
			$this->form_validation->set_message('city_name_check', '%s 已经存在，不能重复');
  			return false;
		} else{
			return true;
		}
	}
	
	public function zhana()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '主站设置';
			$data['siderbar'] = 'admin/webset';
			$data['submenu'] = 'admin/webset/zhana';
			$this->load->model('city_m');
			$this->load->config('cityset');
			$data['shengji'] = $this->config->item('shengji');
			$city = $this->city_m->get_city_moren(1);
			if(!$city){
				$data['city']['sid'] = 100;
				$data['city']['cname'] = '';
				$data['city']['cowner'] = '';
				$data['city']['cdomain'] = $this->config->item('site_domain');
				$data['city']['clogo'] = $this->config->item('weblogo');
				$data['city']['ctelpic'] = $this->config->item('telpic');
				$data['city']['ctitle'] = $this->config->item('site_name');
				$data['city']['ckeywords'] = $this->config->item('site_keywords');
				$data['city']['cdescription'] = $this->config->item('site_description');
				$data['city']['cthemes'] = $this->config->item('themes');
				$data['city']['cnums'] = $this->config->item('webnums');
				$data['city']['ctel'] = $this->config->item('webtel');
				$data['city']['cqq'] = $this->config->item('webqq');
				$data['city']['cdress'] = $this->config->item('webdress');
				$data['city']['cbeian'] = $this->config->item('beian');
				$data['city']['cstats'] = $this->config->item('site_stats');
				$data['city']['cz_email'] = $this->config->item('zhan_email');
				$data['city']['cz_tel'] = $this->config->item('zhan_tel');
				$data['city']['cz_email_me'] = $this->config->item('zhan_email_me');
				$data['city']['cz_shouji_me'] = $this->config->item('zhan_shouji_me');
				$data['city']['cz_search'] = $this->config->item('site_search');
				$data['city']['cz_memu'] = '';
			}else{
				$data['city']=$city;
			}		
			if($_POST && $this->validate_zhana_form()){
				$stitle='';
				foreach(explode("|",$data['shengji']) as $k =>$s){
					if($k==$this->input->post('sid')){
						$stitle=$s;
					}
				}
				if( is_array($this->input->post('cz_memu'))){
					$cz_memu=implode(',',$this->input->post('cz_memu'));
				}else{
					$cz_memu=$this->input->post('cz_memu');
				}
				$str = array(
					'sid'=>$this->input->post('sid'),
					'stitle'=>$stitle,
					'sabc'=>getFirstCharter($stitle),
					'cname'=>$this->input->post('cname'),
					'cabc'=>getFirstCharter($this->input->post('cname')),
					'ctitle'=>$this->input->post('ctitle'),
					'ckeywords'=>$this->input->post('ckeywords'),
					'cdescription'=>$this->input->post('cdescription'),
					'cthemes'=>$this->input->post('cthemes'),
					'cnums'=>$this->input->post('cnums'),
					'ctel'=>$this->input->post('ctel'),
					'cqq'=>$this->input->post('cqq'),
					'cdress'=>$this->input->post('cdress'),
					'cbeian'=>$this->input->post('cbeian'),
					'cstats'=>$this->input->post('cstats'),
					'clogo'=>$this->input->post('clogo_a'),
					'ctelpic'=>$this->input->post('ctelpic_a'),
					'cdomain'=>$this->input->post('cdomain'),
					'cowner'=>$this->input->post('cowner'),
					'cz_email'=>$this->input->post('cz_email'),
					'cz_tel'=>$this->input->post('cz_tel'),
					'cz_email_me'=>$this->input->post('cz_email_me'),
					'cz_shouji_me'=>$this->input->post('cz_shouji_me'),
					'cz_search'=>$this->input->post('cz_search'),
					'cz_memu'=>$cz_memu,
					'cmoren'=>1,
					'ctime'=>time(),
				);
				if(!$city){
					$this->city_m->add_city($str);
				}else{
					$this->city_m->update_city_moren(1,$str);
				}
				if(!in_array($this->input->post('cdomain'),explode("|",$this->config->item('site_domains')))){
					$site_domains=$this->config->item('site_domains').$this->input->post('cdomain').'|';
					$this->config->update('domainset','site_domains', $site_domains);
				}
				show_message($data['title'].'更新成功！',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
				
		$this->load->view('webset_zhana', $data);
	}
	
	private function validate_zhanb_add_form(){
		$this->form_validation->set_rules('cname', '城市名称' , 'trim|required|min_length[1]|max_length[10]|callback_city_name_check|xss_clean');
		$this->form_validation->set_rules('ctitle', '网站标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('cnums', '默认系数' , 'trim|required|numeric');
		$this->form_validation->set_rules('sid', '省区' , 'trim|required|integer');
		$this->form_validation->set_rules('ctel', '电话' , 'trim|required');
		$this->form_validation->set_rules('cqq', 'QQ' , 'trim|required');
		$this->form_validation->set_rules('cdomain', '域名' , 'trim|required|valid_url');
		$this->form_validation->set_rules('cthemes', '网站模板' , 'trim|min_length[2]|max_length[50]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function zhanb_add()
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$data['title'] = '增加分站';
			$data['siderbar'] = 'webset';
			$data['submenu'] = 'admin/webset/zhanb';
			$this->load->model('city_m');
			$this->load->config('cityset');
			$data['shengji'] = $this->config->item('shengji');
			$data['city']['sid'] = 100;
			$data['city']['cname'] = '';
			$data['city']['cowner'] = '';
			$data['city']['cdomain'] = $this->config->item('site_domain');
			$data['city']['clogo'] = $this->config->item('weblogo');
			$data['city']['ctelpic'] = $this->config->item('telpic');
			$data['city']['cwxpic'] = $this->config->item('wxpic');
			$data['city']['ctitle'] = $this->config->item('site_name');
			$data['city']['ckeywords'] = $this->config->item('site_keywords');
			$data['city']['cdescription'] = $this->config->item('site_description');
			$data['city']['cthemes'] = $this->config->item('themes');
			$data['city']['cnums'] = $this->config->item('webnums');
			$data['city']['ctel'] = $this->config->item('webtel');
			$data['city']['cqq'] = $this->config->item('webqq');
			$data['city']['cdress'] = $this->config->item('webdress');
			$data['city']['cbeian'] = $this->config->item('beian');
			$data['city']['cstats'] = $this->config->item('site_stats');
			$data['city']['cz_email'] = $this->config->item('zhan_email');
			$data['city']['cz_tel'] = $this->config->item('zhan_tel');
			$data['city']['cz_email_me'] = $this->config->item('zhan_email_me');
			$data['city']['cz_shouji_me'] = $this->config->item('zhan_shouji_me');
			$data['city']['cz_search'] = $this->config->item('site_search');
			$data['city']['cz_memu'] = '';
			$data['foxtime'] = date('YmdH',time()).$this->session->userdata('userid');
		
			if($_POST && $this->validate_zhanb_add_form()){
				$stitle='';
				foreach(explode("|",$data['shengji']) as $k =>$s){
					if($k==$this->input->post('sid')){
						$stitle=$s;
					}
				}
				if( is_array($this->input->post('cz_memu'))){
					$cz_memu=implode(',',$this->input->post('cz_memu'));
				}else{
					$cz_memu=$this->input->post('cz_memu');
				}
				$str = array(
					'sid'=>$this->input->post('sid'),
					'stitle'=>$stitle,
					'sabc'=>getFirstCharter($stitle),
					'cname'=>$this->input->post('cname'),
					'cabc'=>getFirstCharter($this->input->post('cname')),
					'ctitle'=>$this->input->post('ctitle'),
					'ckeywords'=>$this->input->post('ckeywords'),
					'cdescription'=>$this->input->post('cdescription'),
					'cthemes'=>$this->input->post('cthemes'),
					'cnums'=>$this->input->post('cnums'),
					'ctel'=>$this->input->post('ctel'),
					'cqq'=>$this->input->post('cqq'),
					'cdress'=>$this->input->post('cdress'),
					'cbeian'=>$this->input->post('cbeian'),
					'cstats'=>$this->input->post('cstats'),
					'clogo'=>$this->input->post('clogo_'.$data['foxtime']),
					'ctelpic'=>$this->input->post('ctelpic_'.$data['foxtime']),
					'cwxpic'=>$this->input->post('cwxpic_'.$data['foxtime']),
					'cdomain'=>$this->input->post('cdomain'),
					'cowner'=>$this->input->post('cowner'),
					'cz_email'=>$this->input->post('cz_email'),
					'cz_tel'=>$this->input->post('cz_tel'),
					'cz_email_me'=>$this->input->post('cz_email_me'),
					'cz_shouji_me'=>$this->input->post('cz_shouji_me'),
					'cz_search'=>$this->input->post('cz_search'),
					'cz_memu'=>$cz_memu,
					'cmoren'=>0,
					'ctime'=>time(),
				);
				if(!in_array($this->input->post('cdomain'),explode("|",$this->config->item('site_domains')))){
					$site_domains=$this->config->item('site_domains').$this->input->post('cdomain').'|';
					$this->config->update('domainset','site_domains', $site_domains);
				}
				if($this->city_m->add_city($str)){
					$new_city_cid = $this->db->insert_id();
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}		
			}	
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
			
		$this->load->view('webset_zhanb_add', $data);
	}
	
	private function validate_zhanp_add_form(){
		$this->form_validation->set_rules('cname', '城市名称' , 'trim|required|min_length[1]|max_length[10]|callback_city_name_check|xss_clean');
		$this->form_validation->set_rules('ctitle', '网站标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('pingcid', '号码数据' , 'trim|required|numeric');
		$this->form_validation->set_rules('cnums', '默认系数' , 'trim|required|numeric');
		$this->form_validation->set_rules('sid', '省区' , 'trim|required|integer');
		$this->form_validation->set_rules('ctel', '电话' , 'trim|required');
		$this->form_validation->set_rules('cqq', 'QQ' , 'trim|required');
		$this->form_validation->set_rules('cdomain', '域名' , 'trim|required|valid_url');
		$this->form_validation->set_rules('cthemes', '网站模板' , 'trim|min_length[2]|max_length[50]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function zhanp_add()
	{
		/** 检查登陆 */
		if($this->auth->is_admin())
		{
			$data['title'] = '增加平级分站';
			$data['siderbar'] = 'webset';
			$data['submenu'] = 'admin/webset/zhanp';
			$this->load->model('city_m');
			$this->load->config('cityset');
			$data['shengji'] = $this->config->item('shengji');
			$data['city']['sid'] = 100;
			$data['city']['pingcid'] = 0;
			$data['city']['cname'] = '';
			$data['city']['cowner'] = '';
			$data['city']['cdomain'] = $this->config->item('site_domain');
			$data['city']['clogo'] = $this->config->item('weblogo');
			$data['city']['ctelpic'] = $this->config->item('telpic');
			$data['city']['ctitle'] = $this->config->item('site_name');
			$data['city']['ckeywords'] = $this->config->item('site_keywords');
			$data['city']['cdescription'] = $this->config->item('site_description');
			$data['city']['cthemes'] = $this->config->item('themes');
			$data['city']['cnums'] = $this->config->item('webnums');
			$data['city']['ctel'] = $this->config->item('webtel');
			$data['city']['cqq'] = $this->config->item('webqq');
			$data['city']['cdress'] = $this->config->item('webdress');
			$data['city']['cbeian'] = $this->config->item('beian');
			$data['city']['cstats'] = $this->config->item('site_stats');
			$data['city']['cz_email'] = $this->config->item('zhan_email');
			$data['city']['cz_tel'] = $this->config->item('zhan_tel');
			$data['city']['cz_email_me'] = $this->config->item('zhan_email_me');
			$data['city']['cz_shouji_me'] = $this->config->item('zhan_shouji_me');
			$data['city']['cz_search'] = $this->config->item('site_search');
			$data['city']['cz_memu'] = '';
			$data['foxtime'] = date('YmdH',time()).$this->session->userdata('userid');
			$data['citylist']=$this->city_m->get_city_all_list();
		
			if($_POST && $this->validate_zhanp_add_form()){
				$stitle='';
				foreach(explode("|",$data['shengji']) as $k =>$s){
					if($k==$this->input->post('sid')){
						$stitle=$s;
					}
				}
				if( is_array($this->input->post('cz_memu'))){
					$cz_memu=implode(',',$this->input->post('cz_memu'));
				}else{
					$cz_memu=$this->input->post('cz_memu');
				}
				$str = array(
					'sid'=>$this->input->post('sid'),
					'pingcid'=>$this->input->post('pingcid'),
					'stitle'=>$stitle,
					'sabc'=>getFirstCharter($stitle),
					'cname'=>$this->input->post('cname'),
					'cabc'=>getFirstCharter($this->input->post('cname')),
					'ctitle'=>$this->input->post('ctitle'),
					'ckeywords'=>$this->input->post('ckeywords'),
					'cdescription'=>$this->input->post('cdescription'),
					'cthemes'=>$this->input->post('cthemes'),
					'cnums'=>$this->input->post('cnums'),
					'ctel'=>$this->input->post('ctel'),
					'cqq'=>$this->input->post('cqq'),
					'cdress'=>$this->input->post('cdress'),
					'cbeian'=>$this->input->post('cbeian'),
					'cstats'=>$this->input->post('cstats'),
					'clogo'=>$this->input->post('clogo_'.$data['foxtime']),
					'ctelpic'=>$this->input->post('ctelpic_'.$data['foxtime']),
					'cdomain'=>$this->input->post('cdomain'),
					'cowner'=>$this->input->post('cowner'),
					'cz_email'=>$this->input->post('cz_email'),
					'cz_tel'=>$this->input->post('cz_tel'),
					'cz_email_me'=>$this->input->post('cz_email_me'),
					'cz_shouji_me'=>$this->input->post('cz_shouji_me'),
					'cz_search'=>$this->input->post('cz_search'),
					'cz_memu'=>$cz_memu,
					'cmoren'=>0,
					'ctime'=>time(),
				);
				if(!in_array($this->input->post('cdomain'),explode("|",$this->config->item('site_domains')))){
					$site_domains=$this->config->item('site_domains').$this->input->post('cdomain').'|';
					$this->config->update('domainset','site_domains', $site_domains);
				}
				if($this->city_m->add_city($str)){
					$new_city_cid = $this->db->insert_id();
					show_message($data['title'].'成功！',site_url($data['submenu']),1);
				}		
			}	
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
			
		$this->load->view('webset_zhanp_add', $data);
	}
	
	private function validate_zhanb_edit_form(){
		$this->form_validation->set_rules('ctitle', '网站标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('cnums', '默认系数' , 'trim|required|numeric');
		$this->form_validation->set_rules('sid', '省区' , 'trim|required|integer');
		$this->form_validation->set_rules('ctel', '电话' , 'trim|required');
		$this->form_validation->set_rules('cqq', 'QQ' , 'trim|required');
		$this->form_validation->set_rules('cdomain', '域名' , 'trim|required|valid_url');
		$this->form_validation->set_rules('cthemes', '网站模板' , 'trim|min_length[2]|max_length[50]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function zhanb_edit($cid='')
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			if(!is_numeric($cid))
			{
				show_message('参数不正确','');
			}
			if($this->session->userdata('ucity')>0 && $this->session->userdata('ucity')!=$cid)
			{
				show_message('您只能修改属于您的分站','');
			}
			$data['title'] = '修改分站';
			$data['siderbar'] = 'webset';
			$data['submenu'] = 'admin/webset/zhanb';
			$this->load->model('city_m');
			$this->load->config('cityset');
			$data['shengji'] = $this->config->item('shengji');
			$data['city']=$this->city_m->get_city_by_cid($cid);
			if($this->city_m->get_city_by_cid($cid)){
			$data['foxtime'] = date('YmdH',time()).$this->session->userdata('userid');
				if($_POST && $this->validate_zhanb_edit_form()){
					$stitle='';
					foreach(explode("|",$data['shengji']) as $k =>$s){
						if($k==$this->input->post('sid')){
							$stitle=$s;
						}
					}
					if( is_array($this->input->post('cz_memu'))){
						$cz_memu=implode(',',$this->input->post('cz_memu'));
					}else{
						$cz_memu=$this->input->post('cz_memu');
					}
					$str = array(
						//'sid'=>$this->input->post('sid'),
						//'stitle'=>$stitle,
						//'sabc'=>getFirstCharter($stitle),
						//'cname'=>$this->input->post('cname'),
						//'cabc'=>getFirstCharter($this->input->post('cname')),
						'ctitle'=>$this->input->post('ctitle'),
						'ckeywords'=>$this->input->post('ckeywords'),
						'cdescription'=>$this->input->post('cdescription'),
						'cthemes'=>$this->input->post('cthemes'),
						'cnums'=>$this->input->post('cnums'),
						'ctel'=>$this->input->post('ctel'),
						'cqq'=>$this->input->post('cqq'),
						'cdress'=>$this->input->post('cdress'),
						'cbeian'=>$this->input->post('cbeian'),
						'cstats'=>$this->input->post('cstats'),
						'clogo'=>$this->input->post('clogo_'.$data['foxtime']),
						'ctelpic'=>$this->input->post('ctelpic_'.$data['foxtime']),
						'cwxpic'=>$this->input->post('cwxpic_'.$data['foxtime']),
						'cdomain'=>$this->input->post('cdomain'),
						'cowner'=>$this->input->post('cowner'),
						'cz_email'=>$this->input->post('cz_email'),
						'cz_tel'=>$this->input->post('cz_tel'),
						'cz_email_me'=>$this->input->post('cz_email_me'),
						'cz_shouji_me'=>$this->input->post('cz_shouji_me'),
						'cz_search'=>$this->input->post('cz_search'),
						'cz_memu'=>$cz_memu,
						'cmoren'=>0,
						'ctime'=>time(),
					);
					if(!in_array($this->input->post('cdomain'),explode("|",$this->config->item('site_domains')))){
						$site_domains=$this->config->item('site_domains').$this->input->post('cdomain').'|';
						$this->config->update('domainset','site_domains', $site_domains);
					}
					if($this->city_m->update_city($cid,$str)){
						$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
						$this->cache->delete('cityt'.$cid);
						show_message($data['title'].'成功！',site_url($data['submenu']),1);
					}		
				}
			}else{
				show_message('参数不正确无法查询','');
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$this->load->view('webset_zhanb_edit', $data);
	}
	private function validate_zhanp_edit_form(){
		$this->form_validation->set_rules('ctitle', '网站标题' , 'trim|required|min_length[2]|max_length[50]|xss_clean');
		$this->form_validation->set_rules('cnums', '默认系数' , 'trim|required|numeric');
		$this->form_validation->set_rules('pingcid', '号码数据' , 'trim|required|integer');
		$this->form_validation->set_rules('sid', '省区' , 'trim|required|integer');
		$this->form_validation->set_rules('ctel', '电话' , 'trim|required');
		$this->form_validation->set_rules('cqq', 'QQ' , 'trim|required');
		$this->form_validation->set_rules('cdomain', '域名' , 'trim|required|valid_url');
		$this->form_validation->set_rules('cthemes', '网站模板' , 'trim|min_length[2]|max_length[50]');
		$this->form_validation->set_message('required', "%s 不能为空！");
		$this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符或汉字！");
		$this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符或汉字！");
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	public function zhanp_edit($cid='')
	{
		/** 检查登陆 */
		if($this->auth->is_admin())
		{
			if(!is_numeric($cid))
			{
				show_message('参数不正确','');
			}
			if($this->session->userdata('ucity')>0 && $this->session->userdata('ucity')!=$cid)
			{
				show_message('您只能修改属于您的分站','');
			}
			$data['title'] = '修改平级分站';
			$data['siderbar'] = 'webset';
			$data['submenu'] = 'admin/webset/zhanp';
			$this->load->model('city_m');
			$this->load->config('cityset');
			$data['shengji'] = $this->config->item('shengji');
			$data['city']=$this->city_m->get_city_by_cid($cid);
			$data['citylist']=$this->city_m->get_city_all_list();
			if($this->city_m->get_city_by_cid($cid)){
			$data['foxtime'] = date('YmdH',time()).$this->session->userdata('userid');
				if($_POST && $this->validate_zhanp_edit_form()){
					$stitle='';
					foreach(explode("|",$data['shengji']) as $k =>$s){
						if($k==$this->input->post('sid')){
							$stitle=$s;
						}
					}
					if( is_array($this->input->post('cz_memu'))){
						$cz_memu=implode(',',$this->input->post('cz_memu'));
					}else{
						$cz_memu=$this->input->post('cz_memu');
					}
					$str = array(
						//'sid'=>$this->input->post('sid'),
						//'stitle'=>$stitle,
						//'sabc'=>getFirstCharter($stitle),
						//'cname'=>$this->input->post('cname'),
						//'cabc'=>getFirstCharter($this->input->post('cname')),
						'pingcid'=>$this->input->post('pingcid'),
						'ctitle'=>$this->input->post('ctitle'),
						'ckeywords'=>$this->input->post('ckeywords'),
						'cdescription'=>$this->input->post('cdescription'),
						'cthemes'=>$this->input->post('cthemes'),
						'cnums'=>$this->input->post('cnums'),
						'ctel'=>$this->input->post('ctel'),
						'cqq'=>$this->input->post('cqq'),
						'cdress'=>$this->input->post('cdress'),
						'cbeian'=>$this->input->post('cbeian'),
						'cstats'=>$this->input->post('cstats'),
						'clogo'=>$this->input->post('clogo_'.$data['foxtime']),
						'ctelpic'=>$this->input->post('ctelpic_'.$data['foxtime']),
						'cdomain'=>$this->input->post('cdomain'),
						'cowner'=>$this->input->post('cowner'),
						'cz_email'=>$this->input->post('cz_email'),
						'cz_tel'=>$this->input->post('cz_tel'),
						'cz_email_me'=>$this->input->post('cz_email_me'),
						'cz_shouji_me'=>$this->input->post('cz_shouji_me'),
						'cz_search'=>$this->input->post('cz_search'),
						'cz_memu'=>$cz_memu,
						'cmoren'=>0,
						'ctime'=>time(),
					);
					if(!in_array($this->input->post('cdomain'),explode("|",$this->config->item('site_domains')))){
						$site_domains=$this->config->item('site_domains').$this->input->post('cdomain').'|';
						$this->config->update('domainset','site_domains', $site_domains);
					}
					if($this->city_m->update_city($cid,$str)){
						$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
						$this->cache->delete('cityt'.$cid);
						show_message($data['title'].'成功！',site_url($data['submenu']),1);
					}		
				}
			}else{
				show_message('参数不正确无法查询','');
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$this->load->view('webset_zhanp_edit', $data);
	}
	
	public function zhanb($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$this->load->model('city_m');
			$data['title'] = '分站列表';
			$data['siderbar'] = 'webset';
			$data['submenu'] = 'admin/webset/zhanb';

			//分页
			$limit = 15;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/webset/zhanb/');
			$config['total_rows'] = $this->city_m->count_city_moren(0);
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			$data['city_list'] = $this->city_m->get_all_city_moren($start, $limit, 0);
			if($data['city_list']){
				foreach($data['city_list'] as $k => $v){
					$data['city_list'][$k]['pingcid']=$this->city_m->get_cname_by_ucity_ping($v['pingcid']);
					$data['city_list'][$k]['pingcids']=$v['pingcid'];
				}					
			}
			if($this->session->userdata('ucity')>0){
				foreach($data['city_list'] as $k => $v){
					if($v['cid']!=$this->session->userdata('ucity')){
						unset($data['city_list'][$k]);
					}
				}
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$this->load->view('webset_zhanb', $data);
	}
	
	public function zhanp($page=1)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{
			$this->load->model('city_m');
			$data['title'] = '平级分站';
			$data['siderbar'] = 'webset';
			$data['submenu'] = 'admin/webset/zhanp';

			//分页
			$limit = 15;
			$config['uri_segment'] = 4;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url('admin/webset/zhanp/');
			$config['total_rows'] = $this->city_m->count_city_moren_ping(0,1);
			$config['per_page'] = $limit;
			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li class=\'prev\'>';
			$config['prev_tag_close'] = '</li';
			$config['cur_tag_open'] = '<li class=\'active\'><span>';
			$config['cur_tag_close'] = '</span></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li class=\'next\'>';
			$config['next_tag_close'] = '</li>';
			$config['first_link'] = '首页';
			$config['first_tag_open'] = '<li class=\'first\'>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '尾页';
			$config['last_tag_open'] = '<li class=\'last\'>';
			$config['last_tag_close'] = '</li>';
			$config['num_links'] = 5;
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$start = ($page-1)*$limit;
			$data['pagination'] = $this->pagination->create_links();

			$data['city_list'] = $this->city_m->get_all_city_moren_ping($start, $limit, 0,1);
			if($data['city_list']){
				foreach($data['city_list'] as $k => $v){
					$data['city_list'][$k]['pingcid']=$this->city_m->get_cname_by_ucity_ping($v['pingcid']);
				}				
			}
		}else{
			show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
		}
		$this->load->view('webset_zhanp', $data);
	}
	
	public function zhanb_del($cid)
	{
		$masterurl=$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		/** 检查登陆 */
		if($this->auth->is_admin() || $this->auth->is_master($masterurl))
		{		
			$data['siderbar'] = 'webset';
			$data['title'] = '删除分站';
			$data['submenu'] = 'admin/webset/zhanb';
			if($this->session->userdata('ucity')>0)
			{
				show_message('您没有删除分站的权限','');
			}

			//删除
			$this->load->model('city_m');
			if($this->city_m->del_city($cid)){
				$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				$this->cache->delete('cityt');
				show_message('分站删除成功！',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限','');
		}
	}
	
	public function zhanp_del($cid)
	{
		/** 检查登陆 */
		if($this->auth->is_admin())
		{		
			$data['siderbar'] = 'webset';
			$data['title'] = '删除平级分站';
			$data['submenu'] = 'admin/webset/zhanp';
			if($this->session->userdata('ucity')>0)
			{
				show_message('您没有删除分站的权限','');
			}

			//删除
			$this->load->model('city_m');
			if($this->city_m->del_city($cid)){
				$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
				$this->cache->delete('cityt');
				show_message('平级分站删除成功！',site_url($data['submenu']),1);
			}
		}else{
			show_message('您没有此管理权限','');
		}
	}
	public function delcachebyauto(){
	    $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$this->cache->clean();
	}
}