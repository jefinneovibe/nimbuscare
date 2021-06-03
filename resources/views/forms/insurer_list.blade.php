@if($insurer_list)
    @foreach($insurer_list as $insurer)
    <div class="custom_checkbox">
        <input type="checkbox" name="insurance_companies[]" value="{{$insurer->_id}}"  @if(!empty($company_id) &&(in_array($insurer->_id, $company_id))) checked @endif  id="{{$insurer->_id}}" class="inp-cbx" style="display: none">
        <label for="{{$insurer->_id}}" class="cbx">
                                        <span>
                                            <svg width="10px" height="8px" viewBox="0 0 12 10">
                                              <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                            </svg>
                                        </span>
            <span>{{$insurer->name}}</span>
        </label>
    </div>
    @endforeach
@else
    No insurer Found.
@endif