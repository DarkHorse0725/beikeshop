@extends('layout.master')

@section('body-class', 'page-account-address')

@push('header')
  <script src="{{ asset('vendor/vue/2.7/vue' . (!config('app.debug') ? '.min' : '') . '.js') }}"></script>
  <script src="{{ asset('vendor/element-ui/2.15.6/js.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/element-ui/2.15.6/css.css') }}">
@endpush

@section('content')
  <x-shop-breadcrumb type="static" value="account.addresses.index" />

  <div class="container" id="address-app">
    <div class="row">
      <x-shop-sidebar />

      <div class="col-12 col-md-9">
        <div class="card h-min-600">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">{{ __('shop/account.addresses.index') }}</h5>
          </div>
          <div class="card-body h-600">
            <button v-if="addresses.length" class="btn btn-dark mb-3" @click="editAddress"><i class="bi bi-plus-square-dotted me-1"></i>
              {{ __('shop/account.addresses.add_address') }}</button>
            <div class="addresses-wrap" v-cloak>
              <div class="row" v-if="addresses.length">
                <div class="col-6" v-for="address, index in addresses" :key="index">
                  <div class="item">
                    <div class="name-wrap">
                      <span class="name">@{{ address.name }}</span>
                      <span class="phone">@{{ address.phone }}</span>
                    </div>
                    <div class="zipcode" style="min-height: 20px">@{{ address.zipcode }}</div>
                    <div class="address-info">@{{ address.country }} @{{ address.zone }} @{{ address.city }}
                      @{{ address.address_1 }}</div>
                    <div class="address-bottom">
                      <div><span class="badge bg-success"
                          v-if="address.default">{{ __('shop/account.addresses.default_address') }}</span></div>
                      <div>
                        <a class="me-2" @click.stop="deleteAddress(index)">{{ __('shop/account.addresses.delete') }}</a>
                        <a href="javascript:void(0)" @click.stop="editAddress(index)">{{ __('shop/account.addresses.edit') }}</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else class="text-center">
                <x-shop-no-data />
                <button class="btn btn-dark mb-3" @click="editAddress"><i class="bi bi-plus-square-dotted me-1"></i>
                  {{ __('shop/account.addresses.add_address') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <address-dialog ref="address-dialog" @change="onAddressDialogChange"></address-dialog>
  </div>
@endsection

@push('add-scripts')
  @include('shared.address-form')
  <script>
    new Vue({
      el: '#address-app',

      data: {
        editIndex: null,
        addresses: @json($addresses ?? []),
      },

      // 实例被挂载后调用
      mounted() {},

      methods: {
        editAddress(index) {
          let addresses = null

          if (typeof index == 'number') {
            this.editIndex = index;

            addresses = JSON.parse(JSON.stringify(this.addresses[index]))
          }

          this.$refs['address-dialog'].editAddress(addresses)
        },

        deleteAddress(index) {
          this.$confirm('{{ __('shop/account.addresses.confirm_delete') }}',
            '{{ __('shop/account.addresses.hint') }}', {
              confirmButtonText: '{{ __('common.confirm') }}',
              cancelButtonText: '{{ __('common.cancel') }}',
              type: 'warning'
            }).then(() => {
            $http.delete('/account/addresses/' + this.addresses[index].id).then((res) => {
              this.$message.success(res.message);
              this.addresses.splice(index, 1)
            })
          }).catch(() => {})
        },

        onAddressDialogChange(form) {
          const type = form.id ? 'put' : 'post';
          const url = `/account/addresses${type == 'put' ? '/' + form.id : ''}`;

          $http[type](url, form).then((res) => {
            if (res.data.default) {
              this.addresses.map(e => e.default = false)
            }

            if (this.addresses.find(e => e.id == res.data.id)) {
              this.addresses[this.editIndex] = res.data
            } else {
              this.addresses.push(res.data)
            }
            this.editIndex = null;
            this.$forceUpdate()
            this.$refs['address-dialog'].closeAddressDialog()
          })
        },
      }
    })
  </script>
@endpush
