@extends('layouts.app')
@section('title', '商品列表')

@section('content')
    <style>
        .dropdown-menu a {
            cursor: pointer;
        }
    </style>
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12 order-2">

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="float-md-left mb-4"><h2 class="text-black h5">所有商品</h2></div>
                            <div class="d-flex">
                                <div class="dropdown mr-1 ml-md-auto">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle btn-order" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        排序方式
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <a class="dropdown-item" data-order="price_asc">价格从低到高</a>
                                        <a class="dropdown-item" data-order="price_desc">价格从高到低</a>
                                        <a class="dropdown-item" data-order="sold_count_desc">销量从高到低</a>
                                        <a class="dropdown-item" data-order="sold_count_asc">销量从低到高</a>
                                        <a class="dropdown-item" data-order="rating_desc">评价从高到低</a>
                                        <a class="dropdown-item" data-order="rating_asc">评价从低到高</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        @foreach($products as $product)
                            <div class="col-sm-6 col-lg-3 mb-3" data-aos="fade-up">
                                <div class="block-4 text-center border">
                                    <figure class="block-4-image">
                                        <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                            <img src="{{ $product->image_url }}" alt="Image placeholder" class="img-fluid">
                                        </a>
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><a href="{{ route('products.show', ['product' => $product->id]) }}">{{ $product->title }}</a></h3>
                                        <p class="text-primary font-weight-bold">￥{{ $product->price }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-md-12 text-center">
                            <div class="site-block-27">
                                {{ $products->appends($filters)->render() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="col-md-3 order-1 mb-5 mb-md-0">--}}
                    {{--<div class="border p-4 rounded mb-4">--}}
                        {{--<h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>--}}
                        {{--<ul class="list-unstyled mb-0">--}}
                            {{--<li class="mb-1"><a href="#" class="d-flex"><span>Men</span> <span class="text-black ml-auto">(2,220)</span></a></li>--}}
                            {{--<li class="mb-1"><a href="#" class="d-flex"><span>Women</span> <span class="text-black ml-auto">(2,550)</span></a></li>--}}
                            {{--<li class="mb-1"><a href="#" class="d-flex"><span>Children</span> <span class="text-black ml-auto">(2,124)</span></a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}

                    {{--<div class="border p-4 rounded mb-4">--}}
                        {{--<div class="mb-4">--}}
                            {{--<h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>--}}
                            {{--<div id="slider-range" class="border-primary"></div>--}}
                            {{--<input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />--}}
                        {{--</div>--}}

                        {{--<div class="mb-4">--}}
                            {{--<h3 class="mb-3 h6 text-uppercase text-black d-block">Size</h3>--}}
                            {{--<label for="s_sm" class="d-flex">--}}
                                {{--<input type="checkbox" id="s_sm" class="mr-2 mt-1"> <span class="text-black">Small (2,319)</span>--}}
                            {{--</label>--}}
                            {{--<label for="s_md" class="d-flex">--}}
                                {{--<input type="checkbox" id="s_md" class="mr-2 mt-1"> <span class="text-black">Medium (1,282)</span>--}}
                            {{--</label>--}}
                            {{--<label for="s_lg" class="d-flex">--}}
                                {{--<input type="checkbox" id="s_lg" class="mr-2 mt-1"> <span class="text-black">Large (1,392)</span>--}}
                            {{--</label>--}}
                        {{--</div>--}}

                        {{--<div class="mb-4">--}}
                            {{--<h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>--}}
                            {{--<a href="#" class="d-flex color-item align-items-center" >--}}
                                {{--<span class="bg-danger color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Red (2,429)</span>--}}
                            {{--</a>--}}
                            {{--<a href="#" class="d-flex color-item align-items-center" >--}}
                                {{--<span class="bg-success color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Green (2,298)</span>--}}
                            {{--</a>--}}
                            {{--<a href="#" class="d-flex color-item align-items-center" >--}}
                                {{--<span class="bg-info color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Blue (1,075)</span>--}}
                            {{--</a>--}}
                            {{--<a href="#" class="d-flex color-item align-items-center" >--}}
                                {{--<span class="bg-primary color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Purple (1,075)</span>--}}
                            {{--</a>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="site-section site-blocks-2">
                        <div class="row justify-content-center text-center mb-5">
                            <div class="col-md-7 site-section-heading pt-4">
                                <h2>Categories</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                <a class="block-2-item" href="#">
                                    <figure class="image">
                                        <img src="images/women.jpg" alt="" class="img-fluid">
                                    </figure>
                                    <div class="text">
                                        <span class="text-uppercase">Collections</span>
                                        <h3>Women</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                                <a class="block-2-item" href="#">
                                    <figure class="image">
                                        <img src="images/children.jpg" alt="" class="img-fluid">
                                    </figure>
                                    <div class="text">
                                        <span class="text-uppercase">Collections</span>
                                        <h3>Children</h3>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                                <a class="block-2-item" href="#">
                                    <figure class="image">
                                        <img src="images/men.jpg" alt="" class="img-fluid">
                                    </figure>
                                    <div class="text">
                                        <span class="text-uppercase">Collections</span>
                                        <h3>Men</h3>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        var filters = {!! json_encode($filters) !!};
        var orderList = {
            'price_asc' : '价格从低到高',
            'price_desc' : '价格从高到低',
            'sold_count_desc' : '销量从高到低',
            'sold_count_asc' : '销量从低到高',
            'rating_desc' : '评价从高到低',
            'rating_asc' : '评价从低到高',
        };
        $(document).ready(function () {
            $('.search-form input[name=search]').val(filters.search);
            // $('.search-form select[name=order]').val(filters.order);
            $('.btn-order').text(orderList[filters.order])

            $('.search-form select[name=order]').on('change', function() {
                $('.search-form').submit();
            });

            $('.dropdown-menu a').click(function() {
                if (getQueryVariable('order')) {
                    replaceParamVal('order', $(this).data('order'))
                } else {
                    addUrlPara('order', $(this).data('order'))
                }
            });
        })

        function addUrlPara(name, value) {
            var currentUrl = window.location.href.split('#')[0];
            if (/\?/g.test(currentUrl)) {
                if (/name=[-\w]{4,25}/g.test(currentUrl)) {
                    currentUrl = currentUrl.replace(/name=[-\w]{4,25}/g, name + "=" + value);
                } else {
                    currentUrl += "&" + name + "=" + value;
                }
            } else {
                currentUrl += "?" + name + "=" + value;
            }
            if (window.location.href.split('#')[1]) {
                window.location.href = currentUrl + '#' + window.location.href.split('#')[1];
            } else {
                window.location.href = currentUrl;
            }
        }

        function replaceParamVal(paramName,replaceWith) {
            var oUrl = this.location.href.toString();
            var re=eval('/('+ paramName+'=)([^&]*)/gi');
            var nUrl = oUrl.replace(re,paramName+'='+replaceWith);
            this.location = nUrl;
        }

        function getQueryVariable(variable)
        {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                if(pair[0] == variable){return pair[1];}
            }
            return(false);
        }
    </script>
@endsection