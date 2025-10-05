function sendToAjax(selector){
    let selectChek = $(selector).find('select');
    if(selectChek){
        selectChek.on('change', function () {
            $(this).prev('.js__chek-select').val('on');
        });
    }
    $(selector).submit(function(event) {
        event.preventDefault();
        let formData =  $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            data:  formData,
            success: function(result) {
                $.fancybox.open({
                    src: '#test-covid-success',
                    type: 'inline'
                });
                $(selector).trigger('reset');
                setTimeout(()=>{
                    $.fancybox.close();
                    $.fancybox.close();
                }, 2000)
            },
            error: function (result) {
                $(selector).find('span.ss-disabled').addClass('error');
                $.fancybox.open({
                    src: '#modal-error',
                    type: 'inline'
                });
            }
        });
    });
}

sendToAjax('.js__form-sing-up');
sendToAjax('.js__call_back');
sendToAjax('.js__ask_question');
sendToAjax('.js__form_check_up');
sendToAjax('.js__sub-form');


/*  Пушим докторов в select */

let doctorsSector = document.querySelector('#signUpSelectDoctors');

if(doctorsSector){

   let slimSelectDoctors = new SlimSelect({
        select: doctorsSector,
        placeholder: doctorsSector.getAttribute('data-placeholder'),
        showSearch: false,
        options: [],
    });

    $('.js__setToSelectDoctors').click(function () {
        let doctors = $(this).data('doctors-json');
        slimSelectDoctors.setData(doctors);
    });

}



$(".feedback-name").on('input', function () {
    $(".feedback-name").next("label").hide();
    $(".feedback-name").css('box-shadow', '');
});

$(".feedback-phone").on('input', function () {
    $(".feedback-phone").next("label").hide();
    $(".feedback-phone").css('box-shadow', '');
});

$('.send-email').click(function () {
    var name = $('.feedback-name').val();
    var phone = $('.feedback-phone').val();
    event.preventDefault();
    $.ajax({
        url: "/wp-admin/admin-ajax.php", //url, к которому обращаемся
        type: "POST",
        dataType: 'JSON',
        data: "action=send_email&name=" + name + "&phone=" + phone + "&subject=" + $(".feedback-subject").val() + "&type=" + $(".feedback-type").val(),
        success: function(data){
            if (data.status == 1) {
                $(".js__medPop").fadeOut('normal', function () {
                    $(this).removeAttr('style');
                    $(this).removeClass('open');
                });
                $.fancybox.open({
                    src: '#modal-done',
                    type: 'inline'
                });
            } else {
                if (data.errors.includes("name")) {
                    $(".feedback-name").css('box-shadow', '0 0 3px rgb(255, 0, 0)');
                    $(".feedback-name").next("label").show();
                }
                if (data.errors.includes("phone")) {
                    $(".feedback-phone").css('box-shadow', '0 0 3px rgb(255, 0, 0)');
                    $(".feedback-phone").next("label").show();
                }
            }
        },
        error: function () {
            $.fancybox.open({
                src: '#modal-error',
                type: 'inline'
            });
        }
    });
});

$(".review-review").on('input', function () {
    $(".review-review").next("label").hide();
    $(".review-review").css('box-shadow', '');
});

$(".review-name").on('input', function () {
    $(".review-name").next("label").hide();
    $(".review-name").css('box-shadow', '');
});

$('.send-email-review').click(function () {
    event.preventDefault();
    $.ajax({
        url: "/wp-admin/admin-ajax.php", //url, к которому обращаемся
        type: "POST",
        dataType: 'JSON',
        data: "action=send_email&name=" + $('.review-name').val() + "&phone=" + $('.review-phone').val() + "&subject=" + $(".review-subject").val() + "&type=" + $(".review-type").val() + "&email=" + $(".review-email").val() + "&review=" + $(".review-review").val(),
        success: function(data){
            if (data.status == 1) {
                $(".js__medPop").fadeOut('normal', function () {
                    $(this).removeAttr('style');
                    $(this).removeClass('open');
                });
                $.fancybox.open({
                    src: '#modal-done-review',
                    type: 'inline'
                });
            } else {
                if (data.errors.includes("name")) {
                    $(".review-name").css('box-shadow', '0 0 3px rgb(255, 0, 0)');
                    $(".review-name").next("label").show();
                }
                if (data.errors.includes("review")) {
                    $(".review-review").css('box-shadow', '0 0 3px rgb(255, 0, 0)');
                    $(".review-review").next("label").show();
                }
            }
        },
        error: function () {
            $.fancybox.open({
                src: '#modal-error-review',
                type: 'inline'
            });
        }
    });
});

//SEARCH PAGE HINTS

$(".hint-link").click(function () {
    var value = $(this).text();
    window.location.replace("/?s=" + value);
});

// ========= COVID TEST =========
$("#covid-test-phone").on('input', function (){
    $("#covid-test-error-msg").text('');
});
$("#covid-test-date").on('input', function (){
    $("#covid-test-error-msg").text('');
});
// Open form
$(".get-covid-test").click(function (){
    $.fancybox.open({
        src: '#covid-test-modal',
        type: 'inline'
    });
});

// Send request for covid test
$("#send-covid-test").click(function (){
    var email = $('#covid-test-email').val();
    var phone = $('#covid-test-phone').val();
    var comment = $('#covid-test-comment').val();
    var date = $('#covid-test-date').val();
    event.preventDefault();
    $.ajax({
        url: "/wp-admin/admin-ajax.php", //url, к которому обращаемся
        type: "POST",
        dataType: 'JSON',
        data: "action=send_tg_message&phone=" + phone + "&email=" + email + "&comment=" +comment + "&date=" + date,
        success: function(data){
            var status = data.status;
            if (status == 1) {
                $.fancybox.open({
                    src: '#test-covid-success',
                    type: 'inline'
                });
            } else if (status == 0) {
                $("#covid-test-error-msg").text('Проверьте, что Вы корректно заполнили обязательные поля и повторите действие.');
            } else if (status == 2) {
                $.fancybox.open({
                    src: '#schedule-modal-3',
                    type: 'inline'
                });
            }
        },
        error: function () {
            $.fancybox.open({
                src: '#schedule-modal-3',
                type: 'inline'
            });
        }
    });
});
$(function () {
    $('.proinput input[type="search"]').on('input', function () {
        let srt = $(this).val();
        if(srt.trim() !== ''){
            $(this).closest('.wpdreams_asl_container').addClass('active')
        }else {
            $(this).closest('.wpdreams_asl_container').removeClass('active')
        }

    });
    let hash = window.location.hash;
    if (hash === '#thanks' || hash === '#field-not-empty' || hash === '#file-too-large' || hash === '#something-went-wrong' || hash === '#make-an-appointment') {
        let src = '';
        if (hash === '#thanks'){
            src = '#test-covid-success';
        } else if (hash === '#field-not-empty'){
            src = '#modal-error-review';
        } else if (hash === '#file-too-large'){
            src = '#modal-error-size-file';
        } else if (hash === '#something-went-wrong'){
            src = '#schedule-modal-3';
        } else if (hash === '#make-an-appointment'){
            src = '#sign-up-modal';
        }
        $.fancybox.open({
            src: src,
            type: 'inline'
        });
    }

    let fields = document.querySelectorAll('.field__file');
    Array.prototype.forEach.call(fields, function (input) {
        let langSite  = document.documentElement.lang;
        let label = input.nextElementSibling,
            labelVal = label.querySelector('.field__file-fake').innerText;

        input.addEventListener('change', function (e) {
            let countFiles = '';
            if (this.files)
                countFiles = this.files[0].name;

            if (countFiles){
                let text = (langSite == 'ru') ? 'Выбрано: ' : 'Обрано: ';
                label.querySelector('.field__file-fake').innerText = text + countFiles;
            } else
                label.querySelector('.field__file-fake').innerText = labelVal;
        });
    });
});