<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-lp8u0IxK10bNHYurePrckGuJ', 'production' => false);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
	}

	public function index()
	{
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result, "true");

		$order_id = $result['order_id'];
		$status_code = $result['status_code'];

		if ($status_code == 200) {
			$form_params = [
				'backend_key' => $this->config->item('backend_key'),
				'order_id'    => $order_id,
				'status_code' => $status_code,
			];

			api_put($this->config->item('backend_user'), $this->config->item('backend_pass'), $form_params, $this->config->item('backend_host') . 'transaksi', false);
		}
	}
}
