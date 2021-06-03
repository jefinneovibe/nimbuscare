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
            @if((session('assigned_permissions')) && (in_array('User Management',session('assigned_permissions'))))
            <a href="{{ url('user/dashboard') }}" {{ Request::is('user/dashboard') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">User Management Dashboard</span>
            </a>
            <a href="{{ url('user/view-user') }}" {{ Route::current()->getName() == 'user' ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">View Users</span>
            </a>
            <a href="{{ url('user/create-user') }}" {{ Request::is('user/create-user') ? 'class=active' : '' }}>
                <span class="menu_icon">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 384 384">
                        <path d="M213.333 0H384v128H213.333zM0 0h170.667v213.333H0zM0 256h170.667v128H0zM213.333 170.667H384V384H213.333z"/>
                    </svg>
                </span>
                <span class="item">Create User</span>
            </a>
        @endif
        </div>
    </nav>
</div><!--/END Sidebar Nav -->