<?php

namespace App\Resources;

use App\Controllers\BriefController;
use App\Model\BriefForm;
use PhalconRest\Api\Resource;
use PhalconRest\Api\Endpoint;
use App\Constants\AclRoles;

class BriefResource extends Resource {

    public function initialize()
    {
        $this
            ->name('BriefForm')
            ->model(BriefForm::class)
            ->expectsJsonData()
//            ->transformer(AlbumTransformer::class)
            ->itemKey('brief_form')
            ->collectionKey('brief_form')
            ->deny(AclRoles::UNAUTHORIZED)
            ->handler(BriefController::class)
            ->endpoint(Endpoint::get('/podio/fetch', 'fetch')
                ->allow(AclRoles::UNAUTHORIZED)
                ->description('Returns the currently logged in user')
            );
    }
}