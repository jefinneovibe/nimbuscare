<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\IibWidgets;
use App\BusinessInsuredOptions;
use App\WorkTypeForms;
use App\WorkTypeData;
use stdClass;
use MongoDB\BSON\ObjectID;

class WidgetsCreationController extends Controller
{
    public function widgetSave()    //only for basic details ie create document  with single step
    {
        //full name
        $form_obj = new WorkTypeForms();
        $form_obj->name = "Worksman compensation";
        $form_obj->worktypeId = new ObjectId();

        //Stages
        $stage_obj = new \stdClass();
        $stage_obj->name = 'E Questionnaire';

        //steps
        $step_obj = new \stdClass();
        $step_obj->name = 'Basic Details';

        //rows
        $row_obj1 = new \stdClass();
        $row_obj1->config = "";


        //field
        $field_obj1 = new \stdClass();
        $field_obj1->widgetType = 'text';
        $field_obj1->sort = 1;
        //validation
        $validation_obj1 = new \stdClass();
        // $validation_obj1->required = true;
        // $validation_obj1->maxlength = '250';

        $relation_obj1 = new \stdClass();
        $relation_obj1->relatedTo = false;

        $style_obj1 = new \stdClass();
        $style_obj1->col_width='12';

        $config_obj1 = new \stdClass();
        $config_obj1->label = "Please Enter the Full Name of your Enterprise / Individual";
        $config_obj1->placeHolder = "Please Enter the Full Name of your Enterprise / Individual";
        $config_obj1->fieldName = 'firstName';
        $config_obj1->id = 'firstName';
        $config_obj1->eSlipVisibility = true;
        $config_obj1->validation = $validation_obj1;
        $config_obj1->relation = $relation_obj1;
        $config_obj1->style = $style_obj1;
        $field_obj1->config = $config_obj1;
        $fields = [$field_obj1];

        $validation_obj = new \stdClass();
        $validation_obj->field = "firstName";
        $rule = new \stdClass();
        $rule->required = true;
        $rule->maxlength = 50;
        $validation_obj->validation = $rule;

        $msg = new \stdClass();
        $msg->required = 'Enter first name';
        $msg->maxlength = 'Maximum length exceeded';
        $validation_obj->messages = $msg;




        $row_obj1->fields = $fields;

        $row_obj2 = new \stdClass();    //2nd row
        $row_obj2->config = "";
        $row_obj2->fields = $fields;

        $row_obj3 = new \stdClass();    //2nd row
        $row_obj3->config = "";
        $row_obj3->fields = $fields;

        $step_obj->rows = [$row_obj1,$row_obj2,$row_obj3];
        $step_obj->validations = [$validation_obj];
        $stageEquest = new \stdClass();
        $stageEquest->basicDetails = $step_obj;
        $stage_obj->steps = $stageEquest;
        $stageEquest = new \stdClass();

        $stageEquest->eQuestionnaire = $stage_obj;
        $form_obj->stages = $stageEquest;



        $form_obj->save();


        return "success";
    }
    public function widgetUpdate($id)   //fields updation
    {

        //field
        $field_obj1 = new \stdClass();
        $field_obj1->widgetType = 'Text';
        $field_obj1->sort = 9;


        $relation_obj1 = new \stdClass();
        $relation_obj1->relatedTo = false;

        $style_obj1 = new \stdClass();
        $style_obj1->col_width='4';


        $config_obj1 = new \stdClass();
        $config_obj1->label = "SPECIAL CONDITION";
        $config_obj1->placeHolder = "Enter here";
        $config_obj1->fieldName = "specialCondition";
        $config_obj1->id = 'specialCondition';
        $config_obj1->eQuotationVisibility = true;
        $config_obj1->relation = $relation_obj1;
        $config_obj1->style = $style_obj1;

        //options for select
        // $option_obj1 = new \stdClass();
        // $option_obj1->option_id = 'yes';
        // $option_obj1->option_value = 'Yes';
        // $option_obj2 = new \stdClass();
        // $option_obj2->option_id = 'no';
        // $option_obj2->option_value = 'No';

        // $option_obj = [$option_obj1, $option_obj2];
        // $config_obj1->options = $option_obj;
        $field_obj1->config = $config_obj1;

        //validation
        $validation_obj = new \stdClass();
        $validation_obj->field = "specialCondition";
        $rule = new \stdClass();
        $rule->required = true;
        //$rule->maxlength = 6;
        $validation_obj->validation = $rule;

        $msg = new \stdClass();
        $msg->required = 'Enter specialCondition';
        //$msg->maxlength = 'maximum length exceeded';
        $validation_obj->messages = $msg;

        $fields = [$field_obj1];
        $result = WorkTypeForms::where('_id', new ObjectId($id))->push(['stages.eSlip.steps.forms.rows.8.fields'=> $field_obj1, 'stages.eSlip.steps.forms.validations' => $validation_obj]);
        return $result;
    }
    public function widgetSave2()   //only for basic details
    {
        //full name
        $form_obj1 = new IibWidgets();
        $form_obj1->name = "Worksman compensation";
        $form_obj1->worktypeId = new ObjectId();

        //Stages
        $stage_obj1 = new \stdClass();
        $stage_obj1->name = 'E Questionnaire';

        //steps
        $step_obj1 = new \stdClass();
        $step_obj1->name = 'Basic Details';


        //field
        $field_obj1 = new \stdClass();
        $field_obj1->widgetType = 'text';
        $field_obj1->sort = 1;
        //validation
        $validation_obj1 = new \stdClass();
        $validation_obj1->required = true;
        $validation_obj1->max = '250';

        $relation_obj1 = new \stdClass();
        $relation_obj1->relatedTo = false;

        $config_obj1 = new \stdClass();
        $config_obj1->label = "First Name";
        $config_obj1->fieldName = 'firstName';
        $config_obj1->validation = $validation_obj1;
        $config_obj1->relation = $relation_obj1;
        $field_obj1->config = $config_obj1;


        //field2
        $field_obj2 = new \stdClass();
        $field_obj2->widgetType = 'textarea';
        $field_obj2->sort = 2;

        $config_obj2 = new \stdClass();
        $config_obj2->label = "Address Line 1";
        $config_obj2->fieldName = 'address_1';

        //validation
        $validation_obj2 = new \stdClass();
        $validation_obj2->required = true;
        $validation_obj2->max = '500';

        $relation_obj2 = new \stdClass();
        $relation_obj2->relatedTo = false;

        $config_obj2->validation = $validation_obj2;
        $config_obj2->relation = $relation_obj2;
        $field_obj2->config = $config_obj2;



        //field3
        $field_obj3 = new \stdClass();
        $field_obj3->widgetType = 'select';
        $field_obj3->sort = 3;
        $config_obj3 = new \stdClass();
        $config_obj3->label = "Country Name";
        $config_obj3->fieldName = 'country_name';

        //validation
        $validation_obj3 = new \stdClass();
        $validation_obj3->required = true;

        $relation_obj3 = new \stdClass();
        $relation_obj3->relatedTo = 'state';

        $config_obj3->validation = $validation_obj3;
        $config_obj3->relation = $relation_obj3;
        $field_obj3->config = $config_obj3;

        //field4
        $field_obj4 = new \stdClass();
        $field_obj4->widgetType = 'insurance_companies';
        $field_obj4->sort = 4;
        $config_obj4 = new \stdClass();
        $config_obj4->label = "Insurance Companies";
        $config_obj4->fieldName = 'insurer';

        //validation
        $validation_obj4 = new \stdClass();
        $validation_obj4->required = true;

        $relation_obj4 = new \stdClass();
        $relation_obj4->relatedTo = false;

        $config_obj4->validation = $validation_obj4;
        $config_obj4->relation = $relation_obj4;
        $field_obj4->config = $config_obj4;


        $fields = [$field_obj1, $field_obj2, $field_obj3, $field_obj4];
        $step_obj1->fields = $fields;
        $stageEquest = new \stdClass();
        $stageEquest->basicDetails = $step_obj1;
        $stage_obj1->steps = $stageEquest;
        $stageEquest = new \stdClass();

        $stageEquest->eQuestionnaire = $stage_obj1;
        // $stage_obj1->steps = [$step_obj1];
        $form_obj1->stages = $stageEquest;



        $form_obj1->save();


        return "success";

        // $name = "Widget Test";
        // $widgets = IibWidgets::find($name);
        // if (empty($widgets)) {
        //     $widgets = new IibWidgets();
        //     $widgets->name = "Widget Test";
        //     $widgets->class = "widgetTest";
        //     $widgets->save();
        // } else {
        //     echo "exists";
        // }
        // return "success";
    }
    public function businessDetails(Request $request)   //not completed
    {
        // $business = IibWidgets::find("5dca4f88fad03b16bebdb695");
        // $business->stages->eQuestionnaire->
        $rows  = [];
        $row_config = "";
        $fields = [];
        $column = new \stdClass();
        // $column->widgetType =




    }
    public function stepUpdate($id)  //dynamic form  structure step update
    {
         //steps
         $step_obj = new \stdClass();
         $step_obj->name = 'Documents';

         //rows
         $row_obj1 = new \stdClass();
         $row_obj1->config = "";


         //field
         $field_obj1 = new \stdClass();
         $field_obj1->widgetType = 'pdfUpload';
         $field_obj1->sort = 1;
         //validation
         $validation_obj1 = new \stdClass();
         // $validation_obj1->required = true;
         // $validation_obj1->maxlength = '250';

         $relation_obj1 = new \stdClass();
         $relation_obj1->relatedTo = false;

         $style_obj1 = new \stdClass();
         $style_obj1->col_width='12';

         $config_obj1 = new \stdClass();
         $config_obj1->label = "Tax Registration Document";
         $config_obj1->placeHolder = "Drag your files or click here";
         $config_obj1->fieldName = 'taxRegistrationDocument';
         $config_obj1->id = 'taxRegistrationDocument';
         $config_obj1->eSlipVisibility = false;
         $config_obj1->validation = $validation_obj1;
         $config_obj1->relation = $relation_obj1;
         $config_obj1->style = $style_obj1;
         $field_obj1->config = $config_obj1;
         $fields = [$field_obj1];

         $validation_obj = new \stdClass();
         $validation_obj->field = "taxRegistrationDocument";
         $rule = new \stdClass();
         $rule->required = true;
         //$rule->maxlength = 50;
         $validation_obj->validation = $rule;

         $msg = new \stdClass();
         $msg->required = 'Select tax registration document';
         //$msg->maxlength = 'Maximum length exceeded';
         $validation_obj->messages = $msg;




         $row_obj1->fields = $fields;

        //  $row_obj2 = new \stdClass();    //2nd row
        //  $row_obj2->config = "";
        //  $row_obj2->fields = $fields;

        //  $row_obj3 = new \stdClass();    //3rd row
        //  $row_obj3->config = "";
        //  $row_obj3->fields = $fields;



         $step_obj->rows = [$row_obj1];
         $step_obj->validations = [$validation_obj];

        $formData = WorkTypeForms::where('_id', new ObjectId('5dcb7ea2354c1b03b036e2b3'))->first();
        $stepData = $formData->stages['eQuestionnaire']['steps'];
        // $stepArr = $stageData->steps['basicDetails'];
        //$stepData = $stageData['steps'];
        //$stepArr['basicDetails'] = $stepData;
        $stepData['documents'] = $step_obj;
        $result = WorkTypeForms::where('_id', new ObjectId('5dcb7ea2354c1b03b036e2b3'))->update(['stages.eQuestionnaire.steps'=> $stepData]);
        return $result;
    }
    public function stageUpdate()
    {
         //Stages
         $stage_obj = new \stdClass();
         $stage_obj->name = 'E Slip';

         //steps
         $step_obj = new \stdClass();
         $step_obj->name = 'form';

         //rows
         $row_obj1 = new \stdClass();
         $row_obj1->config = "";


         //field
         $field_obj1 = new \stdClass();
         $field_obj1->widgetType = 'ScaleOfCompensation';
         $field_obj1->sort = 1;
         //validation
         $validation_obj1 = new \stdClass();
         // $validation_obj1->required = true;
         // $validation_obj1->maxlength = '250';

         $relation_obj1 = new \stdClass();
         $relation_obj1->relatedTo = false;

         $style_obj1 = new \stdClass();
         $style_obj1->col_width='4';

         $config_obj1 = new \stdClass();
         $config_obj1->label = "Scale Of Compensation /Limit Of Indemnity";
         $config_obj1->placeHolder = "Scale Of Compensation /Limit Of Indemnity";
         $config_obj1->fieldName = 'scaleOfCompensation';
         $config_obj1->id = 'scaleOfCompensation';
         $config_obj1->eQuotationVisibility = true;
         $config_obj1->validation = $validation_obj1;
         $config_obj1->relation = $relation_obj1;
         $config_obj1->style = $style_obj1;
         $field_obj1->config = $config_obj1;
         $fields = [$field_obj1];

         $validation_obj = new \stdClass();
         $validation_obj->field = "scaleOfCompensation";
         $rule = new \stdClass();
         $rule->required = true;
         //$rule->maxlength = 50;
         $validation_obj->validation = $rule;

         $msg = new \stdClass();
         $msg->required = 'Select scale of compensation';
         //$msg->maxlength = 'Maximum length exceeded';
         $validation_obj->messages = $msg;

        $row_obj1->fields = $fields;

        $row_obj2 = new \stdClass();    //2nd row
        $row_obj2->config = "";
        $row_obj2->fields = '';
        $row_obj3 = new \stdClass();    //3rd row
        $row_obj3->config = "";
        $row_obj3->fields = '';
        $row_obj4 = new \stdClass();    //2nd row
        $row_obj4->config = "";
        $row_obj4->fields = '';
        $row_obj5 = new \stdClass();    //3rd row
        $row_obj5->config = "";
        $row_obj5->fields = '';
        $row_obj6 = new \stdClass();    //2nd row
        $row_obj6->config = "";
        $row_obj6->fields = '';
        $row_obj7 = new \stdClass();    //3rd row
        $row_obj7->config = "";
        $row_obj7->fields = '';
        $row_obj8 = new \stdClass();    //2nd row
        $row_obj8->config = "";
        $row_obj8->fields = '';
        $row_obj9 = new \stdClass();    //3rd row
        $row_obj9->config = "";
        $row_obj9->fields = '';
        $row_obj10 = new \stdClass();    //2nd row
        $row_obj10->config = "";
        $row_obj10->fields = '';
        $row_obj11 = new \stdClass();    //3rd row
        $row_obj11->config = "";
        $row_obj11->fields = '';
        $row_obj12 = new \stdClass();    //2nd row
        $row_obj12->config = "";
        $row_obj12->fields = '';
        $row_obj13 = new \stdClass();    //3rd row
        $row_obj13->config = "";
        $row_obj13->fields = '';
        $row_obj14 = new \stdClass();    //2nd row
        $row_obj14->config = "";
        $row_obj14->fields = '';
        $row_obj15 = new \stdClass();    //3rd row
        $row_obj15->config = "";
        $row_obj15->fields = '';
        $row_obj16 = new \stdClass();    //3rd row
        $row_obj16->config = "";
        $row_obj16->fields = '';
        $row_obj17 = new \stdClass();    //2nd row
        $row_obj17->config = "";
        $row_obj17->fields = '';
        $row_obj18 = new \stdClass();    //3rd row
        $row_obj18->config = "";
        $row_obj18->fields = '';

        $step_obj->rows = [$row_obj1,$row_obj2,$row_obj3,$row_obj4,$row_obj5,$row_obj6,$row_obj7,$row_obj8,$row_obj8,$row_obj9,$row_obj10,$row_obj11,$row_obj12,$row_obj13,$row_obj14,$row_obj15,$row_obj16,$row_obj17,$row_obj18];
        $step_obj->validations = [$validation_obj];

        $stageEslip = new \stdClass();
        $stageEslip->forms = $step_obj;
        $stage_obj->steps = $stageEslip;

        $formData = WorkTypeForms::where('_id', new ObjectId('5dcbd89b5b482a0b25221d0b'))->first();
        $stageData = $formData->stages;
        $stageData['eSlip'] = $stage_obj;

        $result = WorkTypeForms::where('_id', new ObjectId('5dcbd89b5b482a0b25221d0b'))->update(['stages'=> $stageData]);
        return $result;
    }
    public function getReviewSlip()
    {
        $formData = IibWidgets::where('_id', new ObjectId('5dca4f88fad03b16bebdb695'))->first();
        $stageData = $formData->stages;
        $review = $stageData['eslip']['steps']['review'];


        $formData1 = WorkTypeForms::where('_id', new ObjectId('5dcc07965b482a0b25221d0f'))->first();
        $stageData1 = $formData1->stages;
        $steps = $stageData1['eSlip']['steps'];
        $steps['review'] = $review;

        $result = WorkTypeForms::where('_id', new ObjectId('5dcc07965b482a0b25221d0f'))->update(['stages.eSlip.steps'=> $steps]);
        return $result;
    }
    /**
     * Buissness Insured
     * to add new worktype buissness entry use url create-business-insured/{worktypeId}
     * if we want to add new option to each worktype add create-business-insured/1/{string?}
     */
    public function createBusinessInsured($worktypeId, $string = null)
    {
        $buis = BusinessInsuredOptions::all();
        $buis_gropBy = BusinessInsuredOptions::groupBy('worktypeId')->get();
        $worktypeId_arr = [];
        foreach ($buis_gropBy as $grop) {
            $worktypeId_arr[] = $grop['worktypeId'];
        }
        if ($worktypeId != 1) {
            $businessInsured = BusinessInsuredOptions::where('worktypeId', new ObjectID('5b34b18d3c63021e3c9698dc'))->orderBy('businessNumber', 'ASC')->get(); //worksman compensation
            if (! in_array($worktypeId, $worktypeId_arr)) {
                foreach ($businessInsured as $buisness) {
                    $businessInsured_obj = new BusinessInsuredOptions();
                    $businessInsured_obj->_id = new ObjectID();
                    $businessInsured_obj->worktypeId =  new ObjectID($worktypeId);
                    $businessInsured_obj->businessNumber = $buisness['businessNumber'];
                    $businessInsured_obj->businessName = $buisness['businessName'];
                    $businessInsured_obj->save();
                }
                return 'success';
            } else {
                return 'Already added';
            }
        } else {
            if ($string) {
                foreach ($worktypeId_arr as $key => $value) {
                    $bi = BusinessInsuredOptions::where('worktypeId', $value)->max('businessNumber');
                    $businessInsured_obj = new BusinessInsuredOptions();
                    $businessInsured_obj->_id = new ObjectID();
                    $businessInsured_obj->worktypeId =  new ObjectID($value);
                    $businessInsured_obj->businessNumber = ++$bi;
                    $businessInsured_obj->businessName = htmlspecialchars($string);
                    $businessInsured_obj->save();
                }
                return 'success';
            } else {
                return 'failed';
            }
        }
    }

}
