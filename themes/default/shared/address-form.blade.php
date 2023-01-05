<template id="address-dialog">
  <div>
    <el-dialog custom-class="mobileWidth" title="{{ __('address.index') }}" :visible.sync="editShow" @close="closeAddressDialog('addressForm')" :close-on-click-modal="false">
      <el-form ref="addressForm" :rules="rules" :model="form" label-width="100px">
        <el-form-item label="{{ __('address.name') }}" prop="name">
          <el-input v-model="form.name"></el-input>
        </el-form-item>
        @if (!current_customer())
          <el-form-item label="{{ __('common.email') }}" prop="email" v-if="type == 'guest_shipping_address'">
            <el-input v-model="form.email"></el-input>
          </el-form-item>
        @endif
        <el-form-item label="{{ __('address.phone') }}" prop="phone">
          <el-input maxlength="11" v-model="form.phone" type="number"></el-input>
        </el-form-item>
        <el-form-item label="{{ __('address.address') }}" required>
          <div class="row dialog-address">
            <div class="col-4">
              <el-form-item>
                <el-select v-model="form.country_id" filterable placeholder="{{ __('address.country_id') }}" @change="countryChange">
                  <el-option v-for="item in source.countries" :key="item.id" :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
            <div class="col-4 mt-2 mt-sm-0">
              <el-form-item prop="zone_id">
                <el-select v-model="form.zone_id" filterable placeholder="{{ __('address.zone') }}">
                  <el-option v-for="item in source.zones" :key="item.id" :label="item.name"
                    :value="item.id">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
            <div class="col-4 mt-2 mt-sm-0">
              <el-form-item prop="city">
                <el-input v-model="form.city" placeholder="{{ __('shop/account.addresses.enter_city') }}"></el-input>
              </el-form-item>
            </div>
          </div>
        </el-form-item>
        <el-form-item label="{{ __('address.post_code') }}" prop="zipcode">
          <el-input v-model="form.zipcode"></el-input>
        </el-form-item>
        <el-form-item label="{{ __('address.address_1') }}" prop="address_1">
          <el-input v-model="form.address_1"></el-input>
        </el-form-item>
        <el-form-item label="{{ __('address.address_2') }}">
          <el-input v-model="form.address_2"></el-input>
        </el-form-item>
        <el-form-item label="{{ __('address.default') }}" v-if="source.isLogin">
          <el-switch
            v-model="form.default"
            >
          </el-switch>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="addressFormSubmit('addressForm')">{{ __('common.save') }}</el-button>
          <el-button @click="closeAddressDialog('addressForm')">{{ __('common.cancel') }}</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
  Vue.component('address-dialog', {
  template: '#address-dialog',
  props: {
    value: {
      default: null
    },
  },

  data: function () {
    return {
      editShow: false,
      index: null,
      type: 'shipping_address_id',
      form: {
        name: '',
        phone: '',
        country_id: @json((int) system_setting('base.country_id')),
        zipcode: '',
        zone_id: @json((int) system_setting('base.zone_id')),
        city: '',
        address_1: '',
        address_2: '',
        default: false,
      },

      rules: {
        name: [{
          required: true,
          message: '{{ __('shop/account.addresses.enter_name') }}',
          trigger: 'blur'
        }, ],
        email: [{
          required: true,
          type: 'email',
          message: '{{ __('shop/login.enter_email') }}',
          trigger: 'blur'
        }, ],
        phone: [{
          required: true,
          message: '{{ __('shop/account.addresses.enter_phone') }}',
          trigger: 'blur'
        }, ],
        address_1: [{
          required: true,
          message: ' {{ __('shop/account.addresses.enter_address') }}',
          trigger: 'blur'
        }, ],
        zone_id: [{
          required: true,
          message: '{{ __('shop/account.addresses.select_province') }}',
          trigger: 'blur'
        }, ],
        city: [{
          required: true,
          message: '{{ __('shop/account.addresses.enter_city') }}',
          trigger: 'blur'
        }, ],
      },

      source: {
        countries: @json($countries ?? []),
        zones: [],
        isLogin: config.isLogin,
      },
    }
  },

  computed: {
  },

  beforeMount() {
    this.countryChange(this.form.country_id);
  },

  methods: {
    editAddress(addresses, type) {
      this.type = type
      if (addresses) {
        this.form = addresses
      }

      this.countryChange(this.form.country_id);
      this.editShow = true
    },

    addressFormSubmit(form) {
      this.$refs[form].validate((valid) => {
        if (!valid) {
          this.$message.error('{{ __('shop/checkout.check_form') }}');
          return;
        }

        this.$emit('change', this.form)
        // const type = this.form.id ? 'put' : 'post';

        // const url = `/account/addresses${type == 'put' ? '/' + this.form.id : ''}`;

        // $http[type](url, this.form).then((res) => {
        //   this.$message.success(res.message);
        //   this.$emit('change', res.data)
        //   this.editShow = false
        // })
      });
    },

    closeAddressDialog() {
      this.$refs['addressForm'].resetFields();
      this.editShow = false

      Object.keys(this.form).forEach(key => this.form[key] = '')
      this.form.country_id = @json((int) system_setting('base.country_id'));
      this.form.default = false;
    },

    countryChange(e) {
      const self = this;

      $http.get(`/countries/${e}/zones`, null, {
        hload: true
      }).then((res) => {
        this.source.zones = res.data.zones;

        if (!res.data.zones.some(e => e.id == this.form.zone_id)) {
          this.form.zone_id = '';
        }
      })
    },
  }
});
</script>