@if($banners = Settings::get('aside_banner'))
    @foreach($banners as $banner)
    <div class="aside__request">
        <div class="aside-request lazy" data-bg="{{ Settings::fileSrc(array_get($banner, 'aside_banner_img', '/static/images/common/aside-request-bg.jpg')) }}">
            <div class="aside-request__title">{{ array_get($banner, 'aside_banner_title', '') }}</div>
            <div class="aside-request__text">{{ array_get($banner, 'aside_banner_subtitle', '') }}</div>
            <div class="aside-request__action">
                <button class="btn btn--primary btn--small btn-reset" type="button" data-popup
                        data-src="#request" aria-label="Оставить заявку">
                    <span>Оставить заявку</span>
                </button>
            </div>
        </div>
    </div>
    <div class="aside__text">{{ array_get($banner, 'aside_banner_text', '') }}</div>
    @endforeach
@endif