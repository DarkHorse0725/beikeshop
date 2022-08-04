<div class="header-wrap">
  <div class="header-left">
    <div class="logo">
      <a href=""><img src="{{ asset('image/logo.png') }}" class="img-fluid"></a>
      {{-- <div class="text-center"><h5 class="mb-0">beike admin</h5></div> --}}
    </div>
  </div>
  <div class="header-right">
    <ul class="navbar navbar-right">
      @foreach ($links as $link)
        <li class="nav-item {{ $link['active'] ? 'active' : '' }}"><a href="{{ $link['url'] }}" class="nav-link">{{ $link['title'] }}</a></li>
      @endforeach
    </ul>
    <ul class="navbar">
      <li class="nav-item">
        <a target="_blank" href="{{ shop_route('home.index') }}" class="nav-link"><i class="bi bi-send me-1"></i> @lang('admin/common.access_frontend')</a>
      </li>
      <li class="nav-item">
        <div class="dropdown">
          <a href="#" class="nav-link dropdown-toggle px-2" data-bs-toggle="dropdown">
            <img src="http://dummyimage.com/100x100" class="avatar img-fluid rounded-circle me-1">
            <span class="text-dark ml-2">{{ current_user()->name }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
            <li><a href="{{ admin_route('logout.index') }}" class="dropdown-item"><i class="bi bi-box-arrow-left"></i> 退出登录</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
