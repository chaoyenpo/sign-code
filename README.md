# Sign code

## Generate

```php
use Chaoyenpo\SignCode\SignCode;

$signCodeTool = new SignCode([
                        'secret' => 'abc',
                        'sign_code_property_name' => 'signCode'
                    ]);

$parameter = [
    'merchantID' => 'ABC001',
    'amount' => '999.00'
];

$signCode = $signCodeTool->generate($parameter);
```

## Check

```php
use Chaoyenpo\SignCode\SignCode;

$signCodeTool = new SignCode(['secret' => 'abc']

// Mock response body array
$responseBody = [
    'merchantID' => 'ABC001',
    'amount' => '999.00',
    'message' => 'success',
    'signCode' => 'ZKmwdHCx24Ce+ZxR05jbL3CR6Ug='
];

if ($signCodeTool->check($responseBody)) {
    // The SignCode is verified...
}
```
