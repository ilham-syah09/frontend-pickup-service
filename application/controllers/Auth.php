<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('log_user'))) {
            if ($this->uri->segment(2) != 'logout') {
                $this->session->set_flashdata('toastr-error', 'Anda sudah login !');
                redirect('home');
            }
        }
    }

    public function index()
    {
        $data = [
            'title'     => 'Login',
        ];

        $this->load->view('auth/index', $data);
    }


    public function proses()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $form_params = [
            'backend_key'  =>  $this->config->item('backend_key'),
            'username'       => $username,
            'password'       => $password,
        ];

        $api_post = api_post($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'login', false);

        $api_post = json_decode($api_post);

        if ($api_post->status == true) {
            $login = $api_post->data;
            $login->is_logged_in = true;

            $this->session->set_userdata('log_user', $login);
            $this->session->set_flashdata('toastr-success', $api_post->message);

            redirect('home');
        } else {
            $this->session->set_flashdata('toastr-error', $api_post->message);
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth', 'refresh');
    }
}

/* End of file Auth.php */
