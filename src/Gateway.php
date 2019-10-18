<?php

namespace Coatesap\PaymentSense;

use Coatesap\PaymentSense\Message\CompletePurchaseRequest;
use Coatesap\PaymentSense\Message\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

/**
 * PaymentSense Gateway
 *
 * @link http://developers.paymentsense.co.uk/
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'PaymentSense';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId' => '',
            'password' => '',
            'preSharedKey' => '',
            'JWTToken' => ''
        );
    }

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

    public function getPreSharedKey()
    {
        return $this->getParameter('preSharedKey');
    }

    public function setPreSharedKey($value)
    {
        return $this->setParameter('preSharedKey', $value);
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

    public function getJWTToken()
    {
        return $this->getParameter('JWTToken');
    }

    public function setJWTToken($value)
    {
        return $this->setParameter('JWTToken', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Coatesap\PaymentSense\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Coatesap\PaymentSense\Message\CompletePurchaseRequest', $parameters);
    }

    public function generatePaymentToken(array $parameters = [])
    {
        return $this->createRequest('\Coatesap\PaymentSense\Message\GenerateTokenRequest', $parameters);
    }
}
