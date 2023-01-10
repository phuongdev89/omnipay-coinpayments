<?php

namespace Omnipay\Coinpayments\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class CompletePurchaseRequest
 * @package Omnipay\CoinPayments\Message
 */
class CompletePurchaseRequest extends AbstractRequest
{

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchant_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchant_id', $value);
    }

    /**
     * @return mixed
     */
    public function getIpnSecret()
    {
        return $this->getParameter('ipn_secret');
    }

    /**
     * @param $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setIpnSecret($value)
    {
        return $this->setParameter('ipn_secret', $value);
    }

    /**
     * @return array|mixed
     * @throws InvalidResponseException
     */
    public function getData()
    {
        if ($this->httpRequest->request->get('currency1') != $this->getCurrency()) {
            throw new InvalidResponseException('Invalid currency');
        }
        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            throw new InvalidResponseException('IPN Mode is not HMAC');
        }
        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            throw new InvalidResponseException('No HMAC signature sent.');
        }
        $request = http_build_query($this->httpRequest->request->all());
        if ($request === false || empty($request)) {
            throw new InvalidResponseException('Error reading POST data');
        }
        if (!isset($_POST['merchant']) || $_POST['merchant'] != $this->getMerchantId()) {
            throw new InvalidResponseException('No or incorrect Merchant ID passed');
        }
        $hmac = hash_hmac("sha512", $request, $this->getIpnSecret());
        if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
            throw new InvalidResponseException('HMAC signature does not match');
        }
        return $this->httpRequest->request->all();
    }

    /**
     * @param mixed $data
     *
     * @return CompletePurchaseResponse|ResponseInterface
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
