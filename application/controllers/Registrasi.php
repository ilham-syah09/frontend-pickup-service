<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registrasi extends CI_Controller
{
	public function index()
	{
		$data = [
			'title'     => 'Registrasi',
		];

		$this->load->view('registrasi/index', $data);
	}

	public function proses()
	{
		$username = $this->input->post('username');
		$name = $this->input->post('name');

		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'username'    => $username,
			'name'        => $name,
			'url'         => base_url('registrasi/aktifasi/')
		];

		$api_post = api_post($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'register', false);

		$api_post = json_decode($api_post);

		if ($api_post->status == true) {
			$this->session->set_flashdata('toastr-success', $api_post->message);

			redirect('auth');
		} else {
			$this->session->set_flashdata('toastr-error', $api_post->message);

			redirect('registrasi');
		}
	}

	public function aktifasi($id)
	{
		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'id'          => $id
		];

		$api_post = api_put($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'register', false);

		$api_post = json_decode($api_post);

		if ($api_post->status == true) {
			$this->session->set_flashdata('toastr-success', $api_post->message);
		} else {
			$this->session->set_flashdata('toastr-error', $api_post->message);
		}

		redirect('auth');
	}
}

/* End of file Registrasi.php */
