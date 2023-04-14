function changeQuantityUp() {
    let price = $('.p-actions__price').text();
    if (price != 0) price = price.split(' ')[0];
    let count = $('input[name=count]').val();
    let summary = $('.p-actions__summary');
    let totalCount = $('.p-actions__total span');
    let measure = totalCount.text().split(' ')[2];
    let addToCartBtn = $('button.p-actions__btn.btn-reset');

    if (price) {
        count = ++count;
        let res = count * price;
        addToCartBtn.attr('data-count', count);
        summary.empty();
        summary.text(res.toFixed(2) + ' ₽');
        totalCount.text(`за ${count} ${measure}`);
    }
}

function changeQuantityDown() {
    let price = $('.p-actions__price').text();
    if (price != 0) price = price.split(' ')[0];
    let count = $('input[name=count]').val();
    let summary = $('.p-actions__summary');
    let totalCount = $('.p-actions__total span');
    let measure = totalCount.text().split(' ')[2];
    let addToCartBtn = $('button.p-actions__btn.btn-reset');

    if (price) {
        if (count > 1) {
            count = --count;
            let res = count * price;
            addToCartBtn.attr('data-count', count);
            summary.empty();
            summary.text(res.toFixed(2) + ' ₽');
            totalCount.text(`за ${count} ${measure}`);
        }
    }
}

function cartItemCountUp(elem, id) {
    let count = $('input[name=count' + id + ']').val();
    if ($(elem).hasClass('counter__btn--next')) {
        count = ++count;
    } else {
        if (count == 1) return;
        count = --count;
    }

    Cart.update(id, count, function (res) {
        if (res.success) {
            $('.c-order__price.item' + id).replaceWith(res.item_summ);
            $('.c-order__value').replaceWith(res.total);
        }
    })
}

function cartUpdateCount(elem, id, price) {
    let count = $(elem).val();
    let cardSum = $('[data-id=' + id + ']');
    // cardSum.text(count * price);
}

function purgeCart() {
    Cart.purge(function (res) {
        if (res.success == true) {
            $('.c-order__row.c-order__row--body').each(function (i) {
                $(this).remove();
            });
            $('.c-order__value').replaceWith(res.total);
        }
    }.bind(this));
}

function deleteCartItem(elem, id) {
    Cart.remove(id, function (res) {
        if (res.success == true) {
            $(elem).closest('.c-order__row.c-order__row--body').remove();
            $('.c-order__value').replaceWith(res.total);
        }
    }.bind(this));
}

function addToCart(elem, id) {
    const count = $(elem).data('count');
    Cart.add(id, count, function (res) {
        // $('.basket').replaceWith(res.header_cart);
        alert('Товар добавлен в корзину');
    }.bind(this));
}

function ajaxRequest(elem, e) {
    e.preventDefault();

    const url = $(elem).attr('href');

    $.ajax({
        url: url,
        success: function (json) {
            if (typeof json.items !== 'undefined') {
                $('.b-cards__grid').html(json.items);
            }
            if (typeof json.paginate !== 'undefined') {
                $('.section__pagination').html(json.paginate);
            }
        }
    });
}

function sendOrder(form, e) {
    e.preventDefault();
    let data = $(form).serialize();
    const url = $(form).attr('action');

    sendAjax(url, data, function (json) {
        if (typeof json.errors !== 'undefined') {
            let focused = false;
            for (var key in json.errors) {
                if (!focused) {
                    form.find('#' + key).focus();
                    focused = true;
                }
                form.find('#' + key).after('<span class="has-error">' + json.errors[key] + '</span>');
            }
            form.find('.sending__title').after('<div class="err-msg-block has-error">Заполните, пожалуйста, обязательные поля.</div>');
        }
        if (json.success) {
            resetForm(form);
            $('.c-order__row.c-order__row--body').each(function (i) {
                $(this).remove();
            });
            Fancybox.show([{src: '#request-done', type: 'inline'}], {
                mainClass: 'popup--custom popup--complete',
                template: {closeButton: closeBtn},
                hideClass: 'fancybox-zoomOut'
            });
        } else {
            alert('Какая-то внутренняя ошибка!');
        }
    });
}