<?php

namespace App\Transformers;

use App\Model\BriefForm;
use PhalconRest\Transformers\Transformer;

class BriefFormTransformer extends Transformer
{
    protected $availableIncludes = [
//        'photos'
    ];

    public function includePhotos(BriefForm $briefForm)
    {
        return $this->collection($briefForm->getPhotos(), new PhotoTransformer);
    }

    public function transform(BriefForm $briefForm)
    {

        return [
            'id'                => $this->int($briefForm->id),
            'agency_id'         => $this->int($briefForm->agency_id),
//          'form_id'           => $this->int($briefForm->form_id),
            'field_type'        => $briefForm->field_type,
            'field_label'       => $briefForm->field_label,
            'options'           => json_decode($briefForm->options),
            'field_status'      => $briefForm->field_status,
            'podio_field_id'    => $this->int($briefForm->podio_field_id),
            'podio_external_id' => $briefForm->podio_external_id,
            'description'       => $briefForm->description,
//            'podio_app_id'      => $this->int($briefForm->podio_app_id),
            'created_at'        => $briefForm->createdAt
        ];
    }
}
