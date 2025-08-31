<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.layouts.partials.header')
</head>

<body>

    <!-- preloader area start -->
    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="loader_bars">
                <span></span>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    <!-- Dashboard start -->
    <div class="body-overlay"></div>
    <div class="dashboard__area">
        <div class="container-fluid p-0">
            <div class="dashboard__contents__wrapper">

                <!-- Left Side Bar Start Here -->
                @include('backend.layouts.partials.left_sidebar')
                <!-- Left Side Bar End Here -->

                <div class="dashboard__right">

                    <!-- NavBar Start Here -->
                    @include('backend.layouts.partials.navbar')
                    <!-- NavBar End Here -->

                    
                    <div class="dashboard__body posPadding">

                    <!-- Main Content Start Here -->
                        @yield('main-content')
                    <!-- Main Content End Here -->

                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard end -->


    {{-- Script start Here --}}
    @include('backend.layouts.partials.script')
    {{-- Script End Here --}}
    @yield('scripts')
</body>

</html>
