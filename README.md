the most easy to use package for paying with AP (Asan Pardakht) for iranian

you can pay by :

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

you can verify payment simply by :

```php
$client->verify(12);
```
which 12 is pay gate id (after pay request you have this number);

and also you can reverse your payment :

```php
$client->reverse(12);

```


other available methods :

```php
$clinet->reconciliation(12)
```