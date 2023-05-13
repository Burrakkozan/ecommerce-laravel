<!-- Header  -->
<header class="header-area header-style-1 header-height-2">
    <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div>
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info">
                        <ul>

                            <li><a href="{{route('mycart')}}">My Cart</a></li>
                            <li><a href="{{route('checkout')}}">Checkout</a></li>
                            <li><a href="{{route('order.tracking')}}">Order Tracking</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <li>100% Secure delivery without contacting the courier</li>
                                <li>Supper Value Deals - Save more with coupons</li>
                                <li>Trendy 25silver jewelry, save up 35% off today</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>

                            <li>
{{--                                <a class="language-dropdown-active" href="#">English <i class="fi-rs-angle-small-down"></i></a>--}}
{{--                                <ul class="language-dropdown">--}}
{{--                                    <li>--}}
{{--                                        <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-fr.png') }}" alt="" />Français</a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-dt.png') }}" alt="" />Deutsch</a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-ru.png') }}" alt="" />Pусский</a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
                            </li>

                            <li>Need help? Call Us: <strong class="text-brand"> + 1800 900</strong></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @php

        $categories = App\Models\Category::orderBy('category_name','ASC')->get();
    @endphp


    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href=""><img src="{{ asset('frontend/assets/imgs/logos.svg') }}" alt="logo" /></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">

                        <form action="{{ route('product.search') }}" method="post">
                            @csrf

                            <select class="select-active" >
                                <option>All Categories</option>
                                @foreach($categories as $item)
                                    @if($loop->index < 5)
                                        <option value="{{ url('product/category/'.$item->id.'/'.$item->category_slug) }}">
                                            <a href="{{ url('product/category/'.$item->id.'/'.$item->category_slug) }}">{{ $item->category_name }} </a>
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <input onfocus="search_result_show()" onblur="search_result_hide()" name="search" id="search" placeholder="Search for items..." />
                            <div id="searchProducts"></div>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
{{--                            <div class="search-location">--}}
{{--                                <form action="#">--}}
{{--                                    <select class="select-active">--}}
{{--                                        <option>Your Location</option>--}}
{{--                                        <option>Alabama</option>--}}
{{--                                        <option>Alaska</option>--}}
{{--                                        <option>Arizona</option>--}}
{{--                                        <option>Delaware</option>--}}
{{--                                        <option>Florida</option>--}}
{{--                                        <option>Georgia</option>--}}
{{--                                        <option>Hawaii</option>--}}
{{--                                        <option>Indiana</option>--}}
{{--                                        <option>Maryland</option>--}}
{{--                                        <option>Nevada</option>--}}
{{--                                        <option>New Jersey</option>--}}
{{--                                        <option>New Mexico</option>--}}
{{--                                        <option>New York</option>--}}
{{--                                    </select>--}}
{{--                                </form>--}}
{{--                            </div>--}}

                            <div class="header-action-icon-2">
                                <a href="{{ route('compare') }}">
                                    <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-compare.svg')}}" />
                                </a>
                                <a href="{{ route('compare') }}"><span class="lable ml-0">Compare</span></a>
                            </div>

                            <div class="header-action-icon-2">
                                <a href="{{ route('wishlist') }}">
                                    <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count blue" id="wishQty">0 </span>
                                </a>
                                <a href="{{ route('wishlist') }}"><span class="lable">Wishlist</span></a>
                            </div>




                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{route('mycart')}}">
                                    <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count blue" id="cartQty">0</span>
                                </a>
                                <a href="{{ route('mycart') }}"><span class="lable">Cart</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">


                                    <!--   // mini cart start with ajax -->
                                    <div id="miniCart">

                                    </div>

                                    <!--   // End mini cart start with ajax -->





                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span id="cartSubTotal">$</span>
                                                {{--                                            <span id="cartSubTotal">$</span>--}}
                                            </h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="{{route('mycart')}}" class="outline">View cart</a>
                                            <a href="{{route('checkout')}}">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>






                            <div class="header-action-icon-2">
                                <a href="{{ route('dashboard') }}">
                                    <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                                </a>


                                @auth
                                    <a href="{{ route('dashboard') }}"><span class="lable ml-0">Account</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li>
                                                <a href="{{ route('dashboard') }}"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('dashboard') }}"><i class="fi fi-rs-location-alt mr-10"></i>Order Tracking</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('dashboard') }}"><i class="fi fi-rs-label mr-10"></i>My Voucher</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('dashboard') }}"><i class="fi fi-rs-heart mr-10"></i>My Wishlist</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('dashboard') }}"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                            </li>
                                        </ul>
                                    </div>

                                @else
                                    <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>

                                    <span class="lable" style="margin-left: 2px; margin-right: 2px;" > | </span>


                                    <a href="{{ route('register') }}"><span class="lable ml-0">Register</span></a>

                                @endauth




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    @php

        $categories = App\Models\Category::orderBy('category_name','ASC')->get();
    @endphp


    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="{{ url('/') }}"><img src="{{ asset('frontend/assets/imgs/logos.svg') }}" alt="logo" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi-rs-apps"></span>   All Categories
                            <i class="fi-rs-angle-down"></i>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    @foreach($categories as $item)
                                        @if($loop->index < 5)
                                            <li>
                                                <a href="{{ url('product/category/'.$item->id.'/'.$item->category_slug) }}"> <img src="{{ asset( 'storage/'.$item->image ) }}" alt="" /> {{ $item->category_name }} </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <ul class="end">
                                    @foreach($categories as $item)
                                        @if($loop->index > 4)
                                            <li>
                                                <a href="{{ url('product/category/'.$item->id.'/'.$item->slug) }}"> <img src="{{ asset('storage/'. $item->image ) }}" alt="" /> {{ $item->category_name }} </a>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>
                            <div class="more_slide_open" style="display: none">
                                <div class="d-flex categori-dropdown-inner">
                                    <ul>
                                        @foreach($categories as $item)
                                            @if($loop->index < 5)
                                                <li>
                                                    <a href="{{ url('product/category/'.$item->id.'/'.$item->category_slug) }}"> <img src="{{ asset( 'storage/'.$item->image ) }}" alt="" /> {{ $item->category_name }} </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <ul class="end">
                                        @foreach($categories as $item)
                                            @if($loop->index > 4)
                                                <li>
                                                    <a href="{{ url('product/category/'.$item->id.'/'.$item->slug) }}"> <img src="{{ asset('storage/'. $item->image ) }}" alt="" /> {{ $item->category_name }} </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">Show more...</span></div>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>

                                <li>
                                    <a class="active" href="{{ url('/') }}">Home  </a>

                                </li>

                                @php

                                    $categories = App\Models\Category::orderBy('category_name','ASC')->limit(4)->get();
                                @endphp


                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ url('product/category/'.$category->id.'/'.$category->slug) }}">{{ $category->category_name }} <i class="fi-rs-angle-down"></i></a>

                                        @php
                                            $subcategories = App\Models\SubCategory::where('category_id',$category->id)->orderBy('subcategory_name','ASC')->get();

                                        @endphp


                                        <ul class="sub-menu">
                                            @foreach($subcategories as $subcategory)
                                                <li><a href="{{ url('product/subcategory/'.$subcategory->category_id.'/'.$subcategory->slug) }}">{{ $subcategory->subcategory_name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach



                                <li>
                                    <a href="{{ route('home.blog') }}">Blog</a>
                                </li>
                                <li>
                                    <a href="{{ route('shop.page') }}">Shop</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>


                <div class="hotline d-none d-lg-flex">
                    <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                    <p>1900 - 888<span>24/7 Support Center</span></p>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a href="{{route('wishlist')}}">
                                <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                <span class="pro-count white" id="wishQty">0</span>
                            </a>

                        </div>
                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="{{route('mycart')}}">
                                <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                <span class="pro-count blue" id="cartQty">0</span>
                            </a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">

                                <!--   // mini cart start with ajax -->
                                <div id="miniCart">


                                </div>

                                <!--   // End mini cart start with ajax -->
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span id="cartSubTotal">$</span>
{{--                                            <span id="cartSubTotal">$</span>--}}
                                        </h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="{{route('mycart')}}">View cart</a>
                                        <a href="{{route('checkout')}}">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- End Header  -->
<style>
    #searchProducts{
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #ffffff;
        z-index: 999;
        border-radius: 8px;
        margin-top: 5px;
    }
</style>

<script>
    function search_result_show(){
        $("#searchProducts").slideDown();

    }

    function search_result_hide(){
        $("#searchProducts").slideUp();
    }
</script>


<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{ url('/') }}"><img src="{{ asset('frontend/assets/imgs/logos.svg') }}" alt="logo" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="#">
{{--                    <input type="text" placeholder="Search for items…" />--}}
{{--                    <button type="submit"><i class="fi-rs-search"></i></button>--}}
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a href="{{ url('/') }}">Home</a>

                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('shop.page') }}">shop</a>
                            <ul class="dropdown">
                                <li><a href="{{route('wishlist')}}">Wishlist</a></li>
                                <li><a href="{{route('mycart')}}">Shop – Cart</a></li>
                                <li><a href="{{route('checkout')}}">Checkout</a></li>
                                <li><a href="{{route('compare')}}">Shop – Compare</a></li>
                            </ul>
                        </li>

                        <li class="menu-item-has-children">
                            <a href="#">Category</a>
                            <ul class="dropdown">


                                        @foreach($categories as $item)
                                            @if($loop->index < 5)
                                                <li>
                                                    <a href="{{ url('product/category/'.$item->id.'/'.$item->category_slug) }}"> <img src="{{ asset( 'storage/'.$item->image ) }}" alt=""style="width:20px;height:20px"  /> {{ $item->category_name }}  </a>
                                                </li>
                                            @endif
                                        @endforeach



                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{route('home.blog')}}">Blog</a>
                            <ul class="dropdown">
                                <li><a href="{{route('home.blog')}}">Blog </a></li>


                            </ul>
                        </li>
{{--                        <li class="menu-item-has-children">--}}
{{--                            <a href="#">Pages</a>--}}
{{--                            <ul class="dropdown">--}}
{{--                                <li><a href="page-about.html">About Us</a></li>--}}
{{--                                <li><a href="page-contact.html">Contact</a></li>--}}
{{--                                <li><a href="{{ route('dashboard') }}">My Account</a></li>--}}
{{--                                <li><a href="{{ route('login') }}">Login</a></li>--}}
{{--                                <li><a href="{{ route('register') }}">Register</a></li>--}}
{{--                                <li><a href="page-privacy-policy.html">Privacy Policy</a></li>--}}
{{--                                <li><a href="page-terms.html">Terms of Service</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">

                    @auth
                        <a href="{{ route('dashboard') }}"><i class="fi-rs-user"></i>My Account </a>
                        <a href="{{ route('user.logout') }}" ><i class="fi-rs-logout"></i>Log out </a>
                    @else
                        <a href="{{ route('login') }}"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                    @endauth
{{--                    <a href="page-contact.html"><i class="fi-rs-marker"></i> Our location </a>--}}
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-pinterest-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube-white.svg') }}" alt="" /></a>
            </div>
            <div class="site-copyright">Copyright 2023 © Burakozcan.</div>
        </div>
    </div>
</div>
