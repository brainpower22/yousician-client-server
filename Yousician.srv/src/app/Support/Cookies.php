<?php

namespace App\Support;

use Slim\Psr7\Cookies as BaseCookies;

class Cookies extends BaseCookies
{
    protected function toHeader(string $name, array $properties): string
    {
        if (isset($properties['encode']) && $properties['encode']) {
            $result = urlencode($name) . '=' . urlencode($properties['value']);
        } else {
            $result = $name . '=' . $properties['value'];
        }

        if (isset($properties['domain'])) {
            $result .= '; Domain=' . $properties['domain'];
        }

        if (isset($properties['expires'])) {
            if (is_string($properties['expires'])) {
                $timestamp = strtotime($properties['expires']);
            } else {
                $timestamp = (int)$properties['expires'];
            }
            if ($timestamp && $timestamp !== 0) {
                $result .= '; Expires=' . gmdate('D, d M Y H:i:s', $timestamp) . ' GMT';
            }
        }

        if (isset($properties['secure']) && $properties['secure']) {
            $result .= '; Secure';
        }

        if (isset($properties['hostonly']) && $properties['hostonly']) {
            $result .= '; HostOnly';
        }

        if (isset($properties['httponly']) && $properties['httponly']) {
            $result .= '; HttpOnly';
        }

        if (
            isset($properties['samesite'])
            && in_array(strtolower($properties['samesite']), ['lax', 'strict', 'none'], true)
        ) {
            // While strtolower is needed for correct comparison, the RFC doesn't care about case
            $result .= '; SameSite=' . $properties['samesite'];
        }

        if (isset($properties['path'])) {
            $result .= '; Path=' . $properties['path'];
        }

        return $result;
    }
}