<?php

namespace Chaoyenpo\SignCode;

class SignCode
{
    private $secret;

    public function __construct(array $parameter)
    {
        if (isset($parameter['secret'])) {
            $this->secret = $parameter['secret'];
        }
    }

    public function generate($parameter)
    {
        $parameter = (array)$parameter;

        $paramString = $this->keySortToString($parameter);
        $paramString = urlencode($paramString);
        $paramString = strtolower($paramString);
        $paramString = $this->stringReplace($paramString);

        $hmacBase64 = hash_hmac('sha1', $paramString, $this->secret, true);
        $signCode = base64_encode($hmacBase64);

        return $signCode;
    }

    private function keySortToString($parameter)
    {
        ksort($parameter);
        $count = count($parameter);
        $i = 1;
        $parameterString = '';
        foreach ($parameter as $key => $value) {
            $parameterString .= $key.'='.$value;
            $parameterString .= $i < $count ? '&' : '';
            $i++;
        }
        return $parameterString;
    }

    private function stringReplace(string $string)
    {
        $string = str_replace('%2d', '-', $string);
        $string = str_replace('%5f', '_', $string);
        $string = str_replace('%2e', '.', $string);
        $string = str_replace('%21', '!', $string);
        $string = str_replace('%2a', '*', $string);
        $string = str_replace('%28', '(', $string);
        $string = str_replace('%29', ')', $string);
        return $string;
    }
}
