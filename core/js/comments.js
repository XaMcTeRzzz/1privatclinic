$('.comment-respond .form-default').submit(function(e){

    e.preventDefault();

    // небольшое условие для того, чтобы исключить двойные нажатия на кнопку отправки
    // в это условие также входит валидация полей
    if (!$('.submit').hasClass('loadingform') && !$(".author").hasClass('error') && !$(".email").hasClass('error') && !$(".comment").hasClass('error')){
        $.ajax({
            type : 'POST',
            url: "/wp-admin/admin-ajax.php", //url, к которому обращаемся
            data: $(this).serialize() + '&action=ajaxcomments',
            beforeSend: function(xhr){
                // действие при отправке формы, сразу после нажатия на кнопку #submit
                $('.submit').addClass('loadingform');
            },
            error: function (request, status, error) {
                $.fancybox.open({
                    src: '#modal-error',
                    type: 'inline'
                });
            },
            success: function (newComment) {
                // очищаем поле textarea
                $('.comment').val('');
                // действие, после того, как комментарий был добавлен
                $.fancybox.open({
                    src: '#modal-done-review',
                    type: 'inline'
                });
                $('.submit').removeClass('loadingform');
            }
        });
    }
    return false;
});
