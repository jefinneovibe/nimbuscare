<!-- Sidebar Nav -->
<div class="menu-wrap">
    <div class="sidebar_logo">
        <img src="{{URL::asset('img/main/interactive_logo.png')}}">
    </div>
    <nav class="menu">
        <div class="menu-list">
            <a href="{{ url('dash') }}" {{ Request::is('dash') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Main Dashboard</span>
            </a>
            @if((session('assigned_permissions')) && (in_array('CRM',session('assigned_permissions'))))
            <a href="{{ url('crm-dashbord') }}" {{ Request::is('crm-dashbord') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Broking Slip Dashboard</span>
            </a>
            <a href="{{ url('customers/1/show') }}" {{ Request::is('customers/1/show') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Permanent Customers</span>
            </a>
            <a href="{{ url('customers/0/show') }}" {{Request::is('customers/0/show') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Temporary Customers</span>
            </a>
            <a href="{{ url('policies') }}" {{ Route::current()->getName() == 'policies' ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Policies</span>
            </a>
            <a href="{{ url('pipelines') }}" {{ Route::current()->getName() == 'pipeline' ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Pipeline</span>
            </a>
            <a href="{{ url('pending-issuance') }}" {{ Route::current()->getName() == 'pending-issuance' ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Pending Issuance</span>
            </a>
            <a href="{{ url('pending-approvals') }}" {{ Route::current()->getName() == 'pending-approvals' ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Pending Approvals</span>
            </a>
            <a href="{{ url('closed-pipelines') }}" {{ Route::current()->getName() == 'closed-pipelines' ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Closed List</span>
            </a>
            <a href="{{ url('customers/create') }}" {{ Request::is('customers/create') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Add Customers</span>
            </a>

            <a href="{{ url('insurers/create') }}" {{ Request::is('insurers/create') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Add Insurers</span>
            </a>
            <a href="{{ url('insurers/show') }}" {{ Request::is('insurers/show') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Insurers</span>
            </a>

            <a href="{{ url('work-types/create') }}" {{ Request::is('work-types/create') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Create Work Type</span>
            </a>
            <a href="{{ url('leave/leave-list') }}" {{ Request::is('leave/leave-list') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Leave List</span>
            </a>
            @endif

        </div>
    </nav>
</div><!--/END Sidebar Nav -->
