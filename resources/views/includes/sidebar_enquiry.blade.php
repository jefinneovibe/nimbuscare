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
            @if((session('assigned_permissions')) && (in_array('Enquiry Management',session('assigned_permissions'))))
            <a href="{{ url('enquiry/enquiry-dashboard') }}" {{ Request::is('enquiry/enquiry-dashboard') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Enquiry Management Dashboard</span>
            </a>
            <a href="{{ url('enquiry/view-enquiries') }}" {{Request::is('enquiry/view-enquiries') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">View Tasks</span>
            </a>
            @if(session('role')=='Admin')
            <a href="{{ url('enquiry/enquiry-view-settings') }}" {{ Request::is('enquiry/enquiry-view-settings') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Settings</span>
            </a>
            <a href="{{ url('enquiry/view-action-report') }}" {{Request::is('enquiry/view-action-report') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">View action level report</span>
            </a>
            @endif
            @endif
        </div>
    </nav>
</div><!--/END Sidebar Nav -->