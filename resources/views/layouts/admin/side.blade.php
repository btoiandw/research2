<style>
    .active-nav {
        border-left: 1vh solid #ffb703;
        background-color: #cfcfcf;
        color: rgb(0, 0, 0)
    }
</style>
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light shadow-box-login min-nav pb-md-5"
    id="sidenav-main" style="background-color: #8E0505;">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="">
            <img src="{{ asset('img/LogoRDI.png') }}" class="navbar-brand-img" alt="..." width="100px">
        </a>

        <!-- Collapse -->
        <div class="collapse  navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none w-md-100">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/lanna-removebg-preview.png') }}" class="navbar-brand-img"
                                alt="...">
                        </a>
                    </div>
                    <div class="col-6 collapse-close ">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <div class="text-center pb-3 d-block d-sm-none" style="font-weight: 700"> </div>


            <ul class="navbar-nav ">
                <li
                    class="{{ 'admin/dashboard' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                    <a class="{{ 'admin/dashboard' == request()->path() ? 'nav-link text-darker  ' : 'nav-link ' }}"
                        style="font-weight: 600;font-size:1rem" href="">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                <li
                    class="{{ 'admin/manage/users' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                    <a class="{{ 'admin/manage/users' == request()->path() ? 'nav-link text-darker  ' : 'nav-link ' }}"
                        style="font-weight: 600;font-size:1rem" href="">
                        {{ __('Admin') }}
                    </a>
                </li>
                <li
                    class="{{ 'admin/request' == request()->path() || 'admin/request-all' == request()->path() || 'admin/history' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                    <a class="{{ 'admin/request' == request()->path() || 'admin/history' == request()->path() ? 'nav-link text-darker' : 'nav-link ' }}"
                        style="font-weight: 600;font-size:1rem" href="">
                        {{ __('โครงร่างงานวิจัย') }} </a>
                    <ul class="sub-menu py-2 ">
                        <li class="nav-item">
                            <a class="{{ 'admin/request' == request()->path() ? 'nav-link-sub text-darker' : 'nav-link-sub ' }}"
                                style="font-weight: 600;font-size:0.9rem" href="">
                                <i class="fa-solid fa-minus"style="font-size: 50%"></i>
                                {{ __('โครงร่างงานวิจัย') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ 'admin/request-all' == request()->path() ? 'nav-link-sub text-darker' : 'nav-link-sub ' }}"
                                style="font-weight: 600;font-size:0.9rem" href="">
                                <i class="fa-solid fa-minus"style="font-size: 50%"></i>
                                {{ __('โครงร่างที่เสนอพิจารณา') }}

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="{{ 'admin/history' == request()->path() ? 'nav-link-sub text-darker' : 'nav-link-sub ' }}"
                                style="font-weight: 600;font-size:0.9rem" href="">
                                <i class="fa-solid fa-minus"style="font-size: 50%"></i>
                                {{ __('จัดการแหล่งทุน') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="{{ 'admin/history' == request()->path() ? 'nav-link-sub text-darker' : 'nav-link-sub ' }}"
                                style="font-weight: 600;font-size:0.9rem" href="">
                                <i class="fa-solid fa-minus"style="font-size: 50%"></i>
                                {{ __('จัดการรายการส่งมอบ') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="{{ 'admin/history' == request()->path() ? 'nav-link-sub text-darker' : 'nav-link-sub ' }}"
                                style="font-weight: 600;font-size:0.9rem" href="">
                                <i class="fa-solid fa-minus"style="font-size: 50%"></i>
                                {{ __('รายงานสรุปทุนวิจัย') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ 'admin/history' == request()->path() ? 'nav-link-sub text-darker' : 'nav-link-sub ' }}"
                                style="font-weight: 600;font-size:0.9rem" href="">
                                <i class="fa-solid fa-minus"style="font-size: 50%"></i>
                                {{ __('รายงานสรุปงานวิจัย') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="{{ 'admin/manage/users' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                    <a class="{{ 'admin/manage/users' == request()->path() ? 'nav-link text-darker  ' : 'nav-link ' }}"
                        style="font-weight: 600;font-size:1rem" href="">
                        {{ __('งานวิจัย') }}
                    </a>
                </li>
                <li
                    class="{{ 'admin/manage/users' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                    <a class="{{ 'admin/manage/users' == request()->path() ? 'nav-link text-darker  ' : 'nav-link ' }}"
                        style="font-weight: 600;font-size:1rem" href="">
                        {{ __('งานตีพิมพ์เผยแพร่') }}
                    </a>
                </li>
            </ul>
        </div>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-danger logout">
            <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
        </a>

    </div>
</nav>
