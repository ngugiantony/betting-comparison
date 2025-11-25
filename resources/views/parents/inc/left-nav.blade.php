<style>
    .leftside-menu {
        background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
        width: 260px;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s ease;
    }
    
    .logo {
        padding: 1.5rem 1rem;
        display: block;
        text-decoration: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .logo:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .logo-lg {
        font-size: 1.3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: block;
    }
    
    #leftside-menu-container {
        height: calc(100vh - 80px);
        overflow-y: auto;
        padding: 1rem 0;
    }
    
    /* Custom scrollbar */
    #leftside-menu-container::-webkit-scrollbar {
        width: 6px;
    }
    
    #leftside-menu-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    
    #leftside-menu-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    
    #leftside-menu-container::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .side-nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .side-nav-title {
        padding: 1.5rem 1.5rem 0.75rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #a0aec0;
        font-weight: 700;
    }
    
    .side-nav-item {
        margin: 0.25rem 0.75rem;
    }
    
    .side-nav-link {
        display: flex;
        align-items: center;
        padding: 0.875rem 1rem;
        color: #cbd5e0;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }
    
    .side-nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }
    
    .side-nav-link:hover {
        background: rgba(102, 126, 234, 0.15);
        color: #ffffff;
        transform: translateX(5px);
    }
    
    .side-nav-link:hover::before {
        transform: scaleY(1);
    }
    
    .side-nav-link.active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .side-nav-link.active::before {
        transform: scaleY(1);
    }
    
    .side-nav-link i {
        font-size: 1.25rem;
        width: 24px;
        margin-right: 0.875rem;
        color: #667eea;
        transition: all 0.3s ease;
    }
    
    .side-nav-link:hover i {
        transform: scale(1.1);
        color: #764ba2;
    }
    
    .side-nav-link span {
        flex: 1;
    }
    
    /* Badge for notifications */
    .nav-badge {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        font-weight: 600;
        margin-left: auto;
    }
    
    /* Divider */
    .nav-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
        margin: 1rem 1.5rem;
    }
    
    @media (max-width: 768px) {
        .leftside-menu {
            transform: translateX(-100%);
        }
        
        .leftside-menu.show {
            transform: translateX(0);
        }
    }
</style>

<div class="leftside-menu">

    <a href="" class="logo text-center logo-light">
        <span class="logo-lg">
            {{-- <img src="{{ asset('assets/images/centyplus logo.png') }}" alt="" height="60"> --}}
           OddsSolver
        </span>
        <span class="logo-sm">
            {{-- <img src="{{ asset('assets/images/centyplus logo.png') }}" alt="" height="60"> --}}
        </span>
    </a>   

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item" style="display: none">OddsSolver</li>

            <li class="side-nav-item mt-5">
                <a href="{{ route('matches.index')}}" class="side-nav-link active">
                    <i class="uil-trophy"></i>
                    <span>Oddsmatcher</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="#" class="side-nav-link">
                    <i class="uil-graph-bar"></i>
                    <span>Bets Stream</span>
                    <span class="nav-badge">New</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="#" class="side-nav-link">
                    <i class="uil-comments"></i>
                    <span>Discord</span>
                </a>
            </li>

            <div class="nav-divider"></div>

            <li class="side-nav-title side-nav-item">Management</li>

            <li class="side-nav-item">
                <a href="#" class="side-nav-link">
                    <i class="uil-book-open"></i>
                    <span>Bookies</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="#" class="side-nav-link">
                    <i class="uil-setting"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="#" class="side-nav-link">
                    <i class="uil-user-circle"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>