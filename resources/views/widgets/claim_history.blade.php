
        <div class="col-2">
            <div class="form-group">
                <label><b class="titles">{{$config['label']}}<span> *</span></b></label>
            </div>
        </div>
    <div class="col-10 form-group">
        <table class="claimhistory">
            <thead>
            <th style="width:100px;"><b class="titles">Year</b></th>
            <th style="width: 120px;"><b class="titles">Type</b></th>
            <th style="width: 168px;"><b class="titles">Minor Injury Claim Amount</b></th>
            <th style="width: 168px;"><b class="titles">Death Claim Amount</b></th>
            <th><b class="titles">Cost & Description</b></th>
            </thead>

            @if(!empty($value))
                <tbody >
                    @foreach($value as $key => $rowVal)
                    <?php
                        if ($rowVal['type']=='Admin') {
                            $trClass="admin_class";
                            $elemClass="adminElemClass";
                        } else{
                            $trClass="nonadmin_class";
                            $elemClass="nonadminElemClass";
                        }
                        $class = '';
                    ?>
                    <tr class="{{$trClass}}">
                        <td>
                            {{str_replace('year', '', $rowVal['year'])}} &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[{{$key}}][year]" value="{{$rowVal['year']}}" >
                            @if($loop->iteration == 1 ||  $loop->iteration == 2)
                                <?php $class = 'requiredClaim'; ?>
                                <i data-toggle="tooltip" data-placement="top" title="Most Recent" data-container="body" class="fa fa-info red"></i>
                            @endif
                        </td>
                        <td>
                            {{$rowVal['type']}}
                            <input type="hidden" name="{{$config['fieldName']}}[{{$key}}][type]" value="{{$rowVal['type']}}"> </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[{{$key}}][minor_injury_claim_amount]" value="{{$rowVal['minor_injury_claim_amount']}}"  class="form-control aed  claimHis_amount {{@$class}} {{@$elemClass}}"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[{{$key}}][death_claim_amount]" value="{{$rowVal['death_claim_amount']}}"  class="form-control aed  claimHis_amount {{@$class}} {{@$elemClass}}"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{@$config['fieldName']}}[{{$key}}][cost_&_Description]" value="{{@$rowVal['cost_&_Description']}}" class="form-control {{@$class}} {{@$elemClass}}"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @else
                <tbody>
                    <tr class="admin_class">
                        <td>
                            1 &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[0][year]" value="year 1" >
                            <i data-toggle="tooltip" data-placement="top" title="Most Recent" data-container="body" class="fa fa-info red"></i>
                        </td>
                        <td>
                            Admin
                            <input type="hidden" name="{{$config['fieldName']}}[0][type]" value="Admin">
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[0][minor_injury_claim_amount]"  class="form-control aed requiredClaim claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div  style="width:90%;"class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[0][death_claim_amount]"  class="form-control aed requiredClaim claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{$config['fieldName']}}[0][cost_&_Description]" class="form-control requiredClaim"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                    <tr class="nonadmin_class">
                        <td>
                            1 &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[1][year]" value="year 1" >
                            <i data-toggle="tooltip" data-placement="top" title="Most Recent" data-container="body" class="fa fa-info red"></i>
                        </td>
                        <td>
                            Non Admin
                            <input type="hidden" name="{{$config['fieldName']}}[1][type]" value="Non Admin">
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[1][minor_injury_claim_amount]"  class="form-control aed requiredClaim claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[1][death_claim_amount]"  class="form-control aed requiredClaim claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{$config['fieldName']}}[1][cost_&_Description]" class="form-control requiredClaim"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                    <tr class="admin_class">
                        <td>
                            2 &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[2][year]" value="year 2" >
                        </td>
                        <td>
                            Admin
                            <input type="hidden" name="{{$config['fieldName']}}[2][type]" value="Admin">
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[2][minor_injury_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[2][death_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{$config['fieldName']}}[2][cost_&_Description]" class="form-control"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                    <tr class="nonadmin_class">
                        <td>
                            2 &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[3][year]" value="year 2" >
                        </td>
                        <td>
                            Non Admin
                            <input type="hidden" name="{{$config['fieldName']}}[3][type]" value="Non Admin">
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[3][minor_injury_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[3][death_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{$config['fieldName']}}[3][cost_&_Description]" class="form-control"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                    <tr class="admin_class">
                        <td>
                            3 &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[4][year]" value="year 3" >
                        </td>
                        <td>
                            Admin
                            <input type="hidden" name="{{$config['fieldName']}}[4][type]" value="Admin">
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[4][minor_injury_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[4][death_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{$config['fieldName']}}[4][cost_&_Description]" class="form-control"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                    <tr class="nonadmin_class">
                        <td>
                            3 &nbsp
                            <input type="hidden" name="{{$config['fieldName']}}[5][year]" value="year 3" >
                        </td>
                        <td>
                            Non Admin
                            <input type="hidden" name="{{$config['fieldName']}}[5][type]" value="Non Admin">
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[5][minor_injury_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <div style="width:90%;" class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">AED</span>
                                </div>
                                <input type="text" name="{{$config['fieldName']}}[5][death_claim_amount]"  class="form-control aed claimHis_amount"  placeholder="Enter amount">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="{{$config['fieldName']}}[5][cost_&_Description]" class="form-control"  placeholder="Enter cost & description">
                        </td>
                    </tr>
                </tbody>
            @endif
        </table>
    </div>
<style>
.ui-widget-content[role=tooltip]{
    max-width: 150px;
    text-align: center;
    padding: 2px 8px;
}
</style>
@push('widgetScripts')
    <script>
        $(window).load(function(){
            adminNonAdmin();
            $(".claimHis_amount").each(function() {
                $(this).rules("add", {
                    amount : true
                });
                $(this).rules("add", {
                    messages: {
                        amount : 'Enter digits only'
                    }
                });
            });
            $(".requiredClaim").each(function() {
                $(this).rules("add", {
                    required : true
                });
                $(this).rules("add", {
                    messages: {
                        required : 'Please enter this field.'
                    }
                });
            });
        });
        $(document).load(function(){
            adminNonAdmin();
        });
        function adminNonAdmin() {
            var empDetail=$('input[type=radio][name=employeeDetails\\[adminStatus\\]]:checked').val();
            if (empDetail == 'admin') {
                $('.nonadmin_class').hide();
                $('.nonadmin_class input').not(":hidden").each(function(){
                    $(this).val('');
                    $(this).rules("remove", 'required');
                });
                $('.admin_class').show();
            }
            else if (empDetail == 'nonadmin') {
                $('.admin_class').hide();
                $('.admin_class input').not(":hidden").each(function(){
                    $(this).val('');
                    $(this).rules("remove", 'required');
                });
                $('.nonadmin').show();
            }
            else if (empDetail == 'both') {
                $('.admin_class').show();
                $('.nonadmin_class').show();
                $(".requiredClaim").each(function() {
                    $(this).rules("add", {
                        required : true
                    });
                    $(this).rules("add", {
                        messages: {
                            required : 'Please enter this field.'
                        }
                    });
                });
            }
        }
        $('input[type=radio][name=employeeDetails\\[adminStatus\\]]').change(function() {
            if (this.value == 'admin') {
                $('.nonadmin_class').hide();
                $('.nonadmin_class input').not(":hidden").each(function(){
                    $(this).val('');
                    $(this).rules("remove", 'required');
                });
                $('.admin_class').show();

            }
            else if (this.value == 'nonadmin') {
                $('.admin_class').hide();
                $('.admin_class input').not(":hidden").each(function(){
                    $(this).val('');
                    $(this).rules("remove", 'required');
                });
                $('.nonadmin_class').show();
            }
            else if (this.value == 'both') {
                $('.admin_class').show();
                $('.nonadmin_class').show();
                $(".requiredClaim").each(function() {
                    $(this).rules("add", {
                        required : true
                    });
                    $(this).rules("add", {
                        messages: {
                            required : 'Please enter this field.'
                        }
                    });
                });
            }
        });
    </script>
@endpush
