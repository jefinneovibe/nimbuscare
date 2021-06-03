<!-- Sidebar Nav -->
<div class="menu-wrap">
    <div class="sidebar_logo">
        <img src="{{URL::asset('img/main/interactive_logo.png')}}">
    </div>
    <nav class="menu">
        <div class="menu-list">
            {{-- @if(session('role') == 'Admin' ) --}}
            <a href="{{ url('dash') }}" {{ Request::is('dash') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Main Dashboard</span>
            </a>
            {{-- @endif --}}
            @if((session('assigned_permissions')) && (in_array('Dispatch',session('assigned_permissions'))))
            <a href="{{ url('dispatch/dashboard') }}" {{ Request::is('dispatch/dashboard') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Dispatch Dashboard</span>
            </a>
            <a href="{{ url('dispatch/all-leads') }}" {{ Request::is('dispatch/all-leads') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                <span class="item">All Leads</span>
            </a>
            @if(isset(session('permissions')['lead']) || isset(session('permissions')['reception']) || session('role') == 'Agent')
                <a href="{{ url('customers/1/show') }}" {{  Request::is('customers/1/show')  ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Permanent Customers</span>
                </a>
                <a href="{{ url('customers/0/show') }}" {{  Request::is('customers/0/show') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Temporary Customers</span>
                </a>
                <a href="{{ url('dispatch/recipients') }}" {{ Route::current()->getName() == 'dispatch/recipients' ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Recipients</span>
                </a>
            @endif

            <a href="{{ url('dispatch/dispatch-list') }}" {{ Request::is('dispatch/dispatch-list' )? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Leads</span>
            </a>
            @if(isset(session('permissions')['lead']) || isset(session('permissions')['reception']))
                <a href="{{ url('customers/create') }}" {{ Request::is('customers/create') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Add Customer</span>
                </a>  <a href="{{ url('dispatch/create-recipients') }}" {{ Request::is('dispatch/create-recipients') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Add Recipients</span>
                </a>
            @endif
            @if(isset(session('permissions')['create_lead']))
                <a href="{{ url('dispatch/create-lead') }}" {{ Request::is('dispatch/create-lead') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Create Lead</span>
                </a>
            @endif
            @if(session('role') == 'Admin')
                {{-- <a href="{{ url('dispatch/create-user') }}" {{ Request::is('dispatch/create-user') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Create User</span>
                </a>
                <a href="{{ url('dispatch/view-user') }}" {{ Route::current()->getName() == 'dispatch/view-user' ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Users</span>
                </a> --}}
                <a href="{{ url('maps/view-map') }}" {{ Request::is('maps/view-map') ? 'class=active' : '' }}>
                    <span class="menu_icon">
                        <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                            <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                        </svg>
                    </span>
                    <span class="item">Location Report</span>
                </a>
            @endif
            @endif
            {{-- <a href="{{ url('document/document-dashoard') }}" {{ Request::is('document/*') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Document Management</span>
            </a>
        </div> --}}
    </nav>
</div><!--/END Sidebar Nav -->
