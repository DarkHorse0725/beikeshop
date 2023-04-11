@extends('admin::layouts.master')

@section('title', __('admin/setting.index'))

@section('page-title-right')
  <button type="button" class="btn btn-lg btn-primary submit-form" form="app">{{ __('common.save') }}</button>
@endsection

@section('content')
  <div id="plugins-app-form" class="card h-min-600">
    <div class="card-body">
      <form action="{{ admin_route('settings.store') }}" class="needs-validation" novalidate method="POST" id="app" v-cloak>
        @csrf
        @if (session('success'))
          <x-admin-alert type="success" msg="{{ session('success') }}" class="mt-4"/>
        @endif
        <ul class="nav nav-tabs nav-bordered mb-5" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-general">{{ __('admin/setting.basic_settings') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-store">{{ __('admin/setting.store_settings') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-checkout">{{ __('admin/setting.checkout_settings') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-image">{{ __('admin/setting.picture_settings') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-express-company">{{ __('order.express_company') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-multi-filter">{{ __('admin/setting.multi_filter') }}</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-mail">{{ __('admin/setting.mail_settings') }}</a>
          </li>
          @hook('admin.setting.nav.after')
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-general">
            @hook('admin.setting.general.before')
            <x-admin-form-input name="meta_title" title="{{ __('admin/setting.meta_title') }}" value="{{ old('meta_title', system_setting('base.meta_title', '')) }}" />
            <x-admin-form-textarea name="meta_description" title="{{ __('admin/setting.meta_description') }}" value="{{ old('meta_description', system_setting('base.meta_description', '')) }}" />
            <x-admin-form-textarea name="meta_keywords" title="{{ __('admin/setting.meta_keywords') }}" value="{{ old('meta_keywords', system_setting('base.meta_keywords', '')) }}" />
            <x-admin-form-input name="telephone" title="{{ __('admin/setting.telephone') }}" value="{{ old('telephone', system_setting('base.telephone', '')) }}" />
            <x-admin-form-input name="email" title="{{ __('admin/setting.email') }}" value="{{ old('email', system_setting('base.email', '')) }}" />
            @hook('admin.setting.general.after')
          </div>

          <div class="tab-pane fade" id="tab-store">
            @hook('admin.setting.store.before')
            <x-admin::form.row title="{{ __('admin/setting.default_address') }}">
              <div class="d-lg-flex">
                <div>
                  <select class="form-select wp-200 me-3" name="country_id" aria-label="Default select example">
                    @foreach ($countries as $country)
                      <option
                        value="{{ $country->id }}"
                        {{ $country->id == system_setting('base.country_id', '1') ? 'selected': '' }}>
                        {{ $country->name }}
                      </option>
                    @endforeach
                  </select>
                  <div class="help-text font-size-12 lh-base">{{ __('admin/setting.default_country_set') }}</div>
                </div>
                <div>
                  <select class="form-select wp-200 zones-select" name="zone_id" aria-label="Default select example"></select>
                  <div class="help-text font-size-12 lh-base">{{ __('admin/setting.default_zone_set') }}</div>
                </div>
              </div>
            </x-admin::form.row>

            <x-admin-form-select title="{{ __('admin/setting.default_language') }}" name="locale" :value="old('locale', system_setting('base.locale', 'zh_cn'))" :options="$admin_languages" key="code" label="name">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.default_language') }}</div>
            </x-admin-form-select>

            <x-admin-form-select title="{{ __('admin/setting.default_currency') }}" name="currency" :value="old('currency', system_setting('base.currency', 'USD'))" :options="$currencies->toArray()" key="code" label="name">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.default_currency') }}</div>
            </x-admin-form-select>

              <x-admin-form-select title="{{ __('admin/setting.default_customer_group') }}" name="default_customer_group_id" :value="old('locale', system_setting('base.default_customer_group_id', ''))" :options="$customer_groups" key="id" label="name">
                  <div class="help-text font-size-12 lh-base">{{ __('admin/setting.default_customer_group') }}</div>
              </x-admin-form-select>

            <x-admin-form-input name="admin_name" title="{{ __('admin/setting.admin_name') }}" required value="{{ old('admin_name', system_setting('base.admin_name', 'admin')) }}">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.admin_name_info') }}</div>
            </x-admin-form-input>

            <x-admin-form-input name="product_per_page" title="{{ __('admin/setting.product_per_page') }}" required value="{{ old('product_per_page', system_setting('base.product_per_page', 20)) }}">
            </x-admin-form-input>

            <x-admin-form-textarea name="head_code" title="{{ __('admin/setting.head_code') }}" value="{!! old('head_code', system_setting('base.head_code', '')) !!}">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.head_code_info') }}</div>
            </x-admin-form-textarea>

            @hook('admin.setting.store.after')

          </div>

          <div class="tab-pane fade" id="tab-image">

            @hook('admin.setting.image.before')

            <x-admin-form-image name="logo" title="logo" :value="old('logo', system_setting('base.logo', ''))">
              <div class="help-text font-size-12 lh-base">{{ __('common.recommend_size') }} 380*100</div>
            </x-admin-form-image>

            <x-admin-form-image name="favicon" title="favicon" :value="old('favicon', system_setting('base.favicon', ''))">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.favicon_info') }}</div>
            </x-admin-form-image>

            <x-admin-form-image name="placeholder" title="{{ __('admin/setting.placeholder_image') }}" :value="old('placeholder', system_setting('base.placeholder', ''))">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.placeholder_image_info') }}</div>
            </x-admin-form-image>

            @hook('admin.setting.image.after')
          </div>

          <div class="tab-pane fade" id="tab-multi-filter">
            <x-admin::form.row :title="__('admin/setting.filter_attribute')">
              <div class="module-edit-group wp-600">
                <div class="autocomplete-group-wrapper">
                  <el-autocomplete
                    class="inline-input"
                    v-model="multi_filter.keyword"
                    value-key="name"
                    size="small"
                    :fetch-suggestions="(keyword, cb) => {attributesQuerySearch(keyword, cb, 'products')}"
                    placeholder="{{ __('admin/builder.modules_keywords_search') }}"
                    @select="(e) => {handleSelect(e, 'product_attributes')}"
                  ></el-autocomplete>

                  <div class="item-group-wrapper" v-loading="multi_filter.loading">
                    <template v-if="multi_filter.filters.attribute.length">
                      <div v-for="(item, index) in multi_filter.filters.attribute" :key="index" class="item">
                        <div>
                          <i class="el-icon-s-unfold"></i>
                          <span>@{{ item.name }}</span>
                        </div>
                        <i class="el-icon-delete right" @click="attributesRemoveProduct(index)"></i>
                        <input type="text" :name="'multi_filter[attribute]['+ index +']'" v-model="item.id" class="form-control d-none">
                      </div>
                    </template>
                    <template v-else>
                      {{ __('admin/setting.please_select') }}
                      <input type="text" name="multi_filter" value="" class="form-control d-none">
                    </template>
                  </div>
                  <div class="help-text font-size-12 lh-base">{{ __('admin/setting.multi_filter_helper') }}</div>
                </div>
              </div>
            </x-admin::form.row>
          </div>

          <div class="tab-pane fade" id="tab-express-company">
            @hook('admin.setting.express.before')
            <x-admin::form.row title="{{ __('order.express_company') }}">
              <table class="table table-bordered w-max-600">
                <thead>
                  <th>{{ __('order.express_company') }}</th>
                  <th>Code</th>
                  <th></th>
                </thead>
                <tbody>
                  <tr v-for="item, index in express_company" :key="index">
                    <td>
                      <input required placeholder="{{ __('order.express_company') }}" type="text" :name="'express_company['+ index +'][name]'" v-model="item.name" class="form-control">
                      <div class="invalid-feedback">{{ __('common.error_required', ['name' => __('order.express_company')]) }}</div>
                    </td>
                    <td>
                      <input required placeholder="{{ __('admin/setting.express_code_help') }}" type="text" :name="'express_company['+ index +'][code]'" v-model="item.code" class="form-control">
                      <div class="invalid-feedback">{{ __('common.error_required', ['name' => 'Code']) }}</div>
                    </td>
                    <td><i @click="express_company.splice(index, 1)" class="bi bi-x-circle fs-4 text-danger cursor-pointer"></i></td>
                  </tr>
                  <tr>
                    <td colspan="2"><input v-if="!express_company.length" name="express_company" class="d-none"></td>
                    <td><i class="bi bi-plus-circle cursor-pointer fs-4" @click="addCompany"></i></td>
                  </tr>
                </tbody>
              </table>
            </x-admin::form.row>
            @hook('admin.setting.express.after')
          </div>

          <div class="tab-pane fade" id="tab-mail">

            @hook('admin.setting.mail.before')

            <x-admin-form-switch name="use_queue" title="{{ __('admin/setting.use_queue') }}" value="{{ old('use_queue', system_setting('base.use_queue', '0')) }}">
              {{-- <div class="help-text font-size-12 lh-base">{{ __('admin/setting.enable_tax_info') }}</div> --}}
            </x-admin-form-switch>
            <x-admin::form.row title="{{ __('admin/setting.mail_engine') }}">
              <select name="mail_engine" v-model="mail_engine" class="form-select wp-200 me-3">
                <option :value="item.code" v-for="item, index in source.mailEngines" :key="index">@{{ item.name }}</option>
              </select>
              <div v-if="mail_engine == 'log'" class="help-text font-size-12 lh-base">{{ __('admin/setting.mail_log') }}</div>
            </x-admin::form.row>

            <div v-if="mail_engine == 'smtp'">
              <x-admin-form-input name="smtp[host]" required title="{{ __('admin/setting.smtp_host') }}" value="{{ old('host', system_setting('base.smtp.host', '')) }}">
              </x-admin-form-input>
              <x-admin-form-input name="smtp[username]" required title="{{ __('admin/setting.smtp_username') }}" value="{{ old('username', system_setting('base.smtp.username', '')) }}">
              </x-admin-form-input>
              <x-admin-form-input name="smtp[password]" required title="{{ __('admin/setting.smtp_password') }}" value="{{ old('password', system_setting('base.smtp.password', '')) }}">
                <div class="help-text font-size-12 lh-base">{{ __('admin/setting.smtp_password_info') }}</div>
              </x-admin-form-input>
              <x-admin-form-input name="smtp[encryption]" required title="{{ __('admin/setting.smtp_encryption') }}" value="{{ old('encryption', system_setting('base.smtp.encryption', 'TLS')) }}">
                <div class="help-text font-size-12 lh-base">{{ __('admin/setting.smtp_encryption_info') }}</div>
              </x-admin-form-input>
              <x-admin-form-input name="smtp[port]" required title="{{ __('admin/setting.smtp_port') }}" value="{{ old('port', system_setting('base.smtp.port', '465')) }}">
              </x-admin-form-input>
              <x-admin-form-input name="smtp[timeout]" required title="{{ __('admin/setting.smtp_timeout') }}" value="{{ old('timeout', system_setting('base.smtp.timeout', '5')) }}">
              </x-admin-form-input>
            </div>

            <div v-if="mail_engine == 'sendmail'">
              <x-admin-form-input name="sendmail[path]" :placeholder="222" required title="{{ __('admin/setting.sendmail_path') }}" value="{{ old('path', system_setting('base.sendmail.path', '')) }}">
                <div class="help-text font-size-12 lh-base">系统 sendmail 执行路径, 一般为 /usr/sbin/sendmail -bs</div>
              </x-admin-form-input>
            </div>

            <div v-if="mail_engine == 'mailgun'">
              <x-admin-form-input name="mailgun[domain]" required title="{{ __('admin/setting.mailgun_domain') }}" value="{{ old('domain', system_setting('base.mailgun.domain', '')) }}">
              </x-admin-form-input>
              <x-admin-form-input name="mailgun[secret]" required title="{{ __('admin/setting.mailgun_secret') }}" value="{{ old('secret', system_setting('base.mailgun.secret', '')) }}">
              </x-admin-form-input>
              <x-admin-form-input name="mailgun[endpoint]" required title="{{ __('admin/setting.mailgun_endpoint') }}" value="{{ old('endpoint', system_setting('base.mailgun.endpoint', '')) }}">
              </x-admin-form-input>
            </div>

            @hook('admin.setting.mail.after')

          </div>

          <div class="tab-pane fade" id="tab-checkout">
            <x-admin-form-switch name="guest_checkout" title="{{ __('admin/setting.guest_checkout') }}" value="{{ old('guest_checkout', system_setting('base.guest_checkout', '1')) }}">
            </x-admin-form-switch>

            <x-admin-form-switch name="tax" title="{{ __('admin/setting.enable_tax') }}" value="{{ old('tax', system_setting('base.tax', '0')) }}">
              <div class="help-text font-size-12 lh-base">{{ __('admin/setting.enable_tax_info') }}</div>
            </x-admin-form-switch>

            <x-admin-form-select title="{{ __('admin/setting.tax_address') }}" name="tax_address" :value="old('tax_address', system_setting('base.tax_address', 'shipping'))" :options="$tax_address">
            </x-admin-form-select>

            <x-admin-form-input name="rate_api_key" title="{{ __('admin/setting.rate_api_key') }}" value="{{ old('rate_api_key', system_setting('base.rate_api_key', '')) }}">
              <div class="help-text font-size-12 lh-base">
                <a class="text-secondary" href="https://www.exchangerate-api.com/" target="_blank">www.exchangerate-api.com</a>
              </div>
            </x-admin-form-input>
          </div>

          @hook('admin.setting.after')
        </div>

        <x-admin::form.row title="">
          <button type="submit" class="btn btn-primary d-none mt-4">{{ __('common.submit') }}</button>
        </x-admin::form.row>
      </form>
    </div>
  </div>
@endsection

@push('footer')
  <script>
    @if (session('success'))
      layer.msg('{{ session('success') }}')
    @endif

    const country_id = {{ system_setting('base.country_id', '1') }};
    const zone_id = {{ system_setting('base.zone_id', '1') ?: 1 }};

    // 获取省份
    const getZones = (country_id) => {
      $http.get(`countries/${country_id}/zones`, null, {hload: true}).then((res) => {
        if (res.data.zones.length > 0) {
          $('select[name="zone_id"]').html('');
          res.data.zones.forEach((zone) => {
            $('select[name="zone_id"]').append(`
              <option ${zone_id == zone.id ? 'selected' : ''} value="${zone.id}">${zone.name}</option>
            `);
          });
        } else {
          $('select[name="zone_id"]').html(`
            <option value="">请选择</option>
          `);
        }
      })
    }

    $(function() {
      getZones(country_id);

      $('select[name="country_id"]').on('change', function () {
        getZones($(this).val());
      });
    });
  </script>

  <script>
    new Vue({
      el: '#app',
      data: {
        multi_filter: {
          keyword: '',
          filters: @json($multi_filter ?? null),
          loading: null,
        },

        mail_engine: @json(old('mail_engine', system_setting('base.mail_engine', ''))),
        express_company: @json(old('express_company', system_setting('base.express_company', []))),

        source: {
          mailEngines: [
            {name: '{{ __('admin/builder.text_no') }}', code: ''},
            {name: 'SMTP', code: 'smtp'},
            {name: 'Sendmail', code: 'sendmail'},
            {name: 'Mailgun', code: 'mailgun'},
            {name: 'Log', code: 'log'},
          ]
        },
      },
      created() {
        const multi_filter = @json($multi_filter ?? null);
        if (multi_filter) {
          this.multi_filter.filters = multi_filter;
        } else {
          this.multi_filter.filters = {
            attribute: [],
          }
        }
      },
      methods: {
        addCompany() {
          if (typeof this.express_company == 'string') {
            this.express_company = [];
          }

          this.express_company.push({name: '', code: ''})
        },

        attributesQuerySearch(keyword, cb, url) {
          $http.get('attributes/autocomplete?name=' + encodeURIComponent(keyword), null, {hload:true}).then((res) => {
            cb(res.data);
          })
        },

        attributesRemoveProduct(index) {
          this.multi_filter.filters.attribute.splice(index, 1);
        },

        handleSelect(item, key) {
          if (key == 'product_attributes') {
            if (!this.multi_filter.filters.attribute.find(v => v.id * 1 == item.id * 1)) {
              this.multi_filter.filters.attribute.push(item);
            } else {
              layer.msg('{{ __('common.no_repeat') }}', () => {})
            }

            this.multi_filter.keyword = ""
          }
        },
      }
    });

    const tab = bk.getQueryString('tab');
    if (tab) {
      $(`a[href="#${bk.getQueryString('tab')}"]`)[0].click()
    }
  </script>
@endpush



