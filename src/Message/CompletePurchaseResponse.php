<?php

namespace Omnipay\Coinpayments\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Class CompletePurchaseResponse
 * @package Omnipay\CoinPayments\Message
 */
class CompletePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return ($this->data['status'] >= 100 || $this->data['status'] == 2 || $this->data['status'] == 1) ? true : false;
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return ($this->data['status'] < 0) ? true : false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * @return null|string
     */
    public function getRedirectUrl()
    {
        return null;
    }

    /**
     * @return null|string
     */
    public function getRedirectMethod()
    {
        return null;
    }

    /**
     * @return array|null
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * @return int|string
     */
    public function getTransactionId()
    {
        return intval($this->data['txn_id']);
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return floatval($this->data['amount1']);
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->data['currency1'];
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return null;
    }
}
