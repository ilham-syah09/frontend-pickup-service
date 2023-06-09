<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paket extends CI_Controller
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
			'title' => 'Paket',
			'page'  => 'paket',
			'paket' => $paket
		];

		$this->load->view('index', $data);
	}

	public function add()
	{
		$form_params = [
			'backend_key'  =>  $this->config->item('backend_key')
		];

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'ekspedisi', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$ekspedisi = $api_get->data;
		} else {
			$ekspedisi = null;
		}

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'setting', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$setting = $api_get->data;
		} else {
			$setting = null;
		}

		$data = [
			'title'     => 'Tambah Paket',
			'page'      => 'add_paket',
			'ekspedisi' => $ekspedisi,
			'setting'   => $setting
		];

		$this->load->view('index', $data);
	}

	public function post_add()
	{
		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'idUser'      => $this->dt_user->id,
			'namaPaket'   => $this->input->post('namaPaket'),
			'berat'       => $this->input->post('berat'),
			'jarak'       => $this->input->post('jarak'),
			'idEkspedisi' => $this->input->post('idEkspedisi'),
			'lati'        => $this->input->post('lati'),
			'longi'       => $this->input->post('longi'),
			'catatan'     => $this->input->post('catatan'),
			'totalBiaya'  => $this->input->post('totalBiaya')
		];

		$api_post = api_post($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'paket', false);

		$api_post = json_decode($api_post);

		if ($api_post->status == true) {
			$this->session->set_flashdata('toastr-success', $api_post->message);
		} else {
			$this->session->set_flashdata('toastr-error', $api_post->message);
		}

		redirect('paket', 'refresh');
	}

	public function edit($id)
	{
		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'id'          => $id
		];

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'paket', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$paket = $api_get->data;
		} else {
			$paket = null;

			$this->session->set_flashdata('toastr-error', 'Paket tidak ditemukan');
			redirect('paket', 'refresh');
		}

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'ekspedisi', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$ekspedisi = $api_get->data;
		} else {
			$ekspedisi = null;
		}

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'setting', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$setting = $api_get->data;
		} else {
			$setting = null;
		}

		$data = [
			'title'     => 'Edit Paket',
			'page'      => 'edit_paket',
			'ekspedisi' => $ekspedisi,
			'setting'   => $setting,
			'paket'		=> $paket
		];

		$this->load->view('index', $data);
	}

	public function post_edit()
	{
		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'id'          => $this->input->post('id'),
			'namaPaket'   => $this->input->post('namaPaket'),
			'berat'       => $this->input->post('berat'),
			'jarak'       => $this->input->post('jarak'),
			'idEkspedisi' => $this->input->post('idEkspedisi'),
			'lati'        => $this->input->post('lati'),
			'longi'       => $this->input->post('longi'),
			'catatan'     => $this->input->post('catatan'),
			'totalBiaya'  => $this->input->post('totalBiaya')
		];

		$api_post = api_post($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'paket/update', false);

		$api_post = json_decode($api_post);

		if ($api_post->status == true) {
			$this->session->set_flashdata('toastr-success', $api_post->message);
		} else {
			$this->session->set_flashdata('toastr-error', $api_post->message);
		}

		redirect('paket', 'refresh');
	}

	public function delete($id)
	{
		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'id'          => $id
		];

		$api_delete = api_delete($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'paket', false);

		$api_delete = json_decode($api_delete);

		if ($api_delete->status == true) {
			$this->session->set_flashdata('toastr-success', $api_delete->message);
		} else {
			$this->session->set_flashdata('toastr-error', $api_delete->message);
		}

		redirect('paket', 'refresh');
	}

	public function alamat($id)
	{
		$form_params = [
			'backend_key' => $this->config->item('backend_key'),
			'id'          => $id
		];

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'paket', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$paket = $api_get->data;
		} else {
			$paket = null;

			$this->session->set_flashdata('toastr-error', 'Paket tidak ditemukan');
			redirect('paket', 'refresh');
		}

		$api_get = api_get($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'setting', false);

		$api_get = json_decode($api_get);

		if ($api_get->status == true) {
			$setting = $api_get->data;
		} else {
			$setting = null;
		}

		$data = [
			'title'     => 'Edit Paket',
			'page'      => 'alamat_paket',
			'setting'   => $setting,
			'paket'		=> $paket
		];

		$this->load->view('index', $data);
	}
}

/* End of file Paket.php */
