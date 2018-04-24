<?php

require __DIR__.'/../vendor/autoload.php';

use Chaoyenpo\SignCode\SignCode;

$parameter = [
    'merchantID' => 'ABC001',
    'amount' => '999.00'
];

$signCodeGenerator = new SignCode(['secret' => 'abc']);
$signCode = $signCodeGenerator->generate($parameter);
echo $signCode;
