<header class="site-navbar" role="banner">
    <div class="site-navbar-top">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                    <form action="{{ route('products.index') }}" class="site-block-top-search">
                        <span class="icon icon-search2"></span>
                        <input type="text" class="form-control border-0" name="search" placeholder="搜索">
                    </form>
                </div>

                <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                    <div class="site-logo">
                        <a href="{{ route('root') }}" class="js-logo-clone">Shoppers</a>
                    </div>
                </div>

                <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                    <div class="site-top-icons">
                        <ul>
                            <li><a href="#"><span class="icon icon-person"></span></a></li>
                            <li><a href="{{ route('products.favorites') }}"><span class="icon icon-heart-o"></span></a></li>
                            <li>
                                <a href="{{ route('cart.index') }}" class="site-cart">
                                    <span class="icon icon-shopping_cart"></span>
                                    @guest
                                        @else
                                        <span class="count">{{ $cart_count }}</span>
                                    @endguest
                                </a>
                            </li>
                            <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
            <ul class="site-menu js-clone-nav d-none d-md-block">
                @guest
                <li><a href="{{ route('root') }}">首页</a></li>
                <li><a href="{{ route('products.index') }}">商品列表</a></li>
                <li><a href="{{ route('login') }}">登录</a></li>
                <li><a href="{{ route('register') }}">注册</a></li>
                @else
                <li><a href="{{ route('root') }}">首页</a></li>
                <li><a href="{{ route('products.index') }}">商品列表</a></li>
                <li><a href="{{ route('cart.index') }}">购物车</a></li>
                <li><a href="{{ route('orders.index') }}">订单</a></li>
                <li class="has-children">
                    <a>{{ Auth::user()->name }}</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('user_addresses.index') }}">收货地址</a></li>
                        <li><a href="{{ route('products.favorites') }}">我的收藏</a></li>
                        <li><a href="{{ route('orders.index') }}">我的订单</a></li>
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                退出登录
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest


                {{--<li class="has-children">--}}
                    {{--<a href="about.html">About</a>--}}
                    {{--<ul class="dropdown">--}}
                        {{--<li><a href="#">Menu One</a></li>--}}
                        {{--<li><a href="#">Menu Two</a></li>--}}
                        {{--<li><a href="#">Menu Three</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li><a href="shop.html">Shop</a></li>--}}
                {{--<li><a href="#">Catalogue</a></li>--}}
                {{--<li><a href="#">New Arrivals</a></li>--}}
                {{--<li><a href="contact.html">Contact</a></li>--}}
            </ul>
        </div>
    </nav>
</header>