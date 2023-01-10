<?php

namespace Omnipay\Coinpayments\Message;

use GuzzleHttp\Exception\BadResponseException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class WithdrawalRequest
 * @package Omnipay\Coinpayments\Message
 */
class WithdrawalRequest extends AbstractRequest
{

    /**
     * @return mixed
     */
    public function getPbnTag()
    {
        return $this->getParameter('pbntag');
    }

    /**
     * @param $value
     *
     * @return WithdrawalRequest
     */
    public function setPbgTag($value)
    {
        return $this->setParameter('pbntag', $value);
    }

    /**
     * @return mixed
     */
    public function getAutoConfirm()
    {
        return $this->getParameter('auto_confirm');
    }

    /**
     * @param $value
     *
     * @return WithdrawalRequest
     */
    public function setAutoConfirm($value)
    {
        return $this->setParameter('auto_confirm', $value);
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->getParameter('note');
    }

    /**
     * @param $value
     *
     * @return WithdrawalRequest
     */
    public function setNote($value)
    {
        return $this->setParameter('note', $value);
    }

    /**
     * @return mixed
     */
    public function getDestTag()
    {
        return $this->getParameter('dest_tag');
    }

    /**
     * @param $value
     *
     * @return WithdrawalRequest
     */
    public function setDestTag($value)
    {
        return $this->setParameter('dest_tag', $value);
    }

    /**
     * @return mixed
     */
    public function getAddTxFee()
    {
        return $this->getParameter('add_tx_fee');
    }

    /**
     * @param $value
     *
     * @return WithdrawalRequest
     */
    public function setAddTxFee($value)
    {
        return $this->setParameter('add_tx_fee', $value);
    }

    /**
     * @return array|mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency');
        return [
            'cmd' => 'create_withdrawal',
            'amount' => $this->getAmount(),
            'add_tx_fee' => $this->getAddTxFee(),
            'currency' => $this->getCurrency(),
            'currency2' => $this->getCurrency2(),
            'address' => $this->getAddress(),
            'pbntag' => $this->getPbnTag(),
            'dest_tag' => $this->getDestTag(),
            'ipn_url' => $this->getIPNUrl(),
            'auto_confirm' => $this->getAutoConfirm(),
            'note' => $this->getNote(),
        ];
    }

    /**
     * @param $hmac
     *
     * @return array
     */
    protected function getHeaders($hmac)
    {
        return [
            'HMAC' => $hmac,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }

    /**
     * @param mixed $data
     *
     * @return PayByNameResponse|ResponseInterface
     */
    public function sendData($data)
    {
        $hmac = $this->getSig($data, 'create_withdrawal');
        $data['version'] = 1;
        $data['cmd'] = 'create_withdrawal';
        $data['key'] = $this->getPublicKey();
        $data['format'] = 'json';
        try {
            $response = $this->httpClient->request('POST', $this->getEndpoint(), $this->getHeaders($hmac), http_build_query($data));
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }
        $result = json_decode($response->getBody()->getContents(), true);
        return new PayByNameResponse($this, $result);
    }
}
