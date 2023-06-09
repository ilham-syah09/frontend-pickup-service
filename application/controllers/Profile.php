<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($this->session->userdata('log_user'))) {
            $this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
            redirect('auth', 'refresh');
        }

        $this->dt_user = $this->session->userdata('log_user');
    }

    public function index()
    {
        $data = [
            'title'     => 'Profile',
            'sidebar'   => 'sidebar',
            'page'      => 'profile'
        ];

        $this->load->view('index', $data);
    }

    public function edit()
    {
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $retypepwd = $this->input->post('retypepwd');
        $image = $_FILES['image']['name'];

        if ($password != "") {
            if ($password != $retypepwd) {
                $this->session->set_flashdata('toastr-error', 'Password konfirmasi harus sama');

                redirect('profile');
            }
        }

        $file = [];
        if ($image) {
            $file = $this->_saveFile();
            $multipart = [
                [
                    'name'   => 'backend_key',
                    'contents' => $this->config->item('backend_key')
                ],
                [
                    'name'   => 'id',
                    'contents' => $this->dt_user->id
                ],
                [
                    'name'  => 'name',
                    'contents' => $name
                ],
                [
                    'name' => 'password',
                    'contents' => $password
                ],
                $file
            ];
        } else {
            $multipart = [
                [
                    'name'   => 'backend_key',
                    'contents' => $this->config->item('backend_key')
                ],
                [
                    'name'   => 'id',
                    'contents' => $this->dt_user->id
                ],
                [
                    'name'  => 'name',
                    'contents' => $name
                ],
                [
                    'name' => 'password',
                    'contents' => $password
                ]
            ];
        }

        $api_post = api_post_file($this->config->item('backend_user'), $this->config->item('backend_pass'), $multipart, $this->config->item('backend_host') . 'profile', false);

        $api_post = json_decode($api_post);

        if ($api_post->status == true) {
            if ($image) {
                unlink(FCPATH . 'upload/' . $file['filename']);
            }
            $this->session->set_userdata('log_user', $api_post->data);
            $this->session->set_flashdata('toastr-success', $api_post->message);
        } else {
            $this->session->set_flashdata('toastr-error', $api_post->message);
        }

        redirect('profile', 'refresh');
    }

    private function _saveFile()
    {
        $this->load->library('upload');
        $config['upload_path']   = './upload';
        $config['allowed_types'] = 'jpg|jpeg|png';
        // $config['max_size']             = 3072; // 3 mb
        $config['remove_spaces'] = TRUE;
        $config['detect_mime']   = TRUE;
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image')) {
            $this->session->set_flashdata('toastr-error', $this->upload->display_errors());

            redirect('profile', 'refresh');
        } else {
            $upload_data = $this->upload->data();

            $data = [
                'name'     => 'image',
                'contents' => fopen(getcwd() . '/upload/' . $upload_data['file_name'], 'r'),
                'filename' => $upload_data['file_name'],
                'headers'  => array('Content-Type' => mime_content_type(getcwd() . '/upload/' . $upload_data['file_name'])),
            ];

            return $data;
        }
    }
}

/* End of file Admin.php */
