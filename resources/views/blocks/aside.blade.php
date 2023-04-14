<div class="layout__aside">
    <aside class="aside">
        <div class="aside__nav">
            <div class="aside-nav">
                @foreach($catalogMenu as $item)
                    <div class="aside-nav__item">
                        <div class="aside-nav__head" data-aside-head>
                            <div class="aside-nav__title">{{ $item->name }}</div>
                            <div class="aside-nav__icon lazy"
                                 data-bg="/static/images/common/ico_aside.svg"></div>
                        </div>
                        @if($item->children)
                            <div class="aside-nav__body" data-aside-body>
                                <ul class="aside-nav__list list-reset">
                                    @foreach($item->children as $child)
                                        <li>
                                            <a href="{{ $child->url }}" data-aside-link>
                                                {{ $child->name }}
                                            </a>
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
