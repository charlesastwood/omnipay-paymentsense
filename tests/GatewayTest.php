<?php

namespace Medialam\PaymentSense;

use DateInterval;
use DateTime;
use Omnipay\Common\CreditCard;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'returnUrl' => 'https://www.example.com/return',
            'card' => new CreditCard(
                array(
                'firstName' => 'Example',
                'lastName' => 'User',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => $this->getFutureYear(),
                'cvv' => '123',
                'issueNumber' => '5',
                'startMonth' => '4',
                'startYear' => '2013',
                )
            ),
        );

        $this->refundOptions = array(
            'amount' => '10.00',
            'transactionReference' => '130215141054377801316798'
        );
    }

    public function testPurchase()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertInstanceOf('\Medialam\PaymentSense\Message\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('130215141054377801316798', $response->getTransactionReference());
    }

    public function testPurchaseError()
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame('Input variable errors', $response->getMessage());
    }

    //    public function testSupportsRefund()
    //    {
    //        $this->setMockHttpResponse('RefundSuccess.txt');
    //        $response = $this->gateway->supportsRefund();
    //
    //        $this->assertTrue($response);
    //    }

    //    public function testRefundParameters()
    //    {
    //        $this->setMockHttpResponse('RefundSuccess.txt');
    //        $response = $this->gateway->refund($this->refundOptions)->send();
    //
    //        $this->assertEquals('130215141054377801316798', $response->getTransactionReference());
    //    }
    //
    //    public function testRefund()
    //    {
    //        $this->setMockHttpResponse('RefundSuccess.txt');
    //
    //        $response = $this->gateway->refund($this->refundOptions)->send();
    //
    //        $this->assertTrue($response->isSuccessful());
    //        $this->assertEquals('130215141054377801316798', $response->getTransactionReference());
    //    }

    private function getFutureYear()
    {
        $now = new DateTime();
        $now->add(new DateInterval('P1Y'));

        return $now->format('Y');
    }
}
