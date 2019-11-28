<?php

namespace Omnipay\Coinpayments\Message;

use GuzzleHttp\Exception\BadResponseException;

/**
 * Class TransferRequest
 * @package Omnipay\Coinpayments\Message
 */
class TransferRequest extends AbstractRequest {

	/**
	 * @return mixed
	 */
	public function getAutoConfirm() {
		return $this->getParameter('auto_confirm');
	}

	/**
	 * @param $value
	 *
	 * @return TransferRequest
	 */
	public function setAutoConfirm($value) {
		return $this->setParameter('auto_confirm', $value);
	}

	/**
	 * @return mixed
	 */
	public function getMerchant() {
		return $this->getParameter('merchant');
	}

	/**
	 * @param $value
	 *
	 * @return TransferRequest
	 */
	public function setMerchant($value) {
		return $this->setParameter('merchant', $value);
	}

	/**
	 * @return array|mixed
	 * @throws \Omnipay\Common\Exception\InvalidRequestException
	 */
	public function getData() {
		$this->validate('amount', 'currency', 'merchant');
		return [
			'cmd'          => 'create_transfer',
			'amount'       => $this->getAmount(),
			'currency'     => $this->getCurrency(),
			'merchant'     => $this->getMerchant(),
			'auto_confirm' => $this->getAutoConfirm(),
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
	 * @return PayByNameResponse|\Omnipay\Common\Message\ResponseInterface
	 */
	public function sendData($data) {
		$hmac = $this->getSig($data, 'create_transfer');
		$data['version'] = 1;
		$data['cmd']     = 'create_transfer';
		$data['key']     = $this->getPublicKey();
		$data['format']  = 'json';
		try {
			$response = $this->httpClient->request('POST', $this->getEndpoint(), $this->getHeaders($hmac), http_build_query($data));
		} catch (BadResponseException $e) {
			$response = $e->getResponse();
		}
		$result = json_decode($response->getBody()->getContents(), true);
		return new PayByNameResponse($this, $result);
	}
}
