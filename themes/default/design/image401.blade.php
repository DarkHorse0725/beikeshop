<section class="module-item {{ $design ? 'module-item-design' : ''}}" id="module-{{ $module_id }}">
  @if ($design)
  <div class="module-edit">
    <div class="edit-wrap">
      <div class="down"><i class="bi bi-chevron-down"></i></div>
      <div class="up"><i class="bi bi-chevron-up"></i></div>
      <div class="delete"><i class="bi bi-x-lg"></i></div>
      <div class="edit"><i class="bi bi-pencil-square"></i></div>
    </div>
  </div>
  @endif

  <div class="module-image-plus module-info mb-5">
    <div class="container">
      <div class="row">
        <div class="col-6"><img src="{{ $content['images'][0]['image'] }}" class="img-fluid"></div>
        <div class="col-6">
          <div class="module-image-plus-top">
            <a href=""><img src="{{ $content['images'][1]['image'] }}" class="img-fluid"></a>
            <a href="" class="right"><img src="{{ $content['images'][2]['image'] }}" class="img-fluid"></a>
          </div>
          <div class="module-image-plus-bottom"><a href=""><img src="{{ $content['images'][3]['image'] }}" class="img-fluid"></a></div>
        </div>
      </div>
    </div>
  </div>
</section>