<div class="s-objects__item">
    <a class="s-objects__link" href="{{ $item->url }}" title="{{ $item->name }}">
        <img class="s-objects__pic" src="{{ $item->thumb(2) }}" data-src="{{ $item->thumb(2) }}" width="585" height="357" alt="">
    </a>
    <a class="s-objects__link" href="{{ $item->url }}" title="{{ $item->name }}">
        <span class="s-objects__object">{{ $item->name }}</span>
    </a>
    <div class="s-objects__params">
        <div class="s-objects__param">{{ $item->city }}</div>
        <div class="s-objects__param">{!! $item->square !!}</div>
    </div>
    <div class="s-objects__body">
        {{ $item->announce }}
    </div>
</div>