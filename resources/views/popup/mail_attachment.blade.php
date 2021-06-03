<!------------------------------------------------modal-------------------------------->
    <div class="modal fade" id="questionnaire_popup" tabindex="-1" role="dialog" aria-labelledby="questionnaire_popup" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-lg" role="document">
            <div class="modal-content  ">
                <div class="modal-body">
                    <form id="quest_send_form" name="quest_send_form">
                       <div class="row">
                            <div class="col-12">
                                <label class="titles"><b>Enter Any comments</b></label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Comments"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <label class="titles"><b>Please select the files that need to be send</b></label>
                            </div>
                        </div>
                        <div class=" container row checkboxred">
                            <div class="col-12 custom-control custom-checkbox mb-3 ">
                                <input class="custom-control-input" id="customCheck1" type="checkbox"checked>
                                <label class="custom-control-label" for="customCheck1">Tax Registration Document</label>
                            </div>
                            <div class="col-12 custom-control custom-checkbox mb-3">
                                <input class="custom-control-input" id="customCheck2" type="checkbox">
                                <label class="custom-control-label" for="customCheck2">Trade Liscence Document</label>
                            </div>
                            <div class="col-12 custom-control custom-checkbox mb-3">
                                <input class="custom-control-input" id="customCheck3" type="checkbox">
                                <label class="custom-control-label" for="customCheck3">List of Employees</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="commonbutton modal-footer">
                    <button type="button" class="btn btn-link  ml-auto closebutton" data-dismiss="modal">CANCEL</button>
                    <button type="button" class="btn btn-primary btnload" data-dismiss="modal" data-toggle="modal" data-target="#modal-default-alert"  id="send_btn" onclick="sendQuestion()"><a href="#">OK</a></button>
                </div>
            </div>
        </div>
    </div>  
<!------modal end-->