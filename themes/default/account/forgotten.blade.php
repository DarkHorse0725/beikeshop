@extends('layout.master')

@section('body-class', 'page-forgotten')

@push('header')
  <script src="{{ asset('vendor/vue/2.7/vue' . (!config('app.debug') ? '.min' : '') . '.js') }}"></script>
  <script src="{{ asset('vendor/element-ui/2.15.6/js.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/element-ui/2.15.6/css.css') }}">
@endpush


@section('content')
  <x-shop-breadcrumb type="static" value="forgotten.index" />

  <div class="container" id="page-forgotten" v-cloak>
    <div class="row my-5 justify-content-md-center">
      <div class="col-lg-5 col-xxl-4">
        <div class="card">
          <el-form ref="form" :model="form" :rules="rules">
            <div class="card-body p-0">
              <h4 class="fw-bold">{{ __('shop/forgotten.follow_prompt') }}</h4>
              <p class="text-muted" v-if="!isCode">{{ __('shop/forgotten.email_forCode') }}</p>
              <p class="text-muted" v-else>{{ __('shop/forgotten.enter_password') }}</p>

              <el-form-item label="{{ __('shop/forgotten.email') }}" prop="email" v-if="!isCode">
                <el-input v-model="form.email" placeholder="{{ __('shop/forgotten.email_address') }}"></el-input>
              </el-form-item>

              <el-form-item label="{{ __('shop/forgotten.verification_code') }}" prop="code" class="mb-3" v-if="isCode">
                <el-input  v-model="form.code" placeholder="{{ __('shop/forgotten.verification_code') }}"></el-input>
              </el-form-item>

              <el-form-item label="{{ __('shop/forgotten.password') }}" prop="password" class="mb-3" v-if="isCode">
                <el-input type="password" v-model="form.password" placeholder="{{ __('shop/forgotten.password') }}"></el-input>
              </el-form-item>

              <el-form-item label="{{ __('shop/forgotten.confirm_password') }}" prop="password_confirmation" v-if="isCode">
                <el-input type="password" v-model="form.password_confirmation" placeholder="{{ __('shop/forgotten.confirm_password') }}"></el-input>
              </el-form-item>

              <div class="mt-5 mb-3 d-flex justify-content-between">
                <button type="button" @click="submitForm('form')" class="btn w-50 btn-dark">
                  {{-- @{{ !isCode ? '发送验证码'  :  '提交'  }} --}}
                  <template v-if="!isCode">{{ __('shop/forgotten.send_code') }}</template>
                  <template v-else>{{ __('common.submit') }}</template>
                </button>
              </div>
              <a href="javascript:void(0)" v-if="isCode" @click="isCode = false" class="text-muted">{{ __('shop/forgotten.to_back') }}</a>
            </div>
          </el-form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-scripts')
  <script>
    var validatePass = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('{{ __('shop/forgotten.enter_password') }}'));
      } else {
        if (value !== '') {
          app.$refs.form.validateField('password_confirmation');
        }
        callback();
      }
    };

    var validatePass2 = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('{{ __('shop/forgotten.please_confirm') }}'));
      } else if (value !== app.form.password) {
        callback(new Error('{{ __('shop/forgotten.password_err') }}'));
      } else {
        callback();
      }
    };

    let app = new Vue({
      el: '#page-forgotten',

      data: {
        form: {
          email: bk.getQueryString('email', ''),
          code: bk.getQueryString('code', ''),
          password: '',
          password_confirmation: '',
        },

        isCode: !!bk.getQueryString('code'),

        rules: {
          email: [
            {required: true, message: '{{ __('shop/forgotten.enter_email') }}', trigger: 'blur'},
            {type: 'email', message: '{{ __('shop/forgotten.email_err') }}', trigger: 'blur'},
          ],
          code: [
            {required: true, message: '{{ __('shop/forgotten.enter_code') }}', trigger: 'blur'}
          ],
          password: [
            {required: true, validator: validatePass, trigger: 'blur'}
          ],
          password_confirmation: [
            {required: true, validator: validatePass2, trigger: 'blur'}
          ]
        },
      },

      mounted () {
      },

      methods: {
        submitForm(form) {
          let _data = this.form, url = 'forgotten/password'

          if (!this.isCode) {
            url = 'forgotten/send_code'
          }

          this.$refs[form].validate((valid) => {
            if (!valid) {
              return;
            }

            $http.post(url, this.form).then((res) => {
              if (this.isCode) {
                layer.msg(res.message)
              } else {
                this.$alert(res.message, '{{ __('common.text_hint') }}');
              }

              this.$refs[form].clearValidate();

              if (this.isCode) {
                location = "{{ shop_route('login.index') }}"
              }
              this.isCode = true
            })
          });
        }
      }
    })
  </script>
@endpush