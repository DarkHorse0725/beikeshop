@extends('admin::layouts.master')

@section('title', '订单详情')

@section('content')
  <div class="card mb-4">
    <div class="card-header"><h6 class="card-title">订单详情</h6></div>
    <div class="card-body">
      <div class="row">
        <div class="col-4">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>订单编号：</td>
                <td>{{ $order->number }}</td>
              </tr>
              <tr>
                <td>付款方式：</td>
                <td>{{ $order->payment_method_name }}</td>
              </tr>
              <tr>
                <td>总计：</td>
                <td>{{ $order->total }}</td>
              </tr>
              <tr>
                <td>状态：</td>
                <td>{{ $order->status }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-4">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <td>客户姓名：</td>
                <td>{{ $order->customer_name }}</td>
              </tr>
              <tr>
                <td>生成日期：</td>
                <td>{{ $order->created_at }}</td>
              </tr>
              <tr>
                <td>修改日期：</td>
                <td>{{ $order->updated_at }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header"><h6 class="card-title">状态</h6></div>
    <div class="card-body" id="app">
      <el-form ref="form" :model="form" :rules="rules" label-width="100px">
        <el-form-item label="当前状态">
          待支付
        </el-form-item>
        <el-form-item label="修改状态" prop="status">
          <el-select size="small" v-model="form.status" placeholder="请选择">
            <el-option
              v-for="item in statuses"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="通知客户">
          {{-- <el-checkbox v-model="form.notify"></el-checkbox> --}}
          <el-switch v-model="form.notify">
          </el-switch>
        </el-form-item>
        <el-form-item label="备注信息">
          <textarea class="form-control w-max-500" v-model="form.comment"></textarea>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('form')">更新状态</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header"><h6 class="card-title">商品信息</h6></div>
    <div class="card-body">
      <table class="table ">
        <thead class="">
          <tr>
            <th>ID</th>
            <th>商品</th>
            <th>价格</th>
            <th class="text-end">数量</th>
            <th class="text-end">sku</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($order->orderProducts as $product)
          <tr>
            <td>{{ $product->id }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="wh-60 me-2"><img src="{{ $product->image }}" class="img-fluid"></div>{{ $product->name }}
              </div>
            </td>
            <td>{{ $product->price }}</td>
            <td class="text-end">{{ $product->quantity }}</td>
            <td class="text-end">{{ $product->product_sku }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          @foreach ($order->orderTotals as $order)
            <tr>
              {{-- <td colspan="4" class="text-end">{{ $order->title }}： <span class="fw-bold">{{ $order->value }}</span></td> --}}
              <td colspan="4" class="text-end">{{ $order->title }}</td>
              <td class="text-end"><span class="fw-bold">{{ $order->value }}</span></td>
            </tr>
          @endforeach
        </tfoot>
      </table>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header"><h6 class="card-title">订单操作日志</h6></div>
    <div class="card-body">

    </div>
  </div>
@endsection

@push('footer')
  <script>
    new Vue({
      el: '#app',

      data: {
        statuses: [{"value":"pending","label":"待处理"},{"value":"rejected","label":"已拒绝"},{"value":"approved","label":"已批准（待顾客寄回商品）"},{"value":"shipped","label":"已发货（寄回商品）"},{"value":"completed","label":"已完成"}],
        form: {
          status: "",
          notify: false,
          comment: '',
        },

        rules: {
          status: [{required: true, message: '请输入用户名', trigger: 'blur'}, ],
        }
      },

      beforeMount() {
        // let statuses = @json($statuses ?? []);
        // this.statuses = Object.keys(statuses).map(key => {
        //   return {
        //     value: key,
        //     label: statuses[key]
        //   }
        // });
      },

      methods: {
        submitForm(form) {
          this.$refs[form].validate((valid) => {
            if (!valid) {
              layer.msg('请检查表单是否填写正确',()=>{});
              return;
            }

            $http.put(`/orders/{{ $order->id }}/status`,this.form).then((res) => {
              console.log(res)
              layer.msg(res.message);
            })
          });
        }
      }
    })
  </script>
@endpush

