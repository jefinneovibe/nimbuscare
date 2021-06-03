<div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">Create Work Type</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">
                    <div class="add_segment">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group custom_dp">
                                    <label class="form_label">Work Type <span>*</span></label>
                                    <select class="selectpicker" data-hide-disabled="true" data-live-search="true" name="workType" id="workType" onchange="uploadShow(this);">
                                        <option selected value="" name="workType">Select Worktype</option>work_type
                                        @if(!empty(@$config['work_type']))
                                            @foreach(@$config['work_type'] as $type)
                                               <option {{ (old("workType") == $type->_id? "selected":"") }} value="{{$type->_id}}" data-display-text="">{{$type->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>