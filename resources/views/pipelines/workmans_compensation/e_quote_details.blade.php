
@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="section_details">
        <div class="card_header clearfix">
            <h3 class="title" style="margin-bottom: 8px;">E-Quote Details</h3>
        </div>
        <div class="card_content">
            <div class="edit_sec clearfix">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label">Insured <span>*</span></label>
                            <div class="enter_data">
                                <p>Tata Group</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label">Cover <span>*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                        <span class="note">
                                           <label>
                                               <b>Workmen’s Compensation</b><br>
                                                Benefits to employees in accordance with UAE Federal Labor Law No 8 (Chapter 8 of 1980)
                                                and amendments thereto in respect of work related accidents arising out of or in the course of their employment.
                                           </label>
                                        </span>
                                </div>
                                <div class="col-md-6">
                                        <span class="note">
                                           <label>
                                               <b>Employer’s Liability </b><br>
                                                Liability at law as per UAE Shariah and/or Common Law in respect of work related accidents
                                           </label>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Law <span>*</span></label>
                            <div class="enter_data">
                                <p>UAE Federal Labour Law No. 8 Of 1980 and subsequent amendments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label">Business Activity <span>*</span></label>
                            <div class="enter_data">
                                <p>Architectural services/ Engineers</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Estimated Annual Wages <span>*</span></label>
                            <div class="enter_data border_none">
                                <table class="fill_data">
                                    <tr>
                                        <td valign="top" class="name">Admin : <span>100000</span></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="name">Non-Admin : <span>320000</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Number of employees <span>*</span></label>
                            <div class="enter_data border_none">
                                <table class="fill_data">
                                    <tr>
                                        <td valign="top" class="name">Admin : <span>20000</span></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="name">Non-Admin : 20000</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Geographical Area <span>*</span></label>
                            <div class="enter_data border_none">
                                <p>USA</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <label class="form_label bold">Policy period <span>*</span></label>
                            <div class="enter_data border_none">
                                <table class="fill_data">
                                    <tr>
                                        <td valign="top" class="name">From : <span>20/05/2018</span></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="name">To : <span>20/05/2019</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label bold">Scale of Compensation /Limit of Indemnity   <span>*</span></label>
                            <div class="cntr">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="opt1" class="radio">
                                            <input type="radio" name="scale" id="opt1" class="hidden"/>
                                            <span class="label"></span>As per UAE Labour Law
                                        </label>

                                        <label for="opt2" class="radio">
                                            <input type="radio" name="scale" id="opt2" class="hidden"/>
                                            <span class="label"></span>
                                            <span>Death/Permanent Total Disability (PTD) Benefit increased to AED 50,000/- for those monthly
                                                salary is not more than AED 2,000/- and AE 75,000/- for those whose monthly salary is AED 2,000/- or more</span>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom_select">
                                            <select class="form_input">
                                                <option>Agree</option>
                                                <option>Not Agree</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Employer’s extended liability under Common Law/Shariah Law <span>*</span></label>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input" id="option_select1">
                                    <option>Select</option>
                                    <option>1M</option>
                                    <option>2M</option>
                                    <option>3M</option>
                                    <option>4M</option>
                                    <option selected>5M</option>
                                    <option>7.5M</option>
                                    <option>10M</option>
                                    <option>25M</option>
                                    <option value="option_other1">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="option_other1" style="display: none">
                        <div class="form_group">
                            <input class="form_input" name="name" type="text" placeholder="Please specify">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Medical Expense (In AED) <span>*</span></label>
                    </div>

                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input" id="option_select2">
                                    <option>Select</option>
                                    <option>10000</option>
                                    <option selected>15000</option>
                                    <option>20000</option>
                                    <option>20000</option>
                                    <option>25000</option>
                                    <option>30000</option>
                                    <option>35000</option>
                                    <option>40000</option>
                                    <option>50000</option>
                                    <option value="option_other2">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="option_other2" style="display: none">
                        <div class="form_group">
                            <input class="form_input" name="name" type="text" placeholder="Please specify">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Repatriation Expenses (Repatriation of mortal remains or injured employee to his/her home country on medical advice) including  expenses of an accompanying person <span>*</span></label>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input" id="option_select3">
                                    <option>Select</option>
                                    <option>10000</option>
                                    <option>15000</option>
                                    <option selected>20000</option>
                                    <option>20000</option>
                                    <option>25000</option>
                                    <option>30000</option>
                                    <option>35000</option>
                                    <option>40000</option>
                                    <option>50000</option>
                                    <option value="option_other3">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="option_other3" style="display: none">
                        <div class="form_group">
                            <input class="form_input" name="name" type="text" placeholder="Please specify">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">cover for hired workers or casual labours? <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="enter_data border_none">
                                <table class="fill_data">
                                    <tr>
                                        <td class="name" valign="top">No of labourers : <span>200000</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name" valign="top">Estimated Annual wages (AED) : <span>100000</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comments..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Cover for offshore employees? <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="enter_data border_none">
                                <table class="fill_data">
                                    <tr>
                                        <td class="name" valign="top">No of labourers : <span>45000</span></td>
                                    </tr>
                                    <tr>
                                        <td class="name" valign="top">Estimated Annual wages (AED) : <span>30000</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comments..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Cover for hernia, heat/sun stroke, muscle spasm, muscle strain, lumbago related to work <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option selected>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comment..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">24 hours non-occupational personal accident cover – in UAE and home country benefits as per UAE Labour Law <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option selected>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comment..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Waiver of subrogation <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Yes</option>
                                    <option selected>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comments..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx8" class="inp-cbx" style="display: none">
                                    <label for="cbx8" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Automatic addition & deletion Clause</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input" id="option_select3">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comment..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx2" class="inp-cbx" style="display: none">
                                    <label for="cbx2" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Loss Notification – ‘as soon as reasonably practicable’</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comments..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx" class="inp-cbx" style="display: none">
                                    <label for="cbx" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Brokers Claim Handling Clause : A loss notification received by the Insurance Broker will be deemed
                                    as a loss notification to Insurer. All communications flowing between the Insurer, Insured and the
                                    appointed Loss Surveyor should be channelized through the Broker, unless there is any unavoidable
                                    reasons compelling direct communications between the parties
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <textarea class="form_input sm_textarea" placeholder="Comments..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx7" class="inp-cbx" style="display: none">
                                    <label for="cbx7" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Cover for insured’s employees on employment visas whilst on incoming and outgoing flights to/from  UAE
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Cover for Casual labourer <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="enter_data">
                                <p>Test</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Emergency evacuation <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option selected>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Including Legal and Defence cost <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option selected>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Employee to employee liability <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form_label bold">Cross Liability <span>*</span></label>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Yes</option>
                                    <option selected>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx6" class="inp-cbx" style="display: none">
                                    <label for="cbx6" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Cover for occupational/ industrial disease as per Labour Law</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx5" class="inp-cbx" style="display: none">
                                    <label for="cbx5" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Cancellation clause-30 days by either side on  pro-rata
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx4" class="inp-cbx" style="display: none">
                                    <label for="cbx4" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Indemnity to principal  </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx3" class="inp-cbx" style="display: none">
                                    <label for="cbx3" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Including work related accidents and bodily injuries during overtime work, night
                                    shifts, work on public holidays and week-ends.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx2" class="inp-cbx" style="display: none">
                                    <label for="cbx2" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Primary insurance clause</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx2" class="inp-cbx" style="display: none">
                                    <label for="cbx2" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">Travelling to and from workplace</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx" class="inp-cbx" style="display: none">
                                    <label for="cbx" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Riot, Strikes, civil commotion and Passive war risk
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="flex_sec">
                                <div class="custom_checkbox">
                                    <input type="checkbox" checked name="work_type" value="1" id="cbx" class="inp-cbx" style="display: none">
                                    <label for="cbx" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    </label>
                                </div>
                                <label class="form_label bold">
                                    Errors and Ommissions
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <div class="custom_select">
                                <select class="form_input">
                                    <option>Select</option>
                                    <option>Agree</option>
                                    <option>Not Agree</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <label class="form_label bold">Claims History <span>*</span></label>
                            <table class="table table-bordered custom_table">
                                <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Minor Injury Claim Amount</th>
                                    <th>Death Claim Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Year 1 <i data-toggle="tooltip" data-placement="bottom" title="Most Resent" data-container="body" class="material-icons info_icon">info</i></td>
                                    <td>Admin</td>
                                    <td><input class="form_input" name="name" type="text" value="Lorem ipsum dolor sit amet"></td>
                                    <td><input class="form_input" name="name" type="text" value="2000"></td>
                                    <td><input class="form_input" name="name" type="text" value="3500"></td>
                                </tr>
                                <tr>
                                    <td>Year 1 <i data-toggle="tooltip" data-placement="bottom" title="Most Resent" data-container="body" class="material-icons info_icon">info</i></td>
                                    <td>Non Admin</td>
                                    <td><input class="form_input" name="name" type="text" value="Lorem ipsum dolor sit amet"></td>
                                    <td><input class="form_input" name="name" type="text" value="2000"></td>
                                    <td><input class="form_input" name="name" type="text" value="3500"></td>
                                </tr>
                                <tr>
                                    <td>Year 2</td>
                                    <td>Admin</td>
                                    <td><input class="form_input" name="name" type="text" value="Lorem ipsum dolor sit amet"></td>
                                    <td><input class="form_input" name="name" type="text" value="2000"></td>
                                    <td><input class="form_input" name="name" type="text" value="3500"></td>
                                </tr>
                                <tr>
                                    <td>Year 2</td>
                                    <td>Non Admin</td>
                                    <td><input class="form_input" name="name" type="text" value="Lorem ipsum dolor sit amet"></td>
                                    <td><input class="form_input" name="name" type="text" value="2000"></td>
                                    <td><input class="form_input" name="name" type="text" value="3500"></td>
                                </tr>
                                <tr>
                                    <td>Year 3</td>
                                    <td>Admin</td>
                                    <td><input class="form_input" name="name" type="text" value="Lorem ipsum dolor sit amet"></td>
                                    <td><input class="form_input" name="name" type="text" value="2000"></td>
                                    <td><input class="form_input" name="name" type="text" value="3500"></td>
                                </tr>
                                <tr>
                                    <td>Year 3</td>
                                    <td>Non Admin</td>
                                    <td><input class="form_input" name="name" type="text" value="Lorem ipsum dolor sit amet"></td>
                                    <td><input class="form_input" name="name" type="text" value="2000"></td>
                                    <td><input class="form_input" name="name" type="text" value="3500"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Rate (Admin) <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Rate (Non-Admin) <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Combined Rate <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Brokerage <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Warranty <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Exclusion <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form_group">
                            <label class="form_label bold">Special Condition <span>*</span></label>
                            <input class="form_input" name="name" type="text">
                        </div>
                    </div>
                </div>

                <a href="{{ url('e-quote-list') }}" class="btn btn-primary btn_action pull-right">Submit</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<!-- Custom Select -->
<script src="{{URL::asset('js/main/custom-select.js')}}"></script>

<script>
    $(function() {
        $("#option_select1").change(function () {
            if ($(this).val() == "option_other1") {
                $("#option_other1").show();
            } else {
                $("#option_other1").hide();
            }
        });
        $("#option_select2").change(function () {
            if ($(this).val() == "option_other2") {
                $("#option_other2").show();
            } else {
                $("#option_other2").hide();
            }
        });
        $("#option_select3").change(function () {
            if ($(this).val() == "option_other3") {
                $("#option_other3").show();
            } else {
                $("#option_other3").hide();
            }
        });
    });
</script>


@endpush


