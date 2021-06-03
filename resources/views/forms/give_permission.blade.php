@if($users)
    @foreach($users as $user)
        @if($user->_id != $creator)
            <div class="custom-checkbox">
                <input type="checkbox" name="users[]" value="{{$user->_id}}"  @if((in_array($user->_id, $permittedUsers))) checked @endif  id="{{$user->_id}}" class="inp-cbx" style="display: none" onchange="val()">
                <label for="{{$user->_id}}" class="cbx">
                    <span>
                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg>
                    </span>

                    <span>{{$user->name}} ({{$user->role_name}})</span>
                </label>
            </div>
        @endif
    @endforeach
@endif