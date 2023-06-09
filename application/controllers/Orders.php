<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('log_user'))) {
			$this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
			redirect('auth', 'refresh');
		}

		$this->db->where('id', $this->session->userdata('id'));
		$this->dt_user = $this->db->get('user')->row();

		$this->load->model('M_Customer', 'customer');
	}

	public function index()
	{
		$data = [
			'title'      => 'List Order',
			'page'       => 'user/orders',
			'orders'	=> $this->customer->getOrders([
				'orders.idUser'	=> $this->dt_user->id,
				'orders.status' => 1
			])
		];

		$this->load->view('user/index', $data);
	}

	public function getListProgres()
	{
		$progres = $this->customer->getListProgres([
			'idUser'   => $this->dt_user->id,
			'idKhusus' => $this->input->get('idKhusus'),
		]);

		$result = [
			'data' => ($progres) ? $progres : null
		];

		echo json_encode($result);
	}

	public function getListBarang()
	{
		$barang = $this->customer->getKeranjang([
			'idUser'   => $this->dt_user->id,
			'idKhusus' => $this->input->get('idKhusus'),
		]);

		$result = [
			'data' => ($barang) ? $barang : null
		];

		echo json_encode($result);
	}
}

  /* End of file Orders.php */
