@if(!empty(@$formValues['eQuestionnaire']['policyDetails']['claimsHistory']))
<div class="row">
  <div class="form-group">
  <label><b class="titles">{{@$config['label']}}</b></label>
  </div>
  <div class="col-12 form-group">
    <table class="claimhistorydata">
      <thead>
        <th style="width: 10%;"><label class="titles">Year</label></th>
       @if (@$config['type_col'])
        <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">Type</label></th>
       @endif
       @foreach (@$config['columns'] as $item)
          <th style="width:{{@$item['columnWidth']?:'40px'}}"><label class="titles">{{$item['label']}}</label></th>
       @endforeach
      </thead>
      <tbody>
        @foreach($formValues['eQuestionnaire']['policyDetails']['claimsHistory'] as $claimHistory)
          <tr>
            <td>{{str_replace('year', '', @$claimHistory['year'])}} &nbsp
              @if($loop->iteration == 1)
                (Most Recent)
              @endif
            </td>
            @if (@$config['type_col'])
            <td>{{@$claimHistory['type']?:'--'}}</td>
            @endif
           @foreach ($config['columns'] as $item1)
                <td><p>{{@$claimHistory[$item1['fieldName']]?:@$claimHistory[$item1['fieldname']]?:'--'}}</p></td>
           @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
