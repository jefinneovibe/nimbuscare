
  @foreach($data['rows'] as $row)
        @foreach ($row['fields'] as $fields)
            <div class="col-12">
               <label  class="titles" style="width: 75%;"> {{@$fields['config']['label']}}</label>
               @if (isset($fields['config']['isArray']) && $fields['config']['isArray'] && isset($values[$fields['config']['fieldName']][$fields['config']['arrayKey']]))
           <span class="text">    : {{$values[$fields['config']['fieldName']][$fields['config']['arrayKey']]}}</span>
               @else
               <span class="text"> : {{@$values[$fields['config']['fieldName']]}}</span>
               @endif
            </div>
        @endforeach
    @endforeach
