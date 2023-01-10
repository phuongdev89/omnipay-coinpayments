<?php

namespace Omnipay\Coinpayments\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Response
 */
class WithdrawalResponse extends AbstractResponse
{

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['error']) && $this->data['error'] == 'ok';
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['id'];
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['status'];
        }
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['amount'];
        }
    }

    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return false;
    }

    /**
     * Get the response data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
