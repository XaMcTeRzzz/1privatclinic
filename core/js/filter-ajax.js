"use strict";

document.addEventListener('DOMContentLoaded', function () {
    function searchQueryFilter() {
        var arr_term_meta_id = [];
        var titleCat = '';
        var termType = '';
        $('[data-term-id].active').each(function () {
            var termId = $(this).data('term-id');
            titleCat = $(this).text().replace('(чекап)','');
            termType = $(this).data('term-type');
            arr_term_meta_id.push(termId);
        });

        if($('[data-term-id].active').length > 0){
            $('.btn-reset-filter').addClass('active')
        }else {
            $('.btn-reset-filter').removeClass('active')
        }

        var ajaxBlock = $('#ajax-block');
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'mia_get_filterd_posts',
                'args': arr_term_meta_id,
                'title': titleCat,
                'termType': termType
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function beforeSend(xhr) {
                $('.indicator').addClass('active');
            },
            success: function success(response) {
                if (response.success) {
                    ajaxBlock.html(response.data);
                    $('.indicator').removeClass('active');
                }
                $("html, body").animate({
                    scrollTop: 0
                }, 800);

                return false;
            },
        });
    }

    /* Удаляем шеврон если нет родителя */

    $('.js__reset-filter').click(function () {
        $('[data-term-id]').removeClass('active')
        $('.search-close__js').trigger('click');
        $(this).removeClass('active');
    });

    $('ul.children').each(function () {
        if ($(this).children().length === 0) {
            $(this).prev().hide();
        }
    });


    let buttonTerm =  $('[data-term-id]');

    buttonTerm.on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('active');
        buttonTerm.not($(this)).removeClass('active');
        let parentLi = $(this).closest('li');
        let childrenUl = parentLi.find('> .children');
        childrenUl.slideToggle();
        searchQueryFilter();
    });

    $('.search-bar__js').submit(function (e) {
        e.preventDefault();
    });


    //setup before functions
    let typingTimer;                //timer identifier
    let doneTypingInterval = 1000;  //time in ms, 5 second for example
    let $input = $('.input_search');
    let indicator = $('.indicator');
    let ajaxBlock = $('#ajax-block');



    $('.search-close__js').click(function () {
        $input.val('');
        doneTyping();
    });

//on keyup, start the countdown
    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    $input.on('input', function () {
        if($input.val()){
            $('.btn-reset-filter').addClass('active')
        }else{
            $('.btn-reset-filter').removeClass('active')
        }
    });

//on keydown, clear the countdown
    $input.on('keydown', function (e) {
        clearTimeout(typingTimer);
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });


//user is "finished typing," do something
    function doneTyping () {
        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'GET',
            dataType: 'json',
            cache: true,
            data: {
                action: 'mia_search_api_services',
                s: $input.val()
            },
            beforeSend: function beforeSend(xhr) {
                indicator.addClass('active');
            },
            success: function success(response) {
                let results = response.data;
                if (results.length) {
                    ajaxBlock.html(results);
                    indicator.removeClass('active');
                }
            }
        });
    }

    if ($input !== undefined && $input.length > 0 && $input.val() !== '') {
        doneTyping();
    }


    $input.on('keydown', function(e) {
        var regexp = /[бвгґджзклмнпрстфхцчшщйаеєиіїоуюяь]/gi
        if(!regexp.test($(this).val() && $(this).val() !== '')) {
            console.log('введите только латинские символы или пробелы')
        }
    });
});


