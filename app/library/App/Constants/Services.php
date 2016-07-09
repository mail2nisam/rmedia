<?php

namespace App\Constants;

class Services extends \PhalconRest\Constants\Services
{
    const CONFIG = 'config';
    const VIEW = 'view';
    const API_SERVICE = 'api';
    const PODIO = 'podio';
    const BRIEF_FORM = 'brief_form';

    public static function configFiles()
    {
        return [self::PODIO,self::BRIEF_FORM];
    }
}
