<!-- Sidebar Nav -->
<div class="menu-wrap">
    <div class="sidebar_logo">
        <img src="{{URL::asset('img/main/interactive_logo.png')}}">
    </div>
    <nav class="menu">
        <div class="menu-list">
                @if((session('assigned_permissions')) && (in_array('CRM',session('assigned_permissions'))))
                <a href="{{ url('crm-dashbord') }}" {{ Request::is('crm-dashbord') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Broking Slip</span>
            </a>
            @endif
            @if((session('assigned_permissions')) && (in_array('Dispatch',session('assigned_permissions'))))
            <a href="{{ url('dispatch/login') }}" {{ Request::is('dispatch/login') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Dispatch</span>
            </a>
            @endif
            @if((session('assigned_permissions')) && (in_array('Document Management',session('assigned_permissions'))))

            <a href="{{ url('document/document-dashoard') }}" {{ Request::is('document/*') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Document Management</span>
            </a>
            @endif
            @if((session('assigned_permissions')) && (in_array('Enquiry Management',session('assigned_permissions'))))
            <a href="{{ url('enquiry/enquiry-dashboard') }}" {{ Request::is('enquiry/*') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Enquiry Management</span>
            </a>
            @endif
            @if((session('assigned_permissions')) && (in_array('User Management',session('assigned_permissions'))))
            <a href="{{ url('user/dashboard') }}" {{ Request::is('user/*') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">User Management</span>
            </a>
            @endif
        </div>
    </nav>
</div><!--/END Sidebar Nav -->
