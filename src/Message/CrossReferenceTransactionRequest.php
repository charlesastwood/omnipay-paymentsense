<?php

namespace Medialam\PaymentSense\Message;

use DOMDocument;
use SimpleXMLElement;
use Omnipay\Common\Message\AbstractRequest;

/**
 * PaymentSense Purchase Request
 */
class CrossReferenceTransactionRequest extends AbstractRequest
{
    protected $endpoint = 'https://gw1.paymentsensegateway.com:4430/';
    protected $namespace = 'https://www.thepaymentgateway.net/';

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

    public function getAction()
    {
        return $this->getParameter('action');
    }

    public function setAction($value)
    {
        return $this->setParameter('action', $value);
    }

    public function getCardReference()
    {
        return $this->getParameter('cardReference');
    }

    public function setCardReference($value)
    {
        return $this->setParameter('cardReference', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'cardReference');

        $data = new SimpleXMLElement('<CrossReferenceTransaction/>');
        $data->addAttribute('xmlns', $this->namespace);

        $data->PaymentMessage->MerchantAuthentication['MerchantID'] = $this->getMerchantId();
        $data->PaymentMessage->MerchantAuthentication['Password'] = $this->getPassword();
        $data->PaymentMessage->TransactionDetails['Amount'] = $this->getAmountInteger();
        $data->PaymentMessage->TransactionDetails['CurrencyCode'] = $this->getCurrencyNumeric();
        $data->PaymentMessage->TransactionDetails->OrderID = $this->getTransactionId();
        $data->PaymentMessage->TransactionDetails->OrderDescription = $this->getDescription();
        $data->PaymentMessage->TransactionDetails->MessageDetails['TransactionType'] = $this->getAction();
        $data->PaymentMessage->TransactionDetails->MessageDetails['CrossReference'] = $this->getCardReference();

        if ($this->getCard()) {
            $this->getCard()->validate();
            $data->PaymentMessage->OverrideCardDetails->CardName = $this->getCard()->getName();
            $data->PaymentMessage->OverrideCardDetails->CardNumber = $this->getCard()->getNumber();
            $data->PaymentMessage->OverrideCardDetails->ExpiryDate['Month'] = $this->getCard()->getExpiryDate('m');
            $data->PaymentMessage->OverrideCardDetails->ExpiryDate['Year'] = $this->getCard()->getExpiryDate('y');
            $data->PaymentMessage->OverrideCardDetails->CV2 = $this->getCard()->getCvv();

            if ($this->getCard()->getIssueNumber()) {
                $data->PaymentMessage->OverrideCardDetails->IssueNumber = $this->getCard()->getIssueNumber();
            }

            if ($this->getCard()->getStartMonth() && $this->getCard()->getStartYear()) {
                $data->PaymentMessage->OverrideCardDetails->StartDate['Month'] = $this->getCard()->getStartDate('m');
                $data->PaymentMessage->OverrideCardDetails->StartDate['Year'] = $this->getCard()->getStartDate('y');
            }
            $data->PaymentMessage->CustomerDetails->BillingAddress->Address1 = $this->getCard()->getAddress1();
            $data->PaymentMessage->CustomerDetails->BillingAddress->Address2 = $this->getCard()->getAddress2();
            $data->PaymentMessage->CustomerDetails->BillingAddress->City = $this->getCard()->getCity();
            $data->PaymentMessage->CustomerDetails->BillingAddress->PostCode = $this->getCard()->getPostcode();
            $data->PaymentMessage->CustomerDetails->BillingAddress->State = $this->getCard()->getState();
            // requires numeric country code
            // $data->PaymentMessage->CustomerDetails->BillingAddress->CountryCode = $this->getCard()->getCountryNumeric;
        }
        $data->PaymentMessage->CustomerDetails->CustomerIPAddress = $this->getClientIp();

        return $data;
    }

    public function sendData($data)
    {
        // the PHP SOAP library sucks, and SimpleXML can't append element trees
        // TODO: find PSR-0 SOAP library
        $document = new DOMDocument('1.0', 'utf-8');
        $envelope = $document->appendChild(
            $document->createElementNS('http://schemas.xmlsoap.org/soap/envelope/', 'soap:Envelope')
        );
        $envelope->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $envelope->setAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        $body = $envelope->appendChild($document->createElement('soap:Body'));
        $body->appendChild($document->importNode(dom_import_simplexml($data), true));

        // post to Cardsave
        $headers = array(
            'Content-Type' => 'text/xml; charset=utf-8',
            'SOAPAction' => $this->namespace . $data->getName());

        $httpResponse = $this->httpClient->request('POST', $this->endpoint, $headers, $document->saveXML());

        return $this->response = new Response($this, $httpResponse->getBody());
    }
}
