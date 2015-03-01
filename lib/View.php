<?php

class View
{
    public static function make( $viewName, array $customVars = array() )
    {
        extract( $customVars );
        require_once viewsPath() . 'template.php';
    }
}
