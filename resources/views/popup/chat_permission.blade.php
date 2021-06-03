
@if(@$users)
    @foreach($users as $user)
        @if($user->_id != $creator)
            <div class="col-12 custom-control custom-checkbox mb-3 ">
                <input type="checkbox" class="custom-control-input"  name="users[]" value="{{$user->_id}}"  @if((in_array($user->_id, $permittedUsers))) checked @endif  id="{{$user->_id}}"  style="display: none" onchange="val()">
                <label class="custom-control-label" for="{{$user->_id}}">{{$user->name}} ({{$user->role_name}})</label>
            </div>
            @endif
    @endforeach
@endif