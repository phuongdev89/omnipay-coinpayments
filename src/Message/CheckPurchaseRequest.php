<?php

namespace Omnipay\Coinpayments\Message;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Class CheckPurchaseRequest
 * @package Omnipay\Coinpayments\Message
 */
class CheckPurchaseRequest extends AbstractRequest {

	/**
	 * @return array|mixed
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	public function getData() {
		$this->validate('txid');
		return [
			'cmd'  => 'get_tx_info',
			'txid' => $this->getTxid(),
			'full' => 1,
		];
	}

	/**
	 * @param $hmac
	 *
	 * @return array
	 */
	protected function getHeaders($hmac) {
		return [
			'HMAC'         => $hmac,
			'Content-Type' => 'application/x-www-form-urlencoded',
		];
	}

	/**
	 * @param mixed $data
	 *
	 * @return PurchaseResponse|\Omnipay\Common\Message\ResponseInterface
	 */
	public function sendData($data) {
		$hmac            = $this->getSig($data, 'get_tx_info');
		$data['version'] = 1;
		$data['cmd']     = 'get_tx_info';
		$data['key']     = $this->getPublicKey();
		$data['format']  = 'json';
		try {
			$response = $this->httpClient->request('POST', $this->getEndpoint(), $this->getHeaders($hmac), http_build_query($data));
		} catch (BadResponseException $e) {
			$response = $e->getResponse();
		}
		$result = json_decode($response->getBody()->getContents(), true);
		return new PurchaseResponse($this, $result);
	}
}
