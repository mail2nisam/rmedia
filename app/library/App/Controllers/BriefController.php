<?php

namespace App\Controllers;

use App\Model\BriefForm;
use PhalconRest\Mvc\Controllers\CrudResourceController;
use Phalcon\Config;
use App\Constants\Services;

class BriefController extends CrudResourceController
{
    public function fetch(){
//        $config = $this->di->get(Services::PODIO);


        $conditions = "agency_id = ?1 AND form_id = ?2";
        $parameters = array(1 => 1, 2 => 1);
        $formElements     = BriefForm::find([$conditions,"bind" => $parameters]);
        $result = [];
        $textInputs = [];
        $selectInputs = [];
        foreach ($formElements as $formElement){

            switch ($formElement->field_type){
                case "text" :
                    $textInputs['type']= "text";
                    $textInputs["data"][] = $formElement->toArray();
                    break;
                case "select" :
                    $selectInputs['type']= "select";
                    $formElement->options = json_decode($formElement->options);
                    $selectInputs["data"][] = $formElement->toArray();
                    break;
            }
        }
        array_push($result,$textInputs,$selectInputs);
        return $result;

    }
}
