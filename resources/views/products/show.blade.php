@extends('layouts.app')
@section('title', $product->title)

@section('content')
    <style>
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #7971ea;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 300;
            border-color: #7971ea;
        }

        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: 0rem;
            border-top-right-radius: 0rem;
        }
    </style>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $product->image_url }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="text-black">{{ $product->title }}</h2>
                    <p class="description"></p>
                    <p><strong class="text-primary h4 price">￥{{ $product->price }}</strong></p>
                    <div class="skus">
                        <label>选择</label>
                        <div class="btn-group" data-toggle="buttons">
                            @foreach($product->skus as $sku)
                                <label
                                        class="btn btn-default sku-btn"
                                        data-price="{{ $sku->price }}"
                                        data-stock="{{ $sku->stock }}"
                                        data-description="{{ $sku->description }}"
                                        data-toggle="tooltip"
                                        title="{{ $sku->description }}"
                                        data-placement="bottom">
                                    <input type="radio" name="skus" autocomplete="off" value="{{ $sku->id }}"> {{ $sku->title }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="stock mb-3">
                    </div>
                    <div class="mb-5">
                        <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" class="form-control text-center amount" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                        </div>

                    </div>
                    @if($favored)
                        <button class="btn btn-sm btn-dark btn-disfavor">取消收藏</button>
                    @else
                        <button class="btn btn-sm btn-primary btn-favor" style="background-color: #a29cf9;">❤收藏</button>
                    @endif

                    <button class="buy-now btn btn-sm btn-primary btn-add-to-cart">加入购物车</button>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-5">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="nav-item active">
                            <a class="nav-link active show" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab">商品详情</a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a class="nav-link" href="#product-reviews-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab">用户评价</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <div role="tabpanel" class="tab-pane active" id="product-detail-tab">

                            {!! $product->description !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <td>用户</td>
                                    <td>商品</td>
                                    <td>评分</td>
                                    <td>评价</td>
                                    <td>时间</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        <td>{{ $review->order->user->name }}</td>
                                        <td>{{ $review->productSku->title }}</td>
                                        <td>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                                        <td>{{ $review->review }}</td>
                                        <td>{{ $review->reviewed_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function () {

            $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});

            $('.sku-btn').click(function () {
                $('.price').text('￥' + $(this).data('price'));
                $('.stock').text('库存：' + $(this).data('stock') + '件');
                $('.description').text($(this).data('description'));
            });

            $('.sku-btn')[0].click();

            // 监听收藏按钮的点击事件
            $('.btn-favor').click(function () {
                axios.post('{{ route('products.favor', ['product' => $product->id]) }}')
                    .then(function () {
                        swal('操作成功', '', 'success')
                            .then(function () {  // 这里加了一个 then() 方法
                                location.reload();
                            });
                    }, function(error) {
                        if (error.response && error.response.status === 401) {
                            swal('请先登录', '', 'error');
                        }  else if (error.response && error.response.data.msg) {
                            swal(error.response.data.msg, '', 'error');
                        }  else {
                            swal('系统错误', '', 'error');
                        }
                    });
            });

            $('.btn-disfavor').click(function () {
                axios.delete('{{ route('products.disfavor', ['product' => $product->id]) }}')
                    .then(function () {
                        swal('操作成功', '', 'success')
                            .then(function () {
                                location.reload();
                            });
                    });
            });

            // 加入购物车按钮点击事件
            $('.btn-add-to-cart').click(function () {

                // 请求加入购物车接口
                axios.post('{{ route('cart.add') }}', {
                    sku_id: $('label.active input[name=skus]').val(),
                    amount: $('.amount').val(),
                })
                    .then(function () { // 请求成功执行此回调
                        swal('加入购物车成功', '', 'success')
                            .then(function() {
                                location.href = '{{ route('cart.index') }}';
                            });
                    }, function (error) { // 请求失败执行此回调
                        if (error.response.status === 401) {

                            // http 状态码为 401 代表用户未登陆
                            swal('请先登录', '', 'error');

                        } else if (error.response.status === 422) {

                            // http 状态码为 422 代表用户输入校验失败
                            var html = '<div>';
                            _.each(error.response.data.errors, function (errors) {
                                _.each(errors, function (error) {
                                    html += error+'<br>';
                                })
                            });
                            html += '</div>';
                            swal({content: $(html)[0], icon: 'error'})
                        } else {

                            // 其他情况应该是系统挂了
                            swal('系统错误', '', 'error');
                        }
                    })
            });

        });
    </script>
@endsection
