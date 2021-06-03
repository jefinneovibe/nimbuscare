<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class EslipMultiCheckbox extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $formValues = $this->config['formValues'];
        $data =  $this->config['data'];
        $answer = [];
        if (!empty($data['checkBoxVales'])) {
            foreach ($data['checkBoxVales'] as $key => $field) {
                if (isset($field['isBusinessRelated']) && $field['isBusinessRelated']) {
                    if (count($field['relatedBusiness']) > 0) {
                        if (in_array(@$formValues['eQuestionnaire']['businessDetails']['businessType']['optionId'], $field['relatedBusiness'])) {
                            $answer_str =    @$field['value'];
                            if (isset($field['isDetails']) && $field['isDetails']) {
                                @eval("\$str123_det = \"{$$field['details']}\";");
                                if ($str123_det != '') {
                                    $answer_str .= "-".$str123_det;
                                }
                            }
                            $answer[] =    @$answer_str;
                        }
                    }
                } else if (isset($field['isWidgetRelated']) && $field['isWidgetRelated'] === true) {
                    @eval("\$str123_field = \"{$field['checkValue']}\";");
                    if (in_array(strtolower(@$str123_field), $field['matchValue'])) {
                        $answer_str =    @$field['value'];
                        if (isset($field['isDetails']) && $field['isDetails']) {
                            @eval("\$str123_det = \"{$field['details']}\";");
                            if ($str123_det != '') {
                                $answer_str .= "-".$str123_det;
                            }
                        }
                        $answer[] =    @$answer_str;
                    }
                } else {
                    $answer_str =    @$field['value'];
                    if (isset($field['isDetails']) && $field['isDetails']) {
                        @eval("\$str123_det = \"{$$field['details']}\";");
                        if ($str123_det != '') {
                            $answer_str .= "-".$str123_det;
                        }
                    }
                    $answer[] =    @$answer_str;
                }
            }
        }
        return view(
            'widgets.eslip_multi_checkbox', [
            'config' => $data,
            'answer' => $answer,
            'formValues' => $formValues
            ]
        );
    }
}
