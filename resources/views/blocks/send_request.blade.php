<section class="b-contacts">
    <div class="b-contacts__container container">
        <form class="b-contacts__body lazy" data-bg="/static/images/common/b-contacts.svg"
              action="{{ route('ajax.optimal-decision') }}" onsubmit="sendRequestFile(this, event)">
            <div class="b-contacts__grid">
                <div class="b-contacts__content">
                    <div class="b-contacts__title">{{ Settings::get('optimal_banner')['optimal_banner_title'] ?: 'Предложим оптимальное решение' }}</div>
                    <div class="b-contacts__text">
                        {{ Settings::get('optimal_banner')['optimal_banner_text'] ?: 'Мы осуществляем комплексное снабжение стройматериалами на
                        условиях, которых вы ни у кого не найдете' }}
                    </div>
                </div>
                <div class="b-contacts__data">
                    <div class="b-contacts__fields">
                        <label class="b-contacts__label">
                            <span data-required="*">Имя</span>
                            <input class="b-contacts__input" type="text" name="name" placeholder="Введите имя"
                                   required autocomplete="off">
                        </label>
                        <label class="b-contacts__label">
                            <span data-required="*">Телефон</span>
                            <input class="b-contacts__input" type="tel" name="phone" placeholder="Телефон"
                                   required autocomplete="off">
                        </label>
                    </div>
                    <div class="b-contacts__file">
                        <label class="upload">
                            <span class="upload__name">Прикрепить файл</span>
                            <input type="file" name="file"
                                   accept=".jpg, .jpeg, .png, .pdf, .doc, .docs, .xls, .xlsx">
                        </label>
                    </div>
                    <div class="b-contacts__policy">
                        <label class="checkbox">
                            <input class="checkbox__input" type="checkbox" checked required>
                            <span class="checkbox__box"></span>
                            <span class="checkbox__policy">Согласен на обработку
											<a href="{{ route('policy') }}" target="_blank">персональных данных</a>
										</span>
                        </label>
                    </div>
                    <div class="b-contacts__action">
                        <button class="btn btn--primary btn-reset" name="submit" aria-label="Оставить заявку">
                            <span>Оставить заявку</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
