<?php

namespace App\Controllers;

use App\Model\BriefForm;
use PhalconRest\Mvc\Controllers\CrudResourceController;
use Phalcon\Config;
use App\Constants\Services;
use Podio;

class BriefController extends CrudResourceController
{
    public function fetch($agency_id,$app_id){

        $conditions = "agency_id = ?1 AND podio_app_id = ?2";
        $parameters = array(1 => $agency_id,2 => $app_id);
        $briefForm =  BriefForm::find([$conditions,"bind" => $parameters]);
        return $this->createResourceCollectionResponse($briefForm);
    }
    public function getBriefForm(){
        $podioConfig = $this->di->get(Services::PODIO);
        Podio::setup($podioConfig->client_id,$podioConfig->client_secret);
        try{
            Podio::authenticate_with_app($podioConfig->apps->briefs->app_id,$podioConfig->apps->briefs->app_secret);
        }catch (Exception $e){
            throw new Exception('Authentication Error');
        }
        $webForm = \PodioForm::get($podioConfig->apps->briefs->web_form_id);

        var_dump($webForm);
    }
    
    public function briefFormSync($app_id)
    {
        $podioConfig = $this->di->get(Services::PODIO);
        Podio::setup($podioConfig->client_id,$podioConfig->client_secret);
        try{
            Podio::authenticate_with_app($app_id,$podioConfig->apps->$app_id->app_secret);
        }catch (Exception $e){
            throw new Exception('Authentication Error');
        }

        $briefApp = \PodioApp::get($app_id);
        $formattedFields = [];
        foreach ($briefApp->fields as $key => $field) {
            $formattedFields[] = $this->briefFormFields($field);
        }

        foreach ($formattedFields as $podioBriefFormItem) {
            $podioBriefFormItem = (object) $podioBriefFormItem;
            if($podioBriefFormItem->status!='active'){
                continue;
            }
            if(!$this->isFieldExist($podioBriefFormItem, $app_id)){
                BriefForm::createNewBriefForm($podioBriefFormItem,$app_id);
            }
        }
    }

    protected function isFieldExist($podioBriefFormItem, $app_id)
    {
        $conditions = "agency_id = ?1 AND podio_app_id = ?2 AND podio_field_id = ?3";
        $parameters = array(1 => 1, 2 => $app_id, 3 => $podioBriefFormItem->field_id);
        $formElements   = BriefForm::findFirst([$conditions,"bind" => $parameters]);

        return ($formElements) ? true : false ;
    }

    /**
     *
     * Iterating each podio field entry through brief form config items
     * @param $field
     * @return array
     */
    protected function briefFormFields($field)
    {
        $briefFormConfig = $this->di->get(Services::BRIEF_FORM);

        $formattedFieldDetails = [];

        foreach ($briefFormConfig->fields as $config) {
            if (self::isCombinationField($config)) {
                $configChunks = explode("~", $config);
                $filedConfigArray = $field->$configChunks[0];
                $formattedFieldDetails[$configChunks[1]] = $filedConfigArray[$configChunks[1]];
            } else {
                $formattedFieldDetails[$config] = $field->$config;
            }
        }

        if($field->type=='category'){
            $filedConfigArray = $field->config;
            $formattedFieldDetails['options']= $filedConfigArray['settings']['options'];
        }else{
            $formattedFieldDetails['options']=[];
        }
        return $formattedFieldDetails;
    }

    /**
     *
     * Checking the individual conf field is combined with ~ or not
     * @param $config
     * @return bool
     */
    protected static function isCombinationField($config)
    {
        return (strpos($config, '~') > 0);
    }
}
