<!-- Popup -->
<div id="filter_popup">
    <div class="cd-popup">
        <form id="filterForm" name="filterForm" action="receptionist-list" method="get">
            <div class="cd-popup-container">
                <div class="modal_content">
                    <div class="clearfix">
                        <h1>Filter</h1>
                        <button class="btn btn_reset blue_btn" id="btn-clear" type="button">Clear All</button>
                    </div>


                    <div class="content_spacing clearfix">
                        <div class="md--half" style="display: none">
                            <div class="custom_checkbox">
                                <input type="checkbox" name="dispatchTypes" value="" id="dispatchTypes" class="inp-cbx" style="display: none" onchange="listCategory()" checked>
                                <label for="dispatchTypes" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>Dispatch Type</span>
                                </label>
                            </div>
                            <div class="custom_checkbox">
                                <input type="checkbox" name="caseManager" value="" id="caseManager" class="inp-cbx" style="display: none" onchange="caseManagerList()" checked>
                                <label for="caseManager" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>Case Manager</span>
                                </label>
                            </div>
                            <div class="custom_checkbox">
                                <input type="checkbox" name="dispatchModes" value="" id="dispatchModes" class="inp-cbx" style="display: none" onchange="dispatchModeList()" checked>
                                <label for="dispatchModes" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>Delivery Mode</span>
                                </label>
                            </div>
                            <div class="custom_checkbox">
                                <input type="checkbox" name="agent" value="" id="agent" class="inp-cbx" style="display: none" onchange="agentList()" checked>
                                <label for="agent" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                    <span>Agent</span>
                                </label>
                            </div>
                        </div>
                        <div class="md--half" style="display: none" id="dispatchTypeList">
                            <h5>Dispatch Type</h5>
                            <div class="pre-scrollable">
                                <div class="custom_checkbox">
                                    <input type="checkbox" name="dispatchTypeAll" value="disp_all" id="disp_all" class="inp-cbx" style="display: none">
                                    <label for="disp_all" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($dispatch_types))
                                    @forelse($dispatch_types as $dispatch)
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="dispathTypeCheck[]" value="{{$dispatch->_id}}" id="{{$dispatch->_id}}" class="inp-cbx" style="display: none">
                                            <label for="{{$dispatch->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$dispatch->type}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Type Found.
                                    @endforelse
                                @endif
                            </div>
                        </div>

                        <div class="md--half">
                            <h5>Customer Name</h5>
                            <div class="pre-scrollable">
                                <div class="custom_checkbox">
                                    <input type="checkbox" name="customerAll" value="cust_all" id="cust_all" class="inp-cbx" style="display: none">
                                    <label for="cust_all" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($customers))
                                    @forelse($customers as $customer)
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="customer[]" value="{{$customer->_id}}" id="c_{{$customer->_id}}" class="inp-cbx" style="display: none">
                                            <label for="c_{{$customer->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$customer->fullName}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Customers Found.
                                    @endforelse
                                @endif
                            </div>
                        </div>

                        <div class="md--half" style="display: none" id="caseManagerList">
                            <h5>Case Managers</h5>
                            <div class="pre-scrollable">
                                <div class="custom_checkbox">
                                    <input type="checkbox" name="caseManagerAll" value="case_all" id="case_all" class="inp-cbx" style="display: none">
                                    <label for="case_all" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($case_managers))
                                    @forelse($case_managers as $caseManager)
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="caseManager[]" value="{{$caseManager->_id}}" id="{{$caseManager->_id}}" class="inp-cbx" style="display: none">
                                            <label for="{{$caseManager->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$caseManager->name}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Case Manager Found.
                                    @endforelse
                                @endif
                            </div>
                        </div>
                        <div class="md--half" style="display: none" id="dispatchModeList">
                            <h5>Delivery Mode</h5>
                            <div class="pre-scrollable">
                                <div class="custom_checkbox">
                                    <input type="checkbox" name="dispatchModeAll" value="dispatch_mode_all" id="dispatch_mode_all" class="inp-cbx" style="display: none">
                                    <label for="dispatch_mode_all" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($delivery_mode))
                                    @forelse($delivery_mode as $deliverymode)
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="deliveryModeFil[]" value="{{$deliverymode->_id}}" id="{{$deliverymode->_id}}" class="inp-cbx" style="display: none">
                                            <label for="{{$deliverymode->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$deliverymode->deliveryMode}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Status Found.
                                    @endforelse
                                @endif
                            </div>
                        </div>
                        <div class="md--half" style="display: none" id="agentList">
                            <h5>Agents</h5>
                            <div class="pre-scrollable">
                                <div class="custom_checkbox">
                                    <input type="checkbox" name="agentAll" value="agent_all" id="agent_all" class="inp-cbx" style="display: none">
                                    <label for="agent_all" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                        <span>All</span>
                                    </label>
                                </div>
                                @if(!empty($agents))
                                    @forelse($agents as $agent)
                                        <div class="custom_checkbox">
                                            <input type="checkbox" name="agent[]" value="{{$agent->_id}}" id="{{$agent->_id}}" class="inp-cbx" style="display: none">
                                            <label for="{{$agent->_id}}" class="cbx">
                                    <span>
                                        <svg width="10px" height="8px" viewBox="0 0 12 10">
                                          <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                        </svg>
                                    </span>
                                                <span>{{$agent->name}}</span>
                                            </label>
                                        </div>
                                    @empty
                                        No Case Manager Found.
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal_footer">
                    <button class="btn btn-primary btn-link btn_cancel" id="btn-cancel" type="button">Cancel</button>
                    <button class="btn btn-primary btn_action" type="button" id="btn-filterForm">Apply Filter</button>
                </div>
            </div>
        </form>
    </div>
</div><!--//END Popup -->