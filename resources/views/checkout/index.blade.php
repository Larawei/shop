@extends('layouts.app')

@section('title', '购物车')

@section('content')
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    <div class="site-blocks-table">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="display: none;"><input type="checkbox" id="select-all"></th>
                                <th class="product-thumbnail">图片</th>
                                <th class="product-name">商品信息</th>
                                <th class="product-price">单价</th>
                                <th class="product-quantity">数量</th>
                                <th class="product-total">总价</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cartItems as $item)
                                <tr data-id="{{ $item->productSku->id }}">
                                    <td style="display: none;">
                                        <input type="checkbox" name="select" value="{{ $item->productSku->id }}" {{ $item->productSku->product->on_sale ? 'checked' : 'disabled' }}>
                                    </td>
                                    <td class="product-thumbnail">
                                        <img src="{{ $item->productSku->product->image_url }}" alt="Image" class="img-fluid">
                                    </td>
                                    <td class="product-name">
                                        <h2 class="h5 text-black">{{ $item->productSku->product->title }} <br> <small>{{ $item->productSku->title }}</small></h2>
                                    </td>
                                    <td>￥{{ $item->productSku->price }}</td>
                                    <td>
                                        <div class="input-group mb-3" style="max-width: 120px; margin: auto;">
                                            <input disabled type="text" class="form-control text-center amount" @if(!$item->productSku->product->on_sale) disabled @endif name="amount" value="{{ $item->amount }}" >
                                        </div>

                                    </td>
                                    <td>￥{{ $item->productSku->price * $item->amount }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">收货地址</label>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <select class="form-control" name="address" id="address">
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}">{{ $address->full_address }} {{ $address->contact_name }} {{ $address->contact_phone }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">备注:</label>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <textarea id="remark" name="remark" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">优惠码</label>
                            <p>输入您的优惠码</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" placeholder="Code">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm">使用</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">订单总价</h3>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <span class="text-black">总价</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">￥{{ $total_price }}</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-lg py-3 btn-block btn-create-order" type="button">创建订单</button>
                                </div>
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
        $(document).ready(function () {
            // 监听 移除 按钮的点击事件
            $('.btn-remove').click(function () {
                // $(this) 可以获取到当前点击的 移除 按钮的 jQuery 对象
                // closest() 方法可以获取到匹配选择器的第一个祖先元素，在这里就是当前点击的 移除 按钮之上的 <tr> 标签
                // data('id') 方法可以获取到我们之前设置的 data-id 属性的值，也就是对应的 SKU id
                var id = $(this).closest('tr').data('id');
                swal({
                    title: "确认要将该商品移除？",
                    icon: "warning",
                    buttons: ['取消', '确定'],
                    dangerMode: true,
                })
                    .then(function(willDelete) {
                        // 用户点击 确定 按钮，willDelete 的值就会是 true，否则为 false
                        if (!willDelete) {
                            return;
                        }
                        axios.delete('/cart/' + id)
                            .then(function () {
                                location.reload();
                            })
                    });
            });

            // 监听 全选/取消全选 单选框的变更事件
            $('#select-all').change(function() {
                // 获取单选框的选中状态
                // prop() 方法可以知道标签中是否包含某个属性，当单选框被勾选时，对应的标签就会新增一个 checked 的属性
                var checked = $(this).prop('checked');
                // 获取所有 name=select 并且不带有 disabled 属性的勾选框
                // 对于已经下架的商品我们不希望对应的勾选框会被选中，因此我们需要加上 :not([disabled]) 这个条件
                $('input[name=select][type=checkbox]:not([disabled])').each(function() {
                    // 将其勾选状态设为与目标单选框一致
                    $(this).prop('checked', checked);
                });
            });

            // 监听创建订单按钮的点击事件
            $('.btn-create-order').click(function () {
                // 构建请求参数，将用户选择的地址的 id 和备注内容写入请求参数
                var req = {
                    address_id: $('#address').val(),
                    items: [],
                    remark: $('#remark').val(),
                };
                // 遍历 <table> 标签内所有带有 data-id 属性的 <tr> 标签，也就是每一个购物车中的商品 SKU
                $('table tr[data-id]').each(function () {
                    // 获取当前行的单选框
                    var $checkbox = $(this).find('input[name=select][type=checkbox]');
                    // 如果单选框被禁用或者没有被选中则跳过
                    if ($checkbox.prop('disabled') || !$checkbox.prop('checked')) {
                        return;
                    }
                    // 获取当前行中数量输入框
                    var $input = $(this).find('input[name=amount]');
                    // 如果用户将数量设为 0 或者不是一个数字，则也跳过
                    if ($input.val() == 0 || isNaN($input.val())) {
                        return;
                    }
                    // 把 SKU id 和数量存入请求参数数组中
                    req.items.push({
                        sku_id: $(this).data('id'),
                        amount: $input.val(),
                    })
                });
                axios.post('{{ route('orders.store') }}', req)
                    .then(function (response) {
                        swal('订单提交成功', '', 'success')
                            .then(() => {
                                location.href = '/orders/' + response.data.id;
                            });
                    }, function (error) {
                        if (error.response.status === 422) {
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
                    });
            });

        });
    </script>
@endsection