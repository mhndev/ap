<?php

namespace mhndev\ap;

use mhndev\ap\Interfaces\iPaymentClient;
use SoapClient;

class Client implements iPaymentClient
{

    /**
     * @var SoapClient
     */
    protected $soapClient;


    /**
     * @var Crypto
     */
    protected $crypto;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $callBackUrl;

    /**
     * @var array
     */
    protected $merchant;


    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        if(empty($config['key'])          ||
            empty($config['iv'])          ||
            empty($config['username'])    ||
            empty($config['password'])    ||
            empty($config['callBackUrl']) ||
            empty($config['merchant'])
        )
            throw new \InvalidArgumentException;


        $this->soapClient  = @new soapclient($config['payment_service_address']);
        $this->crypto      = new Crypto($config['key'], $config['iv']);
        $this->username    = $config['username'];
        $this->password    = $config['password'];
        $this->callBackUrl = $config['callBackUrl'];
        $this->merchant    = $config['merchant'];

    }

    /**
     * @param integer $amount
     * @param integer $orderId
     * @param mixed $info
     * @return mixed
     */
    function pay($amount, $orderId, $info)
    {
        $p6 = $this->calculateTime();
        $p7 = is_string($info) ? $info : json_encode($info);

        if(strlen($p7) > 100)
            trigger_error('Payment info can\'t be more than 100 characters', E_USER_WARNING);

        $string = "1,$this->username,$this->password,$orderId,$amount,$p6,$p7,$this->callBackUrl,0";

        $params = [
            'merchantConfigurationID'=>$this->merchant['merchantConfigurationID'] ,
            'encryptedRequest'=>$this->crypto->encrypt($string)
        ];

        $result = $this->soapClient->RequestOperation($params);

        return $result->RequestOperationResult;
    }

    /**
     * @param integer $payGateTranId
     * @return mixed
     */
    function verify($payGateTranId)
    {
        $params = [
            'merchantConfigurationID'=> $this->merchant['merchantConfigurationID'],
            'encryptedCredentials' => $this->crypto->encrypt($this->username.','.$this->password),
            'payGateTranID'        => $payGateTranId
        ];

        return $this->soapClient->RequestVerification($params);
    }

    function reverse($payGateTranId)
    {
        $params = [
            'merchantConfigurationID'=> $this->merchant['merchantConfigurationID'],
            'encryptedCredentials' => $this->crypto->encrypt($this->username.','.$this->password),
            'payGateTranID'        => $payGateTranId
        ];

        $result = $this->soapClient->RequestReversal($params);

        return $result->RequestReversalResult;
    }

    function reconciliation($payGateTranId)
    {
        $params = [
            'merchantConfigurationID'=> $this->merchant['merchantConfigurationID'],
            'encryptedCredentials' => $this->crypto->encrypt($this->username.','.$this->password),
            'payGateTranID'        => $payGateTranId
        ];

        $result = $this->soapClient->RequestReconciliation($params);

        return $result->RequestReconciliationResult;
    }


    protected function calculateTime()
    {
        $result = date('Ymd His', time());

        return $result;
    }
}
