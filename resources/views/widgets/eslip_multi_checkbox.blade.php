


@if (!empty($answer))
    <div class="row">
        <div class="col-6">
            <label><b class="titles">{{@$config['label']}} </b></label>
        </div>
        <div style="padding: 0px;" class="col-6">
            <span class="colon colon-padding" style="vertical-align: top;">: </span>
            <label class="titles"> {{implode(', ', $answer)}} </label>
        </div>
    </div>
@endif


