<?php

namespace App\Resources;

use App\Controllers\BriefController;
use App\Model\BriefForm;
use App\Transformers\BriefFormTransformer;
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
            ->transformer(BriefFormTransformer::class)
            ->itemKey('brief_form')
            ->collectionKey('brief_form')
            ->allow(AclRoles::UNAUTHORIZED)
            ->handler(BriefController::class)
            ->endpoint(Endpoint::get('/ageny/{agency_id}/app/{app_id}', 'fetch')
                ->allow(AclRoles::UNAUTHORIZED)
                ->description('Returns the currently logged in user')
                ->expectsJsonData()
            )->endpoint(Endpoint::get('/podio/form', 'getBriefForm')
                ->allow(AclRoles::UNAUTHORIZED)
                ->description('Get the web form active fields from brief app')
            )->endpoint(Endpoint::get('/podio/sync/{app_id}', 'briefFormSync')
                ->allow(AclRoles::UNAUTHORIZED)
                ->description('Get the web form active fields from brief app')
            );
    }
}