<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div>
    <div class="logo-wrapper ">
        <a href="{{url('/')}}" class="text-white">
            <img style="width: 40px; border-radius: 40%" class="img-fluid" src="{{asset('img/logo-roputex.jpg')}}" alt=""> Kontrabon
        </a>
        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        <div class="toggle-sidebar">
        <svg class="stroke-icon sidebar-toggle status_toggle middle">
            <use href="{{asset('mofi/assets/svg/icon-sprite.svg#toggle-icon')}}"></use>
        </svg>
        <svg class="fill-icon sidebar-toggle status_toggle middle">
            <use href="{{asset('mofi/assets/svg/icon-sprite.svg#fill-toggle-icon')}}"></use>
        </svg>
        </div>
    </div>
    <div class="logo-icon-wrapper">
        <a href="{{url('/')}}" class="text-white">
            <img style="width: 40px; border-radius: 40%" class="img-fluid" src="{{asset('img/logo-roputex.jpg')}}" alt="">
        </a>
    </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{url('/')}}" class="text-white"><img style="width: 40px; border-radius: 40%" class="img-fluid" src="{{asset('img/logo-roputex.jpg')}}" alt=""></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">MASTER DATA</h6>
                        </div>
                    </li>

                    <li class='sidebar-list'>
                        <i class='fa fa-thumb-tack'></i>
                        <a class='sidebar-link sidebar-title link-nav' href='#' onclick="openTabs(this)" data-id_tab="MD_1">
                            <i class="fa fa-smile-o text-white"></i>
                            <span class="ms-2">Data Customer</span>
                        </a>
                    </li>

                    <li class='sidebar-list'>
                        <i class='fa fa-thumb-tack'></i>
                        <a class='sidebar-link sidebar-title link-nav' href='#' onclick="openTabs(this)" data-id_tab="MD_2">
                            <i class="fa fa-credit-card text-white"></i>
                            <span class="ms-2">Data Bank</span>
                        </a>
                    </li>

                    <li class='sidebar-list'>
                        <i class='fa fa-thumb-tack'></i>
                        <a class='sidebar-link sidebar-title link-nav' href='#' onclick="openTabs(this)" data-id_tab="MD_3">
                            <i class="fa fa-list-alt text-white"></i>
                            <span class="ms-2">Data Sales</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">MENU CONTRABON</h6>
                        </div>
                    </li>

                    <li class='sidebar-list'>
                        <i class='fa fa-thumb-tack'></i>
                        <a class='sidebar-link sidebar-title link-nav' href='#' onclick="openTabs(this)" data-id_tab="T_1">
                            <i class="fa fa-file-text text-white"></i>
                            <span class="ms-2">List</span>
                        </a>
                    </li>
                    <li class='sidebar-list'>
                        <i class='fa fa-thumb-tack'></i>
                        <a class='sidebar-link sidebar-title link-nav' href='#' onclick="openTabs(this)" data-id_tab="T_2">
                            <i class="fa fa-plus text-white"></i>
                            <span class="ms-2">Buat</span>
                        </a>
                    </li>
                    {{-- <li class='sidebar-list'>
                        <i class='fa fa-thumb-tack'></i>
                        <a class='sidebar-link sidebar-title link-nav' href='#' onclick="openTabs(this)" data-id_tab="T_3">
                            <i class="fa fa-pencil text-white"></i>
                            <span class="ms-2">Edit</span>
                        </a>
                    </li> --}}

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
