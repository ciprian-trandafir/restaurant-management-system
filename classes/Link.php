<?php

class Link
{
    public static function getLink($page, $specified = false, $params = [])
    {
        $link = Link::get_base_url().($specified ? $specified.'/' : '').$page.'.php';
        $first = true;
        if (is_array($params) && count($params)) {
            $last = array_key_last($params);
            foreach ($params as $key => $param) {
                if ($first) {
                    $first = false;
                    $link .= '?';
                }
                $link .= $key.'='.$param.($key == $last ? '' : '&');
            }
        }

        return $link;
    }

    public static function redirect($page, $specified = false, $params = [])
    {
        header('Location: ' . Link::getLink($page, $specified, $params));
    }

    public static function get_base_url() {
        return sprintf(
            "%s://%s/",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['HTTP_HOST']
        );
    }

    public static function get_current_location()
    {
        $current_location = sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );

        return basename($current_location, ".php");
    }
}
