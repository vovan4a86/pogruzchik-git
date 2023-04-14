<form class="popup" id="callback" action="{{ route('ajax.callback') }}"
      onsubmit="sendCallback(this, event)" style="display: none">
    <div class="popup__container">
        <div class="popup__head">
            <div class="popup__title">Обратный звонок</div>
        </div>
        <div class="popup__fields">
            <label class="popup__label">
                <span data-required="*">Имя</span>
                <input class="popup__input" type="text" name="name" placeholder="Введите имя" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span data-required="*">Телефон</span>
                <input class="popup__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span data-required="*">Удобное время</span>
                <input class="popup__input" type="text" name="time" placeholder="с 8 до 18" autocomplete="off" required>
            </label>
        </div>
        <div class="popup__policy">
            <label class="checkbox checkbox--popup">
                <input class="checkbox__input" type="checkbox" checked required>
                <span class="checkbox__box"></span>
                <span class="checkbox__policy">Согласен на обработку
							<a href="{{ route('policy') }}" target="_blank">персональных данных</a>
						</span>
            </label>
        </div>
        <div class="popup__action">
            <button class="btn btn--primary btn-reset" name="submit" aria-label="Оставить заявку">
                <span>Оставить заявку</span>
            </button>
        </div>
    </div>
</form>
<form class="popup" id="request" action="{{ route('ajax.manager-request') }}"
      onsubmit="sendCallback(this, event)" style="display: none">
    <div class="popup__container">
        <div class="popup__head">
            <div class="popup__title">Запрос менеджеру</div>
        </div>
        <div class="popup__fields">
            <label class="popup__label">
                <span data-required="*">Имя</span>
                <input class="popup__input" type="text" name="name" placeholder="Введите имя" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span data-required="*">Телефон</span>
                <input class="popup__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span>Сообщение</span>
                <textarea class="popup__input" name="message" placeholder="Введите сообщение" rows="4"></textarea>
            </label>
        </div>
        <div class="popup__policy">
            <label class="checkbox checkbox--popup">
                <input class="checkbox__input" type="checkbox" checked required>
                <span class="checkbox__box"></span>
                <span class="checkbox__policy">Согласен на обработку
							<a href="{{ route('policy') }}" target="_blank">персональных данных</a>
						</span>
            </label>
        </div>
        <div class="popup__action">
            <button class="btn btn--primary btn-reset" name="submit" aria-label="Оставить заявку">
                <span>Оставить заявку</span>
            </button>
        </div>
    </div>
</form>
<form class="popup" id="calc" action="{{ route('ajax.complex-decision') }}"
      onsubmit="sendRequestFileComplex(this, event)" style="display: none">
    <div class="popup__container">
        <div class="popup__head">
            <div class="popup__title">Оставьте заявку</div>
            <div class="popup__text">Введите данные для связи и наш менеджер свяжется с Вами в течении нескольких минут</div>
        </div>
        <div class="popup__fields">
            <label class="popup__label">
                <span data-required="*">Имя</span>
                <input class="popup__input" type="text" name="name" placeholder="Введите имя" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span data-required="*">Телефон</span>
                <input class="popup__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span>Сообщение</span>
                <textarea class="popup__input" name="message" placeholder="Введите сообщение" rows="4"></textarea>
            </label>
        </div>
        <div class="popup__file">
            <div class="popup__file-upload">
                <label class="upload upload--popup">
                    <span class="upload__name">Прикрепить файл</span>
                    <input type="file" name="cfile" accept=".jpg, .jpeg, .png, .pdf, .doc, .docs, .xls, .xlsx">
                </label>
            </div>
        </div>
        <div class="popup__policy">
            <label class="checkbox checkbox--popup">
                <input class="checkbox__input" type="checkbox" checked required>
                <span class="checkbox__box"></span>
                <span class="checkbox__policy">Согласен на обработку
							<a href="{{ route('policy') }}" target="_blank">персональных данных</a>
						</span>
            </label>
        </div>
        <div class="popup__action">
            <button class="btn btn--primary btn-reset" name="submit" aria-label="Оставить заявку">
                <span>Оставить заявку</span>
            </button>
        </div>
    </div>
</form>
<form class="popup" id="consult" action="#" style="display: none"
      onsubmit="sendRequestProductConsult(this, event)">
    <div class="popup__container">
        <div class="popup__head">
            <div class="popup__title">Заказать консультацию</div>
            <div class="popup__text">Заполните данные для получения консультации по товару</div>
        </div>
        <div class="popup__fields">
            <label class="popup__label">
                <span data-required="*">Имя</span>
                <input class="popup__input" type="text" name="name" placeholder="Введите имя" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span data-required="*">Телефон</span>
                <input class="popup__input" type="tel" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="off" required>
            </label>
            <label class="popup__label">
                <span>Сообщение</span>
                <textarea class="popup__input" name="message" placeholder="Введите сообщение" rows="4"></textarea>
            </label>
        </div>
        <div class="popup__file">
            <div class="popup__file-upload">
                <label class="upload upload--popup">
                    <span class="upload__name">Прикрепить файл</span>
                    <input type="file" name="dfile" accept=".jpg, .jpeg, .png, .pdf, .doc, .docs, .xls, .xlsx">
                </label>
            </div>
        </div>
        <div class="popup__policy">
            <label class="checkbox checkbox--popup">
                <input class="checkbox__input" type="checkbox" checked required>
                <span class="checkbox__box"></span>
                <span class="checkbox__policy">Согласен на обработку
							<a href="{{ route('policy') }}" target="_blank">персональных данных</a>
						</span>
            </label>
        </div>
        <div class="popup__action">
            <button class="btn btn--primary btn-reset" name="submit" aria-label="Оставить заявку">
                <span>Оставить заявку</span>
            </button>
        </div>
    </div>
</form>
<div class="popup" id="request-done" style="display:none">
    <div class="popup__complete">
        <div class="popup__complete-icon lazy" data-bg="/static/images/common/ico_done.svg"></div>
        <div class="popup__complete-label">Ваша заявка отправлена. Наши специалисты свяжутся с вами в ближайшее время. Спасибо.</div>
    </div>
</div>
