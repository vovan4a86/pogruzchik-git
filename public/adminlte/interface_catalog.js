var newsImage = null;
function newsImageAttache(elem, e){
    $.each(e.target.files, function(key, file)
    {
        if(file['size'] > max_file_size){
            alert('Слишком большой размер файла. Максимальный размер 2Мб');
        } else {
            newsImage = file;
            renderImage(file, function (imgSrc) {
                var item = '<img class="img-polaroid" src="' + imgSrc + '" height="100" data-image="' + imgSrc + '" onclick="return popupImage($(this).data(\'image\'))">';
                $('#article-image-block').html(item);
            });
        }
    });
    $(elem).val('');
}

var doc = null;
function docAttache(elem, e){
    $.each(e.target.files, function(key, file)
    {
        if(file['size'] > max_file_size){
            alert('Слишком большой размер файла. Максимальный размер 2Мб');
        } else {
            doc = file;
            renderImage(file, function (imgSrc) {
                var item = '<img class="img-polaroid" src="' + imgSrc + '" height="100" data-image="' + imgSrc + '" onclick="return popupImage($(this).data(\'image\'))">';
                $('#action-image-block').html(item);
            });
        }
    });
    // $(elem).val('');
}

function update_order(form, e) {
    e.preventDefault();
    var button = $(form).find('[type="submit"]');
    button.attr('disabled', 'disabled');
    var url = $(form).attr('action');
    var data = $(form).serialize();
    sendAjax(url, data, function(json){
        button.removeAttr('disabled');
    });
}

function catalogContent(elem){
    //var url = $(elem).attr('href');
    //sendAjax(url, {}, function(html){
    //	$('#catalog-content').html(html);
    //}, 'html');
    //return false;
}

function catalogSave(form, e){
    var url = $(form).attr('action');
    var data = new FormData();
    $.each($(form).serializeArray(), function(key, value){
        data.append(value.name, value.value);
    });
    if (newsImage) {
        data.append('image', newsImage);
    }
    sendFiles(url, data, function(json){
        if (typeof json.row != 'undefined') {
            if ($('#users-list tr[data-id='+json.id+']').length) {
                $('#users-list tr[data-id='+json.id+']').replaceWith(urldecode(json.row));
            } else {
                $('#users-list').append(urldecode(json.row));
            }
        }
        if (typeof json.errors != 'undefined') {
            applyFormValidate(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) { errMsg.push(json.errors[key]);  }
            $(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
        }
        if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
        if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
        if (typeof json.success != 'undefined' && json.success == true) {
            newsImage = null;
        }
    });
    return false;
}

function catalogDel(elem){
    if (!confirm('Удалить раздел?')) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest('li').fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

function productSave(form, e){
    var url = $(form).attr('action');
    var data = $(form).serialize();
    sendAjax(url, data, function(json){
        if (typeof json.errors != 'undefined') {
            applyFormValidate(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) { errMsg.push(json.errors[key]);  }
            $(form).find('[type=submit]').after(autoHideMsg('red', urldecode(errMsg.join(' '))));
        }
        if (typeof json.redirect != 'undefined') document.location.href = urldecode(json.redirect);
        if (typeof json.msg != 'undefined') $(form).find('[type=submit]').after(autoHideMsg('green', urldecode(json.msg)));
    });
    return false;
}

function productDel(elem){
    if (!confirm('Удалить товар?')) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest('tr').fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

function productImageUpload(elem, e){
    var url = $(elem).data('url');
    files = e.target.files;
    var data = new FormData();
    $.each(files, function(key, value)
    {
        if(value['size'] > max_file_size){
            alert('Слишком большой размер файла. Максимальный размер 2Мб');
        } else {
            data.append('images[]', value);
        }
    });
    $(elem).val('');

    sendFiles(url, data, function(json){
        if (typeof json.html != 'undefined') {
            $('.images_list').append(urldecode(json.html));
            if (!$('.images_list img.active').length) {
                $('.images_list .img_check').eq(0).trigger('click');
            }
        }
    });
}

function productCheckImage(elem){
    $('.images_list img').removeClass('active');
    $('.images_list .img_check .glyphicon').removeClass('glyphicon-check').addClass('glyphicon-unchecked');

    $(elem).find('.glyphicon').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
    $(elem).siblings('img').addClass('active');

    $('#product-image').val($(elem).siblings('img').data('image'));
    return false;
}

function productImageDel(elem){
    if (!confirm('Удалить изображение?')) return false;
    var url = $(elem).attr('href');
    sendAjax(url, {}, function(json){
        if (typeof json.msg != 'undefined') alert(urldecode(json.msg));
        if (typeof json.success != 'undefined' && json.success == true) {
            $(elem).closest('.images_item').fadeOut(300, function(){ $(this).remove(); });
        }
    });
    return false;
}

$(document).ready(function () {
    $('#pages-tree').jstree({
        "core": {
            "animation": 0,
            "check_callback": true,
            'force_text': false,
            "themes": {"stripes": true},
            'data': {
                'url': function (node) {
                    return node.id === '#' ? '/admin/catalog/get-catalogs' : '/admin/catalog/get-catalogs/' + node.id;
                }
            },
        },
        "plugins": ["contextmenu", "dnd", "state", "types"],
        "contextmenu": {
            "items": function ($node) {
                var tree = $("#tree").jstree(true);
                return {
                    "Create": {
                        "icon": "fa fa-plus text-blue",
                        "label": "Создать страницу",
                        "action": function (obj) {
                            // $node = tree.create_node($node);
                            document.location.href = '/admin/catalog/catalog-edit?parent=' + $node.id
                        }
                    },
                    "Edit": {
                        "icon": "fa fa-pencil text-yellow",
                        "label": "Редактировать страницу",
                        "action": function (obj) {
                            // tree.delete_node($node);
                            document.location.href = '/admin/catalog/catalog-edit/' + $node.id
                        }
                    },
                    "Remove": {
                        "icon": "fa fa-trash text-red",
                        "label": "Удалить страницу",
                        "action": function (obj) {
                            if (confirm("Действительно удалить страницу?")) {
                                var url = '/admin/catalog/catalog-delete/' + $node.id;
                                sendAjax(url, {}, function () {
                                    document.location.href = '/admin/catalog';
                                })
                            }
                            // tree.delete_node($node);
                        }
                    }
                };
            }
        }
    }).bind("move_node.jstree", function (e, data) {
        treeInst = $(this).jstree(true);
        parent =  treeInst.get_node( data.parent );
        var d = {
            'id':   data.node.id,
            'parent': (data.parent == '#')? 0: data.parent,
            'sorted': parent.children
        };
        sendAjax('/admin/catalog/catalog-reorder', d);
    }).on("activate_node.jstree", function(e,data){
        if(data.event.button == 0){
            window.location.href = '/admin/catalog/products/' + data.node.id;
        }
    });
});

function addDoc(elem, e) {
    e.preventDefault();
    var dataForm = new FormData();

    var sendUrl = $(elem).attr('href');
    var name = $('input[name=doc_name]');
    var file = $('#doc-file');

    if(!name.val()){
        alert('Введите название');
        return;
    }

    dataForm.append('name', name.val());
    dataForm.append('file', file[0].files[0]);

    sendAjaxWithFile(sendUrl, dataForm, function(json){
        if (typeof json.errors != 'undefined') {
            // applyFormValidate(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) { errMsg.push(json.errors[key]);  }
            $(elem).after(autoHideMsg('red', urldecode(errMsg.join(' '))));
        }
        if(typeof json.row != 'undefined'){
            $('#doc_list tbody').append(json.row);
            name.val('');
            file.val('');
        }
    });
}

function delDoc(elem, e) {
    e.preventDefault();
    if(!confirm('Точно удалить этот документ?')) return;
    var url = $(elem).attr('href');
    var row = $(elem).closest('tr');

    sendAjax(url, {}, function(json){
        if(typeof json.success != 'undefined'){
            $(row).fadeOut(300, function(){ $(this).remove(); });
        }
    });
}

function saveRelated(form, e) {
    e.preventDefault();
    var url = $(form).attr('action');
    var data = $(form).serialize();
    var id = $(form).data('id');
    sendAjax(url, data, function (html) {
        popupClose();
        $('tr#related'+id).replaceWith(html);
    }, 'html');
}

function addParam(elem, e) {
    e.preventDefault();
    var name = $('.param-name');
    var measure = $('.param-measure');

    if(!name.val()){
        alert('Нужно заполнить название');
        return;
    }
    var data = {
        name: name.val(),
        measure: measure.val(),
    }
    var url = $(elem).attr('href');

    sendAjax(url, data, function(json){
        if(typeof json.row != 'undefined'){
            $('#param_list tbody').append(json.row);
            name.val('');
            measure.val('');
        }
    });
}

function addMenuAction(elem, e) {
    e.preventDefault();
    var dataForm = new FormData();

    var title = $('.add-action input[name=menu-action-title]');
    var text = $('.add-action input[name=menu-action-text]');
    var price = $('.add-action input[name=menu-action-price]');
    var measure = $('.add-action input[name=menu-action-measure]');
    var url = $('.add-action input[name=menu-action-url]');
    var style = $('.add-action select[name=menu-action-style]');
    var productId = $('.add-action select[name=menu-action-productId]');
    var file = $('.add-action #menu-action-image');

    if(!title.val() && !price.val() && !price.val()){
        alert('Заполните заголовок, цену и измерение товара!');
        return;
    }
    dataForm.append('title', title.val());
    dataForm.append('text', text.val());
    dataForm.append('price', price.val());
    dataForm.append('measure', measure.val());
    dataForm.append('url', url.val());
    dataForm.append('style', style.val());
    dataForm.append('product_id', productId.val());
    dataForm.append('file', file[0].files[0]);
    var sendUrl = $(elem).attr('href');

    sendAjaxWithFile(sendUrl, dataForm, function(json){
        if (typeof json.errors != 'undefined') {
            // applyFormValidate(form, json.errors);
            var errMsg = [];
            for (var key in json.errors) { errMsg.push(json.errors[key]);  }
            $(elem).after(autoHideMsg('red', urldecode(errMsg.join(' '))));
        }
        if(typeof json.row != 'undefined'){
            $('.overlay-nav__actions').append(json.row);
            title.val('');
            text.val('');
            price.val('');
            measure.val('');
            file.val('');
        }
    });
}

function updateMenuAction(elem, e, id) {
    e.preventDefault();

    var title = $('#menu-action-' + id + ' input[name=menu-action-title]');
    var text = $('#menu-action-' + id + ' input[name=menu-action-text]');
    var price = $('#menu-action-' + id + ' input[name=menu-action-price]');
    var measure = $('#menu-action-' + id + ' input[name=menu-action-measure]');
    var url = $('#menu-action-' + id + ' input[name=menu-action-url]');

    if(!title.val() && !price.val() && !price.val()){
        alert('Заполните заголовок, цену и измерение товара!');
        return;
    }
    const data = {
        title: title.val(),
        text: text.val(),
        price: price.val(),
        measure: measure.val(),
        url: url.val(),
    }
    var sendUrl = $(elem).attr('href');

    sendAjax(sendUrl, data, function(json){
        if(json.errors) {
            json.errors.foreach(err => {
                console.log(err);
            })
        }
        if(typeof json.row != 'undefined'){
            const id = json.id;
            $('#menu-action-' + id + ' span').replaceWith(json.row);
            showHiddenMenuAction(id);
        }
    });
}

function delMenuAction(elem, e, id) {
    e.preventDefault();
    if(!confirm('Точно удалить акцию?')) return;
    var url = $(elem).attr('href');
    var row = $(elem).closest('#menu-action-'+id);

    sendAjax(url, {}, function(json){
        if(typeof json.success != 'undefined'){
            $(row).fadeOut(300, function(){ $(this).remove(); });
        }
    });
}

function showHiddenMenuAction(id) {
    let hidden = $('#menu-action-' + id + ' .menu-action-hidden');
    hidden.toggle('slide', { direction: "left" }, 300);
}

function delParam(elem, e) {
    e.preventDefault();
    if(!confirm('Точно удалить этот параметр?')) return;
    var url = $(elem).attr('href');
    var row = $(elem).closest('tr');

    sendAjax(url, {}, function(json){
        if(typeof json.success != 'undefined'){
            $(row).fadeOut(300, function(){ $(this).remove(); });
        }
    });
}

function editParam(link, e) {
    e.preventDefault();
    var url = $(link).attr('href');
    sendAjax(url, {}, function (html) {
        popup(html);
    }, 'html');
}

function saveParam(form, e) {
    e.preventDefault();
    var url = $(form).attr('action');
    var data = $(form).serialize();
    var id = $(form).data('id');
    sendAjax(url, data, function (html) {
        popupClose();
        $('tr#param'+id).replaceWith(html);
    }, 'html');
}

function showHidden(elem) {
    let hidden = $('.action-hidden');
    if(elem.checked) {
        hidden.slideDown(300);
    } else {
        hidden.slideUp(300);
    }
}
