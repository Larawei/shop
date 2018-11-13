@extends('layouts.app')
@section('title', '我的收藏')

@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{ route('root') }}">首页</a> <span class="mx-2 mb-0">/</span><strong class="text-black">收藏列表</strong></div>
            </div>
        </div>
    </div>
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12 order-2">
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
                                {{ $products->render() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection