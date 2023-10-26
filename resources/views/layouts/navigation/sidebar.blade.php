        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                   
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                   
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title fs-22 text-white"><span data-key="t-menu">ITC Store</span></li>
                        
                     

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{URL('/dashboard')}}">
                                <i class="ri-file-list-3-line"></i> <span data-key="t-advance-ui">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{URL('/orders')}}">
                                <i class="ri-stack-line"></i> <span data-key="t-advance-ui">Orders</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{URL('/mis-overview')}}">
                                <i class="ri-table-line"></i> <span data-key="t-advance-ui">MIS Reports</span>
                            </a>
                        </li>
						
						<li class="nav-item">
                            <a class="nav-link menu-link" href="{{URL('/sbd-mis-overview')}}">
                                <i class="ri-table-line"></i> <span data-key="t-advance-ui">SBD MIS Reports</span>
                            </a>
                        </li>

                    

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->