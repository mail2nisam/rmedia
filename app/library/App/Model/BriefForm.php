<?php

namespace App\Model;

class BriefForm extends \App\Mvc\DateTrackingModel
{
    public $id;
    public $title;

    public function getSource()
    {
        return 'brief_form';
    }

    public function columnMap()
    {
        //`ternal_id`, `description`, `podio_app_id`, `podio_space_id`, `podio_app_secret`
        return parent::columnMap() + [
            'id' => 'id',
            'agency_id' => 'agency_id',
            'form_id' => 'form_id',
            'field_type' => 'field_type',
            'field_label' => 'field_label',
            'options' => 'options',
            'field_status' => 'field_status',
            'podio_field_id' => 'podio_field_id',
            'podio_external_id' => 'podio_external_id',
            'description' => 'description',
            'podio_app_id' => 'podio_app_id',
            'podio_space_id' => 'podio_space_id',
            'podio_app_secret' => 'podio_app_secret',
        ];
    }

//    public function initialize() {
//
//        $this->hasMany('id', Photo::class, 'albumId', [
//            'alias' => 'Photos',
//        ]);
//    }
}
