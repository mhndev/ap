<?php

namespace mhndev\ap\Interfaces;

interface iPaymentClient
{
    /**
     * @param integer $amount
     * @param integer $orderId
     * @param string $info
     * @return mixed
     */
    function pay($amount, $orderId, $info);


    /**
     * @param integer $payGateTranId
     * @return mixed
     */
    function verify($payGateTranId);


    /**
     * @param $payGateTranId
     * @return mixed
     */
    function reverse($payGateTranId);


    /**
     * @param $payGateTranId
     * @return mixed
     */
    function reconciliation($payGateTranId);


}
