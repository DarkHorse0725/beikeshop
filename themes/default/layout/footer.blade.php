<footer>
  @php
    $locale = locale();
  @endphp
  <div class="services-wrap">
    <div class="container">
      <div class="row">
        @foreach ($footer_content['services']['items'] as $item)
          <div class="col-lg-3 col-md-6 col-12">
            <div class="service-item">
              <div class="icon"><img src="{{ image_resize($item['image'], 80, 80) }}" class="img-fluid"></div>
              <div class="text">
                <p class="title">{{ $item['title'][locale()] ?? '' }}</p>
                <p class="sub-title">{{ $item['sub_title'][locale()] ?? '' }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="container">
    <div class="footer-content">
      <div class="row">
        <div class="col-12 col-md-4">
          <div class="footer-content-left">
            <div class="logo"><a href="http://"><img
                  src="{{ image_origin($footer_content['content']['intro']['logo']) }}" class="img-fluid"></a></div>
            <div class="text">{!! $footer_content['content']['intro']['text'][$locale] ?? '' !!}</div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row">
            @for ($i = 1; $i <= 3; $i++)
              @php
                $link = $footer_content['content']['link' . $i];
              @endphp
              <div class="col-6 col-sm">
                <h6 class="text-uppercase text-dark mb-3">{{ $link['title'][$locale] }}</h6>
                <ul class="list-unstyled">
                  @foreach ($link['links'] as $item)
                    <li><a href="{{ type_route($item['type'], $item['value']) }}"
                        @if (isset($item['new_window']) && $item['new_window']) target="_blank" @endif>{{ $item['text'][$locale] }}</a></li>
                  @endforeach
                </ul>
              </div>
            @endfor
            <div class="col-6 col-sm">
              <h6 class="text-uppercase text-dark mb-3">联系我们</h6>
              <ul class="list-unstyled">
                @if ($footer_content['content']['contact']['email'])
                  <li>{{ $footer_content['content']['contact']['email'] }}</li>
                @endif
                @if ($footer_content['content']['contact']['telephone'])
                  <li>{{ $footer_content['content']['contact']['telephone'] }}</li>
                @endif
                @if ($footer_content['content']['contact']['address'])
                  <li>{{ $footer_content['content']['contact']['address'] }}</li>
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col">
          {!! $footer_content['bottom']['copyright'][$locale] ?? '' !!}
        </div>
        @if (isset($footer_content['bottom']['image']))
          <div class="col-auto">
            <img src="{{ image_origin($footer_content['bottom']['image']) }}" class="img-fluid">
          </div>
        @endif
      </div>
    </div>
  </div>
</footer>
