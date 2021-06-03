{{--Popup for email send--}}
<div id = "questionnaire_popup">
    <form id="quest_send_form" name="quest_send_form">
        <div class="cd-popup">
            <div class="cd-popup-container">
                <div class="modal_content">
                        <h1>Add comments and files</h1>

                    <div class="clearfix"></div>
                    <div class="content_spacing">
                        <div class="row" style="margin-bottom: 14px;">
                            <div class="col-md-12">
                                    <label class="form_label bold">Enter your comment<span style="visibility:hidden">*</span></label>
                                <textarea class="form_input" style="border: 1px solid #D4D9E2;padding: 10px 12px !important;" id="txt_comment" name="txt_comment" placeholder="Comment..."></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <label class="form_label bold" style="margin-bottm: 5px;">Select the files to be attached <span style="visibility:hidden">*</span></label>
                                <div id="attach_div">
                                    <i class="fa fa-spinner fa-spin fa-3x fa-fw col-md-12 col-md-2 col-md-push-6" style="padding: 25px;"></i><span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_action btn_cancel">Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="send_btn" onclick="sendQuestion()">OK</button>
                </div>
            </div>
        </div>
    </form>
</div>



{{--Popup for show messages--}}
<div id="success_popup">
    <div class="cd-popup">
        <div class="cd-popup-container">
            <div class="modal_content">
                <div class="clearfix"></div>
                <div class="content_spacing">
                    <div class="row">
                        <div class="col-md-12">
                            <br><br><h1 id="success_message">{{session('message')}}</h1></p>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_footer">
                <button class="btn btn-primary btn_action btn_cancel">OK</button>
            </div>
        </div>
    </div>
</div>
