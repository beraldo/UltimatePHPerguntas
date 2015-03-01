<?php

/**
 * Class para proteção contra XSS
 */
class XSS
{
    public static function filter( $data )
    {
        return htmlspecialchars( $data );
    }
}