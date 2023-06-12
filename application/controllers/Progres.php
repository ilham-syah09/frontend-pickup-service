<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Progres extends CI_Controller
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

	public function index($id = null)
	{
		if ($id) {
			$form_params = [
				'backend_key'  =>  $this->config->item('backend_key'),
				'idUser'       => $this->dt_user->id,
				'idPaket'		=> $id
			];

			$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'progres', false);

			$api_get = json_decode($api_get);

			if ($api_get->status == true) {
				$progres = $api_get->data;
			} else {
				$progres = null;
			}
		} else {
			$progres = null;
		}

		$form_params = [
			'backend_key'  =>  $this->config->item('backend_key'),
			'idUser'       => $this->dt_user->id
		];

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'paket', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$paket = $api_get->data;
		} else {
			$paket = null;
		}

		$data = [
			'title'   => 'Progres',
			'page'    => 'progres',
			'progres' => $progres,
			'paket'   => $paket,
			'idPaket' => $id
		];

		$this->load->view('index', $data);
	}
}

/* End of file Progres.php */
