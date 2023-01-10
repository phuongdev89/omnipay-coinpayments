<?php

namespace Omnipay\Coinpayments\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Response
 */
class CheckPurchaseResponse extends AbstractResponse
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
    public function getAmount()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['amount'];
        }
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['address'];
        }
    }

    /**
     * @return mixed|string
     */
    public function getTransactionId()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['txn_id'];
        }
    }

    /**
     * @return mixed
     */
    public function getConfirms()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['confirms_needed'];
        }
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['timeout'];
        }
    }

    /**
     * @return mixed
     */
    public function getStatusUrl()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['status_url'];
        }
    }

    /**
     * @return mixed
     */
    public function getQRCodeUrl()
    {
        if (isset($this->data['result'])) {
            return $this->data['result']['qrcode_url'];
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
