<?php

defined('BASEPATH') or exit('No direct script access allowed');

header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Methods:GET,OPTIONS");

class Pembayaran extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('log_user'))) {
			$this->session->set_flashdata('toastr-eror', 'Anda Belum Login');
			redirect('auth', 'refresh');
		}

		$this->dt_user = $this->session->userdata('log_user');

		$params = array('server_key' => 'SB-Mid-server-lp8u0IxK10bNHYurePrckGuJ', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
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
			'title' => 'Pembayaran',
			'page'  => 'pembayaran',
			'paket' => $paket
		];

		$this->load->view('index', $data);
	}

	public function token()
	{
		$namaPaket = $this->input->post('namaPaket');
		$jmlBayar = $this->input->post('jmlBayar');

		// Required
		$transaction_details = array(
			'order_id' => rand(),
			'gross_amount' => $jmlBayar, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id'       => 'a1',
			'price'    => $jmlBayar,
			'quantity' => 1,
			'name'     => $namaPaket
		);

		// Optional
		$item_details = array($item1_details);

		// Optional
		$customer_details = array(
			'first_name'    => $this->dt_user->name,
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'day',
			'duration'  => 1
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
	}

	public function finish()
	{
		$result = json_decode($this->input->post('result_data'), true);

		$idPaket   = $this->input->post('idPaket');

		$form_params = [
			'backend_key'      => $this->config->item('backend_key'),
			'idUser'           => $this->dt_user->id,
			'idPaket'          => $idPaket,
			'order_id'         => $result['order_id'],
			'payment_type'     => $result['payment_type'],
			'transaction_time' => $result['transaction_time'],
			'bank'             => $result['va_numbers'][0]["bank"],
			'va_numbers'       => $result['va_numbers'][0]["va_number"],
			'pdf_url'          => $result['pdf_url'],
			'status_code'      => $result['status_code'],
		];

		$api_post = api_post($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'transaksi', false);

		$api_post = json_decode($api_post);

		if ($api_post->status == true) {
			$this->session->set_flashdata('toastr-success', $api_post->message);
		} else {
			$this->session->set_flashdata('toastr-error', $api_post->message);
		}

		redirect('pembayaran', 'refresh');
	}
}

/* End of file Pembayaran.php */
