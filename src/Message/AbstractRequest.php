<?php

namespace Omnipay\Coinpayments\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Class AbstractRequest
 * @package Omnipay\Coinpayments\Message
 */
abstract class AbstractRequest extends BaseAbstractRequest {

	protected $liveEndpoint = "https://www.coinpayments.net/api.php";

	/**
	 * @return mixed
	 */
	public function getPrivateKey() {
		return $this->getParameter('private_key');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setPrivateKey($value) {
		return $this->setParameter('private_key', $value);
	}

	/**
	 * @return mixed
	 */
	public function getPublicKey() {
		return $this->getParameter('public_key');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setPublicKey($value) {
		return $this->setParameter('public_key', $value);
	}

	/**
	 * @return mixed|string
	 */
	public function getCurrency() {
		return $this->getParameter('currency');
	}

	/**
	 * @param string $value
	 *
	 * @return AbstractRequest|BaseAbstractRequest
	 */
	public function setCurrency($value) {
		return $this->setParameter('currency', $value);
	}

	/**
	 * @return mixed|string
	 */
	public function getAmount() {
		return $this->getParameter('amount');
	}

	/**
	 * @param string|null $value
	 *
	 * @return AbstractRequest|BaseAbstractRequest
	 */
	public function setAmount($value) {
		return $this->setParameter('amount', $value);
	}

	/**
	 * @return mixed
	 */
	public function getTxid() {
		return $this->getParameter('txid');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setTxid($value) {
		return $this->setParameter('txid', $value);
	}

	/**
	 * @return mixed
	 */
	public function getCurrency1() {
		return $this->getParameter('currency1');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setCurrency1($value) {
		return $this->setParameter('currency1', $value);
	}

	/**
	 * @return mixed
	 */
	public function getCurrency2() {
		return $this->getParameter('currency2');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setCurrency2($value) {
		return $this->setParameter('currency2', $value);
	}

	/**
	 * @return mixed
	 */
	public function getAddress() {
		return $this->getParameter('address');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setAddress($value) {
		return $this->setParameter('address', $value);
	}

	/**
	 * @return mixed
	 */
	public function getBuyerEmail() {
		return $this->getParameter('buyer_email');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setBuyerEmail($value) {
		return $this->setParameter('buyer_email', $value);
	}

	/**
	 * @return mixed
	 */
	public function getBuyerName() {
		return $this->getParameter('buyer_name');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setBuyerName($value) {
		return $this->setParameter('buyer_name', $value);
	}

	/**
	 * @return mixed
	 */
	public function getItemName() {
		return $this->getParameter('item_name');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setItemName($value) {
		return $this->setParameter('item_name', $value);
	}

	/**
	 * @return mixed
	 */
	public function getItemNumber() {
		return $this->getParameter('item_number');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setItemNumber($value) {
		return $this->setParameter('item_number', $value);
	}

	/**
	 * @return mixed
	 */
	public function getInvoice() {
		return $this->getParameter('invoice');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setInvoice($value) {
		return $this->setParameter('invoice', $value);
	}

	/**
	 * @return mixed
	 */
	public function getCustom() {
		return $this->getParameter('custom');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setCustom($value) {
		return $this->setParameter('custom', $value);
	}

	/**
	 * @return mixed
	 */
	public function getIPNUrl() {
		return $this->getParameter('ipn_url');
	}

	/**
	 * @param $value
	 *
	 * @return AbstractRequest
	 */
	public function setIPNUrl($value) {
		return $this->setParameter('ipn_url', $value);
	}

	/**
	 * @param $req
	 * @param $cmd
	 *
	 * @return string
	 */
	protected function getSig($req, $cmd) {
		$req['version'] = 1;
		$req['cmd']     = $cmd;
		$req['key']     = $this->getPublicKey();
		$req['format']  = 'json'; //supported values are json and xml
		foreach ($req as $key => $item) {
			if ($item == "") {
				unset($req[$key]);
			}
		}
		// Generate the query string
		$post_data = http_build_query($req, '', '&');
		// Calculate the HMAC signature on the POST data
		$hmac = hash_hmac('sha512', $post_data, $this->getPrivateKey());
		return $hmac;
	}

	/**
	 * @return string
	 */
	protected function getEndpoint() {
		return $this->liveEndpoint;
	}
}
