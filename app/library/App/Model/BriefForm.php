<?php

namespace App\Model;
use Phalcon\Di;

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
        ];
    }

//    public function initialize() {
//
//        $this->hasMany('id', Photo::class, 'albumId', [
//            'alias' => 'Photos',
//        ]);
//    }

    /**
     * Insert brief Form Fields into table using podio result set item
     * @param $podioBriefFormItem
     * @return null
     */
    public static function createNewBriefForm($podioBriefFormItem,$app_id){

        $briefForm = new self();
        $briefForm->agency_id = 1;
        $briefForm->form_id = 1;
        $briefForm->field_type =  Di::getDefault()['brief_form']['types'][$podioBriefFormItem->type]['input'];
        $briefForm->field_label = $podioBriefFormItem->label;
        $briefForm->options = ($podioBriefFormItem->options) ? json_encode($podioBriefFormItem->options) : null;
        $briefForm->field_status = $podioBriefFormItem->status;
        $briefForm->podio_field_id = $podioBriefFormItem->field_id;
        $briefForm->podio_external_id = $podioBriefFormItem->external_id;
        $briefForm->description = $podioBriefFormItem->description;
        $briefForm->podio_app_id = $app_id;
        $success = $briefForm->save();
        if (!$success){
            echo json_encode($briefForm->getMessages());
        }
    }
}
