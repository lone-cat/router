<?php

namespace LoneCat\Router\Router;

class RouteParser
{

    public static function parse(string $pattern): ParsedRouteInfo
    {
        preg_match_all('/(?:\{)((?>[^\{\}]+)|(?R))*(?:\})/ui', $pattern, $vars, PREG_PATTERN_ORDER);
        $vars = self::cropCurlyBraces($vars[0] ?? []);

        $vars = array_filter(
            $vars,
            function ($var) {
                return mb_strlen($var) > 0 && !preg_match('/^(?:\d+,?|,\d+|\d+,\d+)$/ui', $var);
            },
            ARRAY_FILTER_USE_BOTH);

        $replace_what = [];
        $replace_to = [];
        foreach ($vars as $key => $var) {
            $replace_what[] = '{' . $var . '}';
            $replace_to[] = '(?P<' . $vars[$key] . '>[^/]{0,})';
        }

        return new ParsedRouteInfo(str_replace($replace_what, $replace_to, $pattern), $vars);
    }

    public static function cropCurlyBraces($string)
    {
        if (is_string($string)) {
            $string = preg_replace('/^\{(.*)\}$/ui', '$1', $string);
        }
        elseif (is_array($string)) {
            foreach ($string as $key => $value) {
                $string[$key] = self::cropCurlyBraces($value);
            }
        }
        else {
            throw new \Exception('Bad data for curly braces cropping');
        }

        return $string;
    }

}