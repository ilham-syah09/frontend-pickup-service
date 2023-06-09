<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;

function api_get($username, $password, $query, $url, $verify)
{
	$client = new Client();
	$response = $client->request('GET', $url, [
		'verify' => $verify,
		'auth' => [$username, $password],
		'query' => $query
	]);

	return $response->getBody()->getContents();
}

function api_post($username, $password, $data, $url, $verify)
{
	$client = new Client();
	$response = $client->post(
		$url,
		[
			'verify' => $verify,
			'auth' => [$username, $password],
			'form_params' => $data
		]
	);
	return $response->getBody()->getContents();
}

function api_post_file($username, $password, $data, $url, $verify)
{
	$client = new Client();

	$response = $client->request('POST', $url, [
		'verify'    => $verify,
		'auth'      => [$username, $password],
		'multipart' => $data
	]);

	return $response->getBody()->getContents();
}

function api_delete($username, $password, $data, $url, $verify)
{
	$client = new Client();
	$response = $client->request(
		'DELETE',
		$url,
		[
			'verify' => $verify,
			'auth' => [$username, $password],
			'form_params' => $data
		]
	);
	return $response->getBody()->getContents();
}

function api_put($username, $password, $data, $url, $verify)
{
	$client = new Client();
	$response = $client->put(
		$url,
		[
			'verify' => $verify,
			'auth' => [$username, $password],
			'form_params' => $data
		]
	);
	return $response->getBody()->getContents();
}
