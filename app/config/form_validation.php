<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$config = array(
	'admin/login/do_login' => array(
		array(
			'field' => 'username',
			'label' => '帐户',
			'rules' => 'trim|required|min_length[3]|max_length[15]|xss_clean'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[4]|max_length[18]'
		),
	),
	'user/register' => array(
		// array(
			// 'field' => 'email',
			// 'label' => '邮箱',
			// 'rules' => 'trim|required|min_length[3]|max_length[50]|valid_email|is_unique[users.email]|xss_clean'
		// ),
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|required|min_length[3]|max_length[15]|is_unique[users.username]|callback__check_username|xss_clean'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[6]|max_length[18]'
		),
		array(
			'field' => 'password_confirm',
			'label' => '重复密码',
			'rules' => 'trim|required|matches[password]'
		),
        array(
            'field' => 'captcha_code',
            'label' => '验证码',
            //'rules' => 'trim|required|exact_length[4]|callback__check_captcha'
            'rules' => 'trim|required|callback__check_captcha'
        )
		
	),
	'user/findpwd' => array(
		array(
			'field' => 'email',
			'label' => '邮箱',
			'rules' => 'trim|required|min_length[3]|max_length[50]|valid_email|xss_clean'
		),
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|required|min_length[3]|max_length[15]|xss_clean'
		),
	),
	'user/login' => array(
		array(
			'field' => 'username',
			'label' => '用户名',
			'rules' => 'trim|required|min_length[3]|max_length[15]|xss_clean'
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required|min_length[4]|max_length[18]'
		),
        array(
            'field' => 'captcha_code',
            'label' => '验证码',
            //'rules' => 'trim|required|exact_length[4]|callback__check_captcha'
            'rules' => 'trim|required|callback__check_captcha'
        )
		
	),

    
    'comment/add_comment' => array(
        array(
            'field' => 'comment',
            'label' => '内容',
            'rules' => 'trim|required|xss_clean'
        )
    ),
    'comment/edit' => array(
        array(
            'field' => 'content',
            'label' => '内容',
            'rules' => 'trim|required|min_length[6]||max_length['.$CI->config->item('words_limit_99').']|xss_clean'
        )
    ),
		
    'message/send' => array(
        array(
            'field' => 'content',
            'label' => '信息内容',
            'rules' => 'trim|strip_tags'
        )
    ),
	
    'install/process' => array(
        array(
            'field' => 'dbhost',
            'label' => '服务器',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'dbuser',
            'label' => '数据库用户名',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'dbname',
            'label' => '数据库名',
            'rules' => 'trim|required'
        )
    ),
	
	'install/setadmin' => array(
        array(
            'field' => 'username',
            'label' => '管理员',
            'rules' => 'trim|required|min_length[3]|max_length[15]'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|valid_email'
        )
    ),

    'user/resetpwd' => array(
        array(
            'field' => 'password',
            'label' => '新密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'password_c',
            'label' => '重复新密码',
            'rules' => 'trim|required|matches[password]'
        )
    ),
    
    'auth/register' => array(
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|max_length[50]|valid_email|is_unique[users.email]|xss_clean'
        ),
        array(
            'field' => 'captcha',
            'label' => '验证码',
            //'rules' => 'trim|required|exact_length[8]|callback__check_captcha'
            'rules' => 'trim|required|callback__check_captcha'
        )
    ),
    'auth/active' => array(
        array(
            'field' => 'username',
            'label' => '用户名',
            'rules' => 'trim|required|max_length[18]|is_unique[users.username]|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'passconf',
            'label' => '重复密码',
            'rules' => 'trim|required|matches[password]'
        )
    ),
    'auth/login' => array(
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|max_length[50]|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => '密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        )

    ),
    'auth/forgotten_password' => array(
        array(
            'field' => 'email',
            'label' => '邮箱',
            'rules' => 'trim|required|max_length[50]|valid_email|callback__email_valid'
        ),
        array(
            'field' => 'captcha',
            'label' => '验证码',
            //'rules' => 'trim|required|exact_length[8]|callback__check_captcha'
            'rules' => 'trim|required|callback__check_captcha'
        )
    ),
    'auth/reset_password' => array(
        array(
            'field' => 'password',
            'label' => '新密码',
            'rules' => 'trim|required|min_length[6]|max_length[18]'
        ),
        array(
            'field' => 'passconf',
            'label' => '重复新密码',
            'rules' => 'trim|required|matches[password]'
        )
    ),
    'topics/create' => array(
        array(
            'field' => 'title',
            'label' => '标题',
            'rules' => 'trim|required|min_length[5]|max_length[50]|xss_clean'
        ),
        array(
            'field' => 'content',
            'label' => '内容',
            'rules' => 'trim|required|min_length[20]|max_length[2000]|xss_clean'
        )
    ),
    'comments/create' => array(
        array(
            'field' => 'content',
            'label' => '回复',
            'rules' => 'trim|required|min_length[5]|max_length[400]|xss_clean'
        )
    ),
);
if($CI->config->item('show_captcha')=='off'){
	$config['user/register'][3]['rules']='';
	$config['user/login'][2]['rules']='';
}
