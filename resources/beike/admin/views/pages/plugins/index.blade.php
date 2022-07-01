@extends('admin::layouts.master')

@section('title', '插件列表')

@section('content')

  <div id="plugins-app" class="card" v-cloak>
    <div class="card-body">
      <a href="{{ admin_route('categories.create') }}" class="btn btn-primary">创建插件</a>
      <div class="mt-4" style="">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>插件类型</th>
              <th width="55%">插件描述</th>
              <th>状态</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="plugin, index in plugins" :key="index" v-if="plugins.length">
              <td>@{{ plugin->code }}</td>
              <td>@{{ plugin->type }}</td>
              <td>
                <div class="plugin-describe d-flex align-items-center">
                  <div class="me-2" style="width: 50px;"><img src="@{{ plugin->icon }}" class="img-fluid"></div>
                  <div>
                    <h6>@{{ plugin->name }}</h6>
                    <div class="" v-html="plugin->description"></div>
                  </div>
                </div>
              </td>
              <td>
{{--                 <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="switch-1"
                    @{{ plugin->getEnabled() ? 'checked' : '' }} data-code="@{{ plugin->code }}">
                  <label class="form-check-label" for="switch-1"></label>
                </div> --}}
              </td>
              <td>
                <a class="btn btn-outline-secondary btn-sm" href="">编辑</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('footer')
  <script>
    new Vue({
      el: '#plugins-app',

      data: {
        plugins: @json($plugins ?? []),
      },

      beforeMount() {

      },

      methods: {

      }
    })
  </script>

{{--   <script>
    $('.form-switch input[type="checkbox"]').change(function(event) {
      const $input = $(this);
      const checked = $(this).prop('checked') ? 1 : 0;
      const code = $(this).data('code')
      $.ajax({
        url: `/admin/plugins/${code}/status`,
        type: 'PUT',
        data: {status: checked},
        success: function(res) {
          layer.msg(res.message)
        },
        error: function() {
          $input.prop("checked", false);
        }
      })
    });
  </script> --}}
@endpush
