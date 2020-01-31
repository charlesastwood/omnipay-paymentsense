<?php


namespace Medialam\PaymentSense\Message;

use Omnipay\Common\Message\AbstractRequest;

class GenerateTokenRequest extends AbstractRequest
{
    protected $testEndpoint = "https://e.test.connect.paymentsense.cloud/v1/access-tokens";
    protected $liveEndpoint = "https://e.connect.paymentsense.cloud/v1/access-tokens";

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

    public function getJWTToken()
    {
        return $this->getParameter('JWTToken');
    }

    public function setJWTToken($value)
    {
        return $this->setParameter('JWTToken', $value);
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
        ];

        return $data;
    }

    public function sendData($data)
    {
        $headers = [
            'Authorization' => "{$this->getJWTToken()}",
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
        ];

        foreach ($data as $di => $d) {
            $data[$di] = (string) $d;
        }

        if ($this->getParameter('testMode')) {
            $endpoint = $this->testEndpoint;
        } else {
            $endpoint = $this->liveEndpoint;
        }

        $httpResponse = $this->httpClient->request('POST', $endpoint, $headers, json_encode($data));

        return $this->response = new JsonResponse($this, $httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }
}
