<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="/dashboard" class="header-logo">
            <img src="{{ asset('images/Teba_Express.png') }}" alt="logo" class="desktop-logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
                <ul class="main-menu">
                    @if(Auth::check() && in_array(Auth::user()->role_id,[1,2]))
                    <li class="slide mt-3">
                        <a href="/dashboard"
                        class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                            <path
                                d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                        </svg>
                        <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    @endif
                    <!-- Start::slide -->
                    @if(Auth::check() && in_array(Auth::user()->role_id,[3]))
                        <li class="slide__category"><span class="category-name">Form</span></li>
                        <li class="slide">
                            <a href="/perjalanan/form"
                                class="side-menu__item {{ request()->routeIs('perjalanan.form_index') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM7 6H11V10H7V6ZM7 12H17V14H7V12ZM7 16H17V18H7V16ZM13 7H17V9H13V7Z"></path>
                                </svg>
                                <span class="side-menu__label">Form Perjalanan</span>
                            </a>
                        </li>
                    @endif
                    <!-- End::slide -->
                    <!-- Start::slide__category -->
                    <li class="slide__category"><span class="category-name">Main</span></li>
                    <!-- End::slide__category -->
                    <li class="slide">
                        <a href="/perjalanan" class="side-menu__item {{ request()->routeIs('perjalanan.index') ? 'active' : '' }}" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon " width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-navigation"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>                            
                            <span class="side-menu__label">Data Perjalanan</span>
                        </a>
                    </li>
                    <!-- Start::slide__category -->
                    @if(Auth::check() && in_array(Auth::user()->role_id,[1,2]))
                    <li class="slide">
                        <a href="/pengeluaran" class="side-menu__item {{ request()->routeIs('pengeluaran.index') ? 'active' : '' }}" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="side-menu__icon bi bi-cash-coin" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                            </svg>                            
                            <span class="side-menu__label">Data Pengeluaran</span>
                        </a>
                    </li>
                    <li class="slide__category"><span class="category-name">Master</span></li>
                    <!-- End::slide__category -->
                    <li class="slide">
                        <a href="/supir" class="side-menu__item {{ request()->routeIs('supir.index') ? 'active' : '' }}">
                            <svg  xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg>
                            <span class="side-menu__label">Data Supir</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="/truk" class="side-menu__item {{ request()->routeIs('truk.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span class="side-menu__label">Data Truk</span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::check() && in_array(Auth::user()->role_id,[1]))
                    <!-- End::slide__category -->
                    <li class="slide">
                        <a href="/user" class="side-menu__item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span class="side-menu__label">Data User</span>
                        </a>
                    </li>
                    @endif
                    @if(Auth::check() && in_array(Auth::user()->role_id,[3]))
                        <li class="slide__category"><span class="category-name">Data</span></li>
                        <li class="slide">
                            <a href="/supir/form/{{ Auth::user()->supir->id }}" class="side-menu__item {{ request()->routeIs('supir.form') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="side-menu__label">Data Diri</span>
                            </a>
                        </li>
                    @endif
                </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav> <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
