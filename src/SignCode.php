<?php

namespace Chaoyenpo\SignCode;

use Illuminate\Support\Arr;

class SignCode
{
    private $secret;

    public function __construct(array $parameter)
    {
        if (isset($parameter['secret'])) {
            $this->secret = $parameter['secret'];
        } else {
            throw new Exception("Please provide secret.");
        }
    }

    public function generate($parameter): string
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

    public function check(array $parameter, $signCode = null)
    {
        $signCode = isset($signCode) ? $signCode : $parameter['signCode'];
        if (empty($signCode)) {
            throw new Exception("Can't find sign code.");
        }

        $parameter = Arr::except($parameter, 'signCode');

        if ($this->generate($parameter) !== $signCode) {
            return false;
        }
        return true;
    }

    private function keySortToString($parameter): string
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

    private function stringReplace(string $string): string
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
