<section class="s-request">
    <div class="s-request__container container">
        <div class="s-request__body">
            <form class="s-request__content" action="{{ route('ajax.consultation') }}"
                                                onsubmit="sendCallback(this, event)">
                <div class="s-request__title">{{ Settings::get('consult_banner')['consult_banner_title'] ?: 'Нет времени на поиск в каталоге — Запроси консультацию' }}</div>
                <div class="s-request__text">{{ Settings::get('consult_banner')['consult_banner_text'] ?: 'Наш специалист подскажет по ассортименту и сделает лучшее предложение' }}</div>
                <div class="s-request__fields">
                    <label class="s-request__label">
                        <span data-required="*">Имя</span>
                        <input class="s-request__input" type="text" name="name" placeholder="Введите имя" required autocomplete="off">
                    </label>
                    <label class="s-request__label">
                        <span data-required="*">Телефон</span>
                        <input class="s-request__input" type="tel" name="phone" placeholder="Телефон" required autocomplete="off">
                    </label>
                    <label class="checkbox">
                        <input class="checkbox__input" type="checkbox" checked required>
                        <span class="checkbox__box"></span>
                        <span class="checkbox__policy">Согласен на обработку
                            <a href="{{ route('policy') }}" target="_blank">персональных данных</a>
                        </span>
                    </label>
                    <button class="btn btn--primary btn-reset" name="submit">
                        <span>Оставить заявку</span>
                    </button>
                </div>
            </form>
            <div class="s-request__decor">
                <img class="s-request__pic lazy" src="/"
                     data-src="{{ Settings::fileSrc(Settings::get('consult_banner')['consult_banner_img']) ?: '/static/images/common/man-img.png' }}" width="476" height="464" alt="">
            </div>
        </div>
    </div>
</section>
