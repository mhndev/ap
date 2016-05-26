the most easy to use package for paying with AP (Asan Pardakht) for iranian

actually this a request to initial a pay request to bank .
you can initial a pay request as follow :

## RequestOperation
```php

$client = new \mhndev\ap\Client([
    'merchant'=>[
        'merchant_name'=>'POOYA AFARIN MABNA',
        'merchant_ip'=>'130.185.76.200',
        'merchant_id'=>'768327',
        'merchantConfigurationID'=>608,
    ],
    'payment_service_address'=>'https://services.asanpardakht.net/paygate/merchantservices.asmx?WSDL',
    'callBackUrl'=>'http://webtest.cafeshekam.ir/gateway/call-back',
    'key' => 'u/S3A0LyRCrKsCTKoAWgwB0/SSKlgqqG7IFdk3z7MvM=',
    'iv' => 'UF7YFMSB36wj8Vd0ZJv3Ic0IC+idtwlz9utybJYlWoA=',
    'username' => 'MABNA768327',
    'password' => 'Q5r4UYi8poW2Ey'
]);

$client->pay(100000, 12 , 'sample description for this payment');

```

consider that you can also store your configuration in a file and instead include file in Client class constructor.

```php
$client = new \mhndev\ap\Client(include 'path/to/my/config/file');

$client->pay(100000, 12 , 'sample description for this payment');

```

‫‪## RequestVerification‬‬
after pay request is done bank will call your callback page with some parameters 
 and after that you should do a verify request to verify the sent pay request

you can verify payment simply by :
```php
$client->verify(12);
```
which 12 is pay gate id (after pay request you have this number and its unique for each pay request);

‫‪## RequestReversal‬‬
after pay request is done and bank has sent you the success response you can do a reverse request which reverse the pay request process and it means.
you cant do reverse request after verify request.
and also you can reverse your payment :

```php
$client->reverse(12);

```
which 12 is pay gate id (after pay request you have this number and its unique for each pay request);


## ‫‪RequestReconciliation‬‬

this request is for settlement of a verified pay request

```php
$clinet->reconciliation(12)
```
