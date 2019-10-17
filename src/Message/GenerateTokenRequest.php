<?php

namespace Coatesap\PaymentSense\Message;

use Omnipay\Common\Message\AbstractRequest;

class GenerateTokenRequest extends AbstractRequest
{
    protected $endpoint = "https://e.test.connect.paymentsense.cloud/v1/access-tokens";

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getCurrencyCode()
    {
        return $this->getParameter('currencyCode');
    }

    public function setCurrencyCode($value)
    {
        return $this->setParameter('currencyCode', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getTransactionType()
    {
        return $this->getParameter('transactionType');
    }

    public function setTransactionType($value)
    {
        return $this->setParameter('transactionType', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getPreSharedKey()
    {
        return $this->getParameter('preSharedKey');
    }

    public function setPreSharedKey($value)
    {
        return $this->setParameter('preSharedKey', $value);
    }

    public function getData()
    {
        $data = [
            'gatewayUsername' => $this->getMerchantId(),
            'gatewayPassword' => $this->getPassword(),
            'currencyCode' => $this->getCurrencyCode(),
            'amount' => $this->getAmount(),
            'transactionType' => $this->getTransactionType(),
            'orderId' => $this->getOrderId(),
            'preSharedKey' => $this->getPreSharedKey()
        ];

        $data['preSharedKey'] = "ECUKLR5CPgP4HEJ0qiu+9vEQpXy8SrPI71vaFYfnmj4lCnEdgNo=";

        return $data;
    }

    public function sendData($data)
    {
        $headers = [

        ];

        $body = http_build_query($data, '', '&') ?? null;
        dump($body, $data);
        $httpResponse = $this->httpClient->request('post', $this->endpoint, $headers, $body);

        return $this->response = new Response($this, $httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }
}
