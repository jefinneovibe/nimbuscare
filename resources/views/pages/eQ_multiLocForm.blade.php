@extends('layouts.popup_form_layout')


@section('content')
    <?php
        $step = $CFArrayKey;
        $findFieldTotal =[];
        foreach ($data['rows'] as $row) {
            foreach ($row['fields'] as $fields => $fieldsValue) {
                if (isset($fieldsValue['config']['findFieldTotal']) && $fieldsValue['config']['findFieldTotal']) {
                    $findFieldTotal[] = $fieldsValue['config']['fieldName'];
                }
            }
        }
    ?>
    @widget("BasicDetails",['data' => @$data, 'step' => @$step,'findFieldTotal'=> @$findFieldTotal, 'workTypeId' => @$workTypeId, 'stage' =>@$stage, 'values' => @$values, 'workTypeDataId'=>@$workTypeDataId,  'cancelButton'=>1, 'CFValueKey'=>@$CFValueKey, 'CFArrayKey'=>@$CFArrayKey])
@endsection

