@extends('frontend.master_dashboard')
@section('title')
    {{ $blogdetails->post_title }}
@endsection
@section('main')



 <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{url('/')}}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="">
                    	@foreach($breadcat as $cat)
                    	{{ $cat->blog_category_name }}
                    	@endforeach

                </a>
                     <span></span> {{ $blogdetails->post_title }}
                </div>
            </div>
        </div>
        <div class="page-content mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-11 col-lg-12 m-auto">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="single-page pt-50 pr-30">
                                    <div class="single-header style-2">
                                        <div class="row">
                                            <div class="col-xl-10 col-lg-12 m-auto">

            <h2 class="mb-10">{{ $blogdetails->post_title }}</h2>
            <div class="single-header-meta">
                <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                    <a class="author-avatar" href="#">
                        <img class="img-circle" src="{{ asset('frontend/assets/imgs/blog/author-1.png') }}" alt="" />
                    </a>
                    <span class="post-by">By <a href="#">Admin</a></span>
   <span class="post-on has-dot">{{ Carbon\Carbon::parse($blogdetails->created_at)->diffForHumans() }}</span>
                    <span class="time-reading has-dot">8 mins read</span>
                </div>
                <div class="social-icons single-share">
                    <ul class="text-grey-5 d-inline-block">
                        <li class="mr-5">
                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-bookmark.svg') }}" alt="" /></a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    <figure class="single-thumbnail">
    <img src="{{ asset('storage/'.$blogdetails->post_image) }}" alt="" style="width: 500px; height: 400px;" />
    </figure>
    <div class="single-content">
    <div class="row">
        <div class="col-xl-10 col-lg-12 m-auto">
            <p class="single-excerpt"> {!! $blogdetails->post_long_description !!} </p>
            <!--Entry bottom-->
            <div class="entry-bottom mt-50 mb-30">
                <div class="tags w-50 w-sm-100">
                    <a href="blog-category-big.html" rel="tag" class="hover-up btn btn-sm btn-rounded mr-10">deer</a>
                    <a href="blog-category-big.html" rel="tag" class="hover-up btn btn-sm btn-rounded mr-10">nature</a>
                    <a href="blog-category-big.html" rel="tag" class="hover-up btn btn-sm btn-rounded mr-10">conserve</a>
                </div>
                <div class="social-icons single-share">
                    <ul class="text-grey-5 d-inline-block">
                        <li><strong class="mr-10">Share this:</strong></li>
                        <li class="social-facebook">
                            <a href="#"><img src="assets/imgs/theme/icons/icon-facebook.svg" alt="" /></a>
                        </li>
                        <li class="social-twitter">
                            <a href="#"><img src="assets/imgs/theme/icons/icon-twitter.svg" alt="" /></a>
                        </li>
                        <li class="social-instagram">
                            <a href="#"><img src="assets/imgs/theme/icons/icon-instagram.svg" alt="" /></a>
                        </li>
                        <li class="social-linkedin">
                            <a href="#"><img src="assets/imgs/theme/icons/icon-pinterest.svg" alt="" /></a>
                        </li>
                    </ul>
                </div>
                                                </div>
            <div class="tab-pane fade" id="Reviews">
            </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 primary-sidebar sticky-sidebar pt-50">
                                <div class="widget-area">
                                    <div class="sidebar-widget-2 widget_search mb-50">
                                        <div class="search-form">
                                            <form action="#">
                                                <input type="text" placeholder="Search…" />
                                                <button type="submit"><i class="fi-rs-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="sidebar-widget widget-category-2 mb-50">
                                        <h5 class="section-title style-1 mb-30">Category</h5>
                                           <ul>
        	@foreach($blogcategoryies as $category)

        	@php
    $posts = App\Models\BlogPost::where('category_id',$category->id)->get();
        	@endphp

            <li>
                <a href="{{ url('post/category/'.$category->id.'/'.$category->blog_category_slug) }}"> <img src="{{ asset('frontend/assets/imgs/theme/icons/category-1.svg') }}" alt="" />{{ $category->blog_category_name }}</a><span class="count">{{ count($posts) }}</span>
            </li>
            @endforeach
        </ul>
                                    </div>
                                    <!-- Product sidebar Widget -->

                                    <div class="banner-img wow fadeIn mb-50 animated d-lg-block d-none">
                                        <img src="{{ asset('frontend/assets/imgs/banner/banner-11.png') }}" alt="" />
                                        <div class="banner-text">
                                            <span>Oganic</span>
                                            <h4>
                                                Save 17% <br />
                                                on <span class="text-brand">Oganic</span><br />
                                                Juice
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




@endsection
