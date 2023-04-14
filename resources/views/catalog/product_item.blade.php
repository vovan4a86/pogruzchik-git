<div class="b-cards__item">
    <div class="p-card">
        @if($item->price && $item->getRecourseDiscountAmount())
            <div class="p-card__badge badge">Лучшая цена</div>
        @endif
        <div class="p-card__preview">
            <img class="p-card__img" src="{{ $item->image()->first() ? $item->image()->first()->image : $item->showAnyImage() }}"
                 data-src="{{ $item->image()->first() ? $item->image()->first()->image : $item->showAnyImage() }}"
                 width="227" height="162" alt="{{ $item->name }}"/>
        </div>
        <div class="p-card__code">Код: {{ $item->id }}</div>
        <div class="p-card__body">{{ $item->name }}</div>
        <div class="p-card__bottom">
            <div class="p-card__pricing">
                @if($item->price)
                    @if($item->getRecourseDiscountAmount())
                        <div class="p-card__discounts">
                            <span data-end="₽/{{ $item->getRecourseMeasure() }}">{{ round($item->getPriceWithDiscount()) }}</span>
                            <div class="p-card__value">
                                -{{ $item->getRecourseDiscountAmount() }}%
                            </div>
                        </div>
                    @endif
                    <div class="p-card__current"
                         data-end="/ {{ $item->getRecourseMeasure() }}">{{ $item->price }}
                        ₽
                    </div>
                @endif
            </div>
            <div class="p-card__action">
                <a class="btn btn--primary btn--small btn-reset"
                    href="{{ $item->url }}">
                    <span>Заказать</span>
                </a>
            </div>
        </div>
    </div>
</div>
