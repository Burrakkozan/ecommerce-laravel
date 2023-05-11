{{--<x-guest-layout>--}}
{{--    <div class="mb-4 text-sm text-gray-600">--}}
{{--        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}--}}
{{--    </div>--}}

{{--    @if (session('status') == 'verification-link-sent')--}}
{{--        <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--            {{ __('A new verification link has been sent to the email address you provided during registration.') }}--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="mt-4 flex items-center justify-between">--}}
{{--        <form method="POST" action="{{ route('verification.send') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-primary-button>--}}
{{--                    {{ __('Resend Verification Email') }}--}}
{{--                </x-primary-button>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--        <form method="POST" action="{{ route('logout') }}">--}}
{{--            @csrf--}}

{{--            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                {{ __('Log Out') }}--}}
{{--            </button>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</x-guest-layout>--}}

    <!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register - Easy Shop Online Store </title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/logos.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
</head>

<body>

<!-- Quick view -->
@include('frontend.body.header')
<!--End header-->

<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span>  My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-8 col-md-12 m-auto">
                    <div class="row">
                        <div class="heading_s1">
                            <img class="border-radius-15" src="{{ asset('frontend/assets/imgs/page/reset_password.svg') }}" alt="" />
                            <h2 class="mb-15 mt-15">Verify Email address</h2>
                            <p class="mb-30">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>
                        </div>
                                    <x-guest-layout>
                                        <div class="mb-4 text-sm text-gray-600">
                                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                                        </div>

                                        @if (session('status') == 'verification-link-sent')
                                            <div class="mb-4 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                            </div>
                                        @endif

                                        <div class="mt-4 flex items-center justify-between">
                                            <form method="POST" action="{{ route('verification.send') }}">
                                                @csrf

                                                <div>
                                                    <x-primary-button>
                                                        {{ __('Resend Verification Email') }}
                                                    </x-primary-button>
                                                </div>
                                            </form>

                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <button type="submit" class="underline text-sm text-gray-600 ">
                                                    {{ __('Log Out') }}
                                                </button>
                                            </form>
                                        </div>
                                    </x-guest-layout>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('frontend.body.footer')
<!-- Preloader Start -->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="text-center">
                <img src="{{ asset('frontend/circle-loader.gif') }}" alt="" style="max-width: 40px" />
            </div>
        </div>
    </div>
</div>
<!-- Vendor JS-->
<script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
<!-- Template  JS -->
<script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
<script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
</body>

</html>
