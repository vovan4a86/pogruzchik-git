<div class="layout__aside">
    <aside class="aside">
        <div class="aside__nav">
            <div class="aside-nav">
                @foreach($categories as $item)
                    <div class="aside-nav__item">
                        <div class="aside-nav__head" data-aside-head="">
                            <div class="aside-nav__title">{{ $item->name }}</div>
                            <div class="aside-nav__icon lazy entered loaded"
                                 data-bg="/static/images/common/ico_aside.svg" data-ll-status="loaded"
                                 style="background-image: url(&quot;/static/images/common/ico_aside.svg&quot;);"></div>
                        </div>
                        @if($item->children)
                            <div class="aside-nav__body" data-aside-body="" style="display: none;">
                                <ul class="aside-nav__list list-reset">
                                    @foreach($item->children as $child)
                                        <li>
                                            <a href="{{ $child->url }}" data-aside-link="">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @include('catalog.blocks.aside_request')
    </aside>
</div>

