<?php

class Question extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('question_m');
        $this->load->model('city_m');
        $this->load->config('haoset');
        $this->config->load('cityset');
        $this->load->library('form_validation');
        $this->load->helper('htmlpurifier');
    }

    public function index()
    {
        redirect(site_url('admin/question/flist'));
    }

    public function flist($ug = 10000, $city = 0, $page = 1)
    {
        $masterurl = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);
        /** 检查登陆 */
        if ($this->auth->is_admin() || $this->auth->is_master($masterurl)) {
            $data['title'] = '问题列表';
            $data['siderbar'] = 'admin/question';
            $data['submenu'] = 'admin/question/flist';
            $data['ug'] = $ug;
            $data['citys'] = $this->city_m->get_city_all_list_ping();
            if ($this->session->userdata('ucity') > 0) {
                $data['city'] = $this->session->userdata('ucity');
            } else {
                $data['city'] = $city;
            }
            if ($data['city'] > 0) {
                $data['cityname'] = $this->city_m->get_cname_by_ucity_luo($data['city']);
            } else {
                $data['cityname'] = '城市';
            }

            //分页
            $limit = 20;
            $config['uri_segment'] = 6;
            $config['use_page_numbers'] = TRUE;
            $config['base_url'] = site_url('admin/question/flist/' . $ug . '/' . $data['city'] . '/');
            $config['total_rows'] = $this->question_m->count_question($ug, $data['city']);
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

            $start = ($page - 1) * $limit;
            $data['pagination'] = $this->pagination->create_links();

            $data['question_list'] = $this->question_m->get_all_question_list($start, $limit, $ug, $data['city']);
            if ($data['question_list']) {
                foreach ($data['question_list'] as $k => $v) {
                    $data['question_list'][$k]['question_city'] = $this->city_m->get_cname_by_ucity($v['q_city']);
                }
            }

            $this->load->view('question_list', $data);

        } else {
            show_message('您没有此管理权限或未登陆', site_url('admin/login/do_login'));
        }
    }

    private function validate_addquestion_form()
    {
        $this->form_validation->set_rules('question_title', '标题', 'trim|required|min_length[2]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('question_type', '类型', 'trim|required|integer');
        $this->form_validation->set_rules('question_city', '城市', 'trim|required|integer');
        $this->form_validation->set_rules('content', '内容', 'trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('question_name', '联系人', 'trim|required|min_length[2]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('question_tel', '联系电话', 'trim|required|min_length[2]|max_length[18]|xss_clean');
        $this->form_validation->set_rules('recontent', '回复', 'trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_message('required', "%s 不能为空！");
        $this->form_validation->set_message('min_length', "%s 最小长度不少于 %s 个字符！");
        $this->form_validation->set_message('max_length', "%s 最大长度不多于 %s 个字符！");
        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function add()
    {
        $masterurl = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);
        /** 检查登陆 */
        if ($this->auth->is_admin() || $this->auth->is_master($masterurl)) {
            $data['title'] = '增加问题';
            $data['siderbar'] = 'question';
            $data['submenu'] = 'admin/question/flist';

            $data['citys'] = $this->city_m->get_city_all_list_ping();

            if ($_POST && $this->validate_addquestion_form()) {
                $str = array(
                    'q_title' => strip_tags($this->input->post('question_title')),
                    'q_type' => $this->input->post('question_type', true),
                    'q_city' => $this->input->post('question_city', true),
                    'q_content' => html_purify($this->input->post('content', true), 'comment'),
                    'q_name' => $this->input->post('question_name', true),
                    'q_tel' => $this->input->post('question_tel', true),
                    'q_rename' => $this->input->post('question_rename', true),
                    'q_recontent' => html_purify($this->input->post('recontent', true), 'comment'),
                    'q_reuserid' => $this->session->userdata('userid'),
                    'q_time' => time(),
                    'q_retime' => time(),
                );
                if ($this->question_m->add_question($str)) {
                    show_message($data['title'] . '成功！', site_url($data['submenu']), 1);
                }
            }
            $this->load->view('question_add', $data);

        } else {
            show_message('您没有此管理权限或未登陆', site_url('admin/login/do_login'));
        }
    }

    public function edit($id)
    {
        $masterurl = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);
        /** 检查登陆 */
        if ($this->auth->is_admin() || $this->auth->is_master($masterurl)) {
            if (!$this->question_m->get_question_by_id($id)) {
                show_message('参数不正确', '');
            }
            $data['title'] = '修改问题';
            $data['siderbar'] = 'question';
            $data['submenu'] = 'admin/question/flist';

            $data['citys'] = $this->city_m->get_city_all_list_ping();
            $data['questioninfo'] = $this->question_m->get_question_by_id($id);
            if ($_POST && $this->validate_addquestion_form()) {
                if ($this->session->userdata('ucity') > 0 && $data['questioninfo']['q_city'] != $this->session->userdata('ucity')) {
                    show_message('操作无权限：非您站问题', '');
                }
                $str = array(
                    'q_title' => strip_tags($this->input->post('question_title')),
                    'q_type' => $this->input->post('question_type', true),
                    'q_city' => $this->input->post('question_city', true),
                    'q_content' => html_purify($this->input->post('content', true), 'comment'),
                    'q_name' => $this->input->post('question_name', true),
                    'q_tel' => $this->input->post('question_tel', true),
                    'q_recontent' => html_purify($this->input->post('recontent', true), 'comment'),
                    'q_reuserid' => 1,
                    'q_retime' => time(),
                );
                if ($this->question_m->update_question($id, $str)) {
                    show_message($data['title'] . '成功！', site_url($data['submenu']), 1);
                }
            }
            $this->load->view('question_edit', $data);

        } else {
            show_message('您没有此管理权限或未登陆', site_url('admin/login/do_login'));
        }
    }

    public function del($id)
    {
        $masterurl = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);
        /** 检查登陆 */
        if ($this->auth->is_admin() || $this->auth->is_master($masterurl)) {
            $data['siderbar'] = 'question';
            $data['title'] = '删除问题';
            $data['submenu'] = 'admin/question/flist';
            if ($this->question_m->get_question_by_id($id)) {
                $data['questioninfo'] = $this->question_m->get_question_by_id($id);
                if ($this->session->userdata('ucity') > 0 && $data['questioninfo']['q_city'] != $this->session->userdata('ucity')) {
                    show_message('操作无权限：非您站问题', '');
                }
                //删除
                if ($this->question_m->del_question($id)) {
                    show_message($data['title'] . '成功！', site_url($data['submenu']), 1);
                }
            } else {
                show_message('参数不正确', '');
            }

        } else {
            show_message('您没有此管理权限或未登陆', site_url('admin/login/do_login'));
        }

    }

    public function search()
    {
        //查找用户
        $data['siderbar'] = 'admin/question';
        $data['title'] = '搜索问题';
        $data['submenu'] = 'admin/question/flist';
        $data['ug'] = 10000;
        $data['citys'] = $this->city_m->get_city_all_list_ping();
        if ($this->session->userdata('ucity') > 0) {
            $data['city'] = $this->session->userdata('ucity');
        } else {
            $data['city'] = 0;
        }
        if ($data['city'] > 0) {
            $data['cityname'] = $this->city_m->get_cname_by_ucity_luo($data['city']);
        } else {
            $data['cityname'] = '城市';
        }
        if ($_POST) {
            $q = $this->input->post('q');
            $data['question_list'] = $this->question_m->search_question($q);
            if ($data['question_list']) {
                foreach ($data['question_list'] as $k => $v) {
                    $data['question_list'][$k]['question_city'] = $this->city_m->get_cname_by_ucity($v['q_city']);
                }
            }
        }
        $this->load->view('question_list', $data);
    }

    public function delall()
    {
        $masterurl='admin/question/delall';
        /** 检查登陆 */
        if(!$this->auth->is_admin() && !$this->auth->is_master($masterurl))
        {
            show_message('您没有此管理权限或未登陆',site_url('admin/login/do_login'));
        }

        $ids = array_slice($this->input->post(), 0, -1);
//        var_dump($ids);
//        die;
        if($this->input->post('batch_del')){
            if($this->db->where_in('id',$ids)->delete('question')){
                show_message('批量删除问答成功！',site_url('admin/question/flist'),1);
            }
        }
    }


}