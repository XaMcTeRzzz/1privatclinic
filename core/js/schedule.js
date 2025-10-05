function getMondayOfCurrentWeek(d) {
    var day = d.getDay();
    return new Date(d.getFullYear(), d.getMonth(), d.getDate() + (day == 0 ? -6 : 1) - day);
}

function getSundayOfCurrentWeek(d) {
    var day = d.getDay();
    return new Date(d.getFullYear(), d.getMonth(), d.getDate() + (day == 0 ? 0 : 7) - day);
}

function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}

function getMonthName(dat) {
    let date = new Date(dat); // 2009-11-10
    if (isValidDate(date)) {
        let langSite  = document.documentElement.lang;
        let locale = (langSite == 'ru') ? 'ru' : 'uk';
        return date.toLocaleString(locale, {
            month: 'long'
        });
    } else {
        return '';
    }
}

function getFullDate(dat) {
    let date = new Date(dat);
    if (isValidDate(date)) {
        let langSite  = document.documentElement.lang;
        let locale = (langSite == 'ru') ? 'ru' : 'uk';
        return date.toLocaleString(locale, {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    } else {
        return '';
    }
}

function getTime(dat) {
    var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

    if (dat && isSafari) {
        return new Date(dat.replace(/-/g, "/")).toLocaleString("default", {
            hour: "numeric",
            minute: "numeric"
        });
    } else {
        let date = new Date(dat);

        if (isValidDate(date)) {
            return date.toLocaleString("default", {
                hour: "numeric",
                minute: "numeric"
            });
        } else {
            return '';
        }
    }
}

function getDateForPopup(dat) {
    let date = new Date(dat);
    let options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };
    if (isValidDate(date)) {
        return date.toLocaleString('default', options);
    } else {
        return '';
    }
}

// console.log(getMondayOfCurrentWeek(new Date).toISOString().slice(0,10))
// console.log(getSundayOfCurrentWeek(new Date).toISOString().slice(0,10))

function get_time_mob(dat) {
    jQuery.fancybox.open({
        src: '#id_' + dat,
        toolbar: false,
        smallBtn: false
    })

}


function objectifyForm(formArray) {

    var returnArray = [];
    for (var i = 0; i < formArray.length; i++) {
        returnArray[formArray[i].name] = formArray[i].value;
    }
    return returnArray;
}

jQuery(document).on("click", "#send-reserv-button", function (e) {
    e.preventDefault();
    e.stopPropagation();

    jQuery('#schedule-modal').find('.preloader-modal-send').show();
    jQuery('#schedule-modal').find('.error-msg').hide();

    let data_arr = objectifyForm(jQuery('#form-send-request').serializeArray());
    // console.log(data_arr);
    const data_arr2 = objectifyForm(jQuery('#send-sms-form').serializeArray());

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'get_query_reserv',
            ...data_arr,
            ...data_arr2
        },
        success: function (data) {
            jQuery('#schedule-modal').find('.preloader-modal-send').hide();

            // console.log(data)
            let resp = data.data;
            if (data.success == false) {
                if(document.documentElement.lang == 'ru'){
                jQuery('#schedule-modal').find('.error-msg').text('Произошла ошибка соединения с сервером. Попробуйте еще раз.');
                } else {
                    jQuery('#schedule-modal').find('.error-msg').text('Виникла помилка з\'єднання з сервером. Спробуйте ще раз.');
                }
                jQuery('#schedule-modal').find('.error-msg').show();
            } else if (typeof resp !== 'undefined' && resp.HasErrors == true) {
                // if(resp.HasErrors == true) {
                jQuery('#schedule-modal').find('.error-msg').text(resp.Errors[0].Description);
                jQuery('#schedule-modal').find('.error-msg').show();
                // }
            } else if (resp == 'reserveFromCabinet') {
                window.localStorage.setItem('cabinet_need_appointments_reload', '1');

                jQuery.fancybox.close({
                    src: '#schedule-modal'
                })

                jQuery.fancybox.open({
                    src: '#schedule-modal-5'
                })

                const PhysicianId = jQuery('[name=PhysicianId]').val();
                const EmpId = jQuery('[name=EmpId]').val();
                if (PhysicianId && EmpId) {
                    get_schedule(PhysicianId, EmpId)
                }
            } else {
                jQuery.fancybox.close({
                    src: '#schedule-modal'
                })
                jQuery.fancybox.open({
                    src: '#schedule-modal-4'
                })
            }
        }
    })
})


jQuery(document).on("click", "#send-sms-button", function (e) {
    e.preventDefault();
    e.stopPropagation();
    let data_arr = objectifyForm(jQuery('#form-send-request').serializeArray())
    let data_arr2 = objectifyForm(jQuery('#send-sms-form').serializeArray())
    jQuery('#send-sms-form').find('.preloader-modal-send').show();
    // console.log(data_arr)
    // console.log(data_arr2)

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'send_reserve',
            ...data_arr,
            ...data_arr2
        },
        success: function (data) {
            // console.log(data)
            let resp = data.data;
            if (data.success == false) {
                if(document.documentElement.lang == 'ru'){
                jQuery('#schedule-modal-4').find('.error-msg-sms').text('Произошла ошибка соединения с сервером. Попробуйте еще раз.');
                } else {
                    jQuery('#schedule-modal-4').find('.error-msg-sms').text('Виникла помилка з\'єднання з сервером. Спробуйте ще раз.');
                }
            } else if (typeof resp !== 'undefined' && resp.HasErrors == true) {
                // if(resp.HasErrors == true) {
                jQuery('#schedule-modal-4').find('.error-msg-sms').text(resp.Errors[0].Description);
                // }
            } else {
                window.localStorage.setItem('cabinet_need_appointments_reload', '1');
                jQuery.fancybox.close({
                    src: '#schedule-modal-4'
                })
                jQuery.fancybox.open({
                    src: '#schedule-modal-5'
                })

                const PhysicianId = jQuery('[name=PhysicianId]').val();
                const EmpId = jQuery('[name=EmpId]').val();
                if (PhysicianId && EmpId) {
                    get_schedule(PhysicianId, EmpId)
                }
            }
        },
        complete: function () {
            jQuery('#send-sms-form').find('.preloader-modal-send').hide();
        }
    })

})


window.mobileCheck = function () {
    let check = false;
    (function (a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

function get_reserve(SelectedDateTime) {
    jQuery('.error-msg').text('');
    jQuery('.error-msg-sms').text('');

    const modalDocName = jQuery('#mini-card-doctor').find('.small-title:first').text() + ' ' + jQuery('#mini-card-doctor').find('.small-title:last').text();
    const modalDocProf = jQuery('#mini-card-doctor').find('.small-decr').text();
    const modalDocDateTime = getDateForPopup(SelectedDateTime) + ', ' + getTime(SelectedDateTime)

    jQuery('#schedule-modal-5').find('#modal-doc-name').text(modalDocName);
    jQuery('#schedule-modal-5').find('#modal-doc-prof').text(modalDocProf);
    jQuery('#schedule-modal-5').find('#modal-doc-date-time').text(modalDocDateTime);

    jQuery('#send-sms-form').find('[name=modalDocName]').val(modalDocName);
    jQuery('#send-sms-form').find('[name=modalDocProf]').val(modalDocProf);
    jQuery('#send-sms-form').find('[name=modalDocDateTime]').val(modalDocDateTime);

    jQuery('[name=SelectedDateTime]').val(SelectedDateTime);
    if (window.mobileCheck()) {
        jQuery('[name=ReservationType]').val('M');
    } else {
        jQuery('[name=ReservationType]').val('W');
    }

    is_cabinet_logged_in().then(data => {
        const form = jQuery('form#form-send-request');
        if (data) {
            form.find('#link-to-doctor').hide();

            if (data.PhoneNumber) {
                const PhoneNumber = data.PhoneNumber?.replace(/^\+38/, '').replace(/^38/, '').replace(/^8/, '');
                form.find('[name=PhoneNumber]').val(PhoneNumber).attr('readonly', true).css('color', '#6D6D6D');
            }

            if (data.BirthDate) {
                const BirthDate = data.BirthDate?.replace(/T00:00:00$/, '');//.split('-').reverse().join('.');
                form.find('[name=birthDate]').val(BirthDate).attr('readonly', true).css('color', '#6D6D6D');
            }

            if (data.Email) {
                const email = data.Email.split(',')[0].trim();
                form.find('[name=Email]').val(email);
            }
        } else {
            form.find('#link-to-doctor').show();
            form.find('[name=PhoneNumber]').val('').attr('readonly', false).attr('style', '');
            form.find('[name=birthDate]').val('').attr('readonly', false).attr('style', '');
            form.find('[name=Email]').val('');
        }
    })

    jQuery.fancybox.open({
        src: '#schedule-modal'
    })
    // console.log('get_reserve');
}
$('.schedule-card__bottom a.btn-t.btn').click(function (e) {
    $('.ss-option').attr('onclick',"closeMobile(this);");
    window.closeMobile = (d)=>{
        $('.ss-option').attr('onclick',"closeMobile(this);");
    }
    e.preventDefault();
    jQuery.fancybox.open({
        src: '#sign-up-modal'
    })
});
$('.send-cv__bottom').click(function (e) {
    e.preventDefault();
    jQuery.fancybox.open({
        src: '#sign-up-modal'
    })
});

function getLittleSchedule(doc_id) {

    jQuery('#littele-schedule-doctor').empty();
    let reception_days = (document.documentElement.lang == 'ru') ? 'Дни приема' : 'Дні прийому';
    let template = `<div class="schedule-calendar">
                    <div class="schedule-calendar-title">
                      <svg class="svg-sprite-icon icon-calendarMonth">
                        <use xlink:href="/wp-content/themes/medzdrav/core/images/svg/symbol/sprite.svg#calendarMonth"></use>
                      </svg><span>` + reception_days + `</span>
                    </div>
                    <table class="schedule-calendar-table">
                    `;

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'get_litle_schedule',
            doc_id: doc_id
        },
        success: function (data) {
            let is_no_schedule = true;
            let langSite  = document.documentElement.lang;
            if (typeof data.data !== 'undefined') {
                if (data.data['monday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'понедельник' : 'понеділок';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['monday'] + '</td></tr>'
                    is_no_schedule = false;
                }
                if (data.data['tuesday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'вторник' : 'вівторок';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['tuesday'] + '</td></tr>'
                    is_no_schedule = false;
                }
                if (data.data['wednesday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'среда' : 'середа';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['wednesday'] + '</td></tr>'
                    is_no_schedule = false;
                }
                if (data.data['thursday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'четверг' : 'четвер';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['thursday'] + '</td></tr>'
                    is_no_schedule = false;
                }
                if (data.data['friday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'пятница' : 'п\'ятниця';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['friday'] + '</td></tr>'
                    is_no_schedule = false;
                }
                if (data.data['saturday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'суббота' : 'субота';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['saturday'] + '</td></tr>'
                    is_no_schedule = false;
                }
                if (data.data['sunday'] != ' - ') {
                    let day = (langSite == 'ru') ? 'воскресенье' : 'неділя';
                    template = template + '<tr><th>' + day + '</th><td>' + data.data['sunday'] + '</td></tr>'
                    is_no_schedule = false;
                }

                template = template + '</table></div>'
                if (is_no_schedule) {
                    template = '';
                }
                jQuery('#littele-schedule-doctor').append(template)
            }
        }
    })
}

function get_schedule(api_id, EmpId, cancel_speciality_id, cancel_appointment_id, cancel_appointment_date) {

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'get_post_id_by_api_doctor_id',
            api_doctor_id: api_id
        },
        success: function (data) {
            jQuery('#link-to-doctor').attr('href', data.data);
        }
    });

    let langSite  = document.documentElement.lang;
    jQuery('[name=PhysicianId]').val(api_id);
    jQuery('[name=EmpId]').val(EmpId);
    jQuery('#table-week').empty();
    jQuery('<div class="indicator preloader-table-week" style="display: block;margin:50px auto; text-align: center;"><svg width="16px" height="12px"><polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline><polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline></svg></div>').insertBefore('#table-week');
    jQuery('#table-month').empty();
    jQuery('<div class="indicator preloader-table-month" style="display: block;margin:50px auto; text-align: center;"><svg width="16px" height="12px"><polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline><polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline></svg></div>').insertBefore('#table-month');
    jQuery('#schedule-table-mob-week').empty();
    jQuery('#schedule-table-mob-month').empty();

    if (cancel_speciality_id && cancel_appointment_id) {
        jQuery('#send-sms-form').find('[name=cancel_speciality_id]').val(cancel_speciality_id);
        jQuery('#send-sms-form').find('[name=cancel_api_id]').val(api_id);
        jQuery('#send-sms-form').find('[name=cancel_emp_id]').val(EmpId);
        jQuery('#send-sms-form').find('[name=cancel_appointment_id]').val(cancel_appointment_id);
        jQuery('#send-sms-form').find('[name=cancel_appointment_date]').val(cancel_appointment_date);
    } else {
        jQuery('#send-sms-form').find('[name=cancel_speciality_id]').val();
        jQuery('#send-sms-form').find('[name=cancel_api_id]').val();
        jQuery('#send-sms-form').find('[name=cancel_emp_id]').val();
        jQuery('#send-sms-form').find('[name=cancel_appointment_id]').val();
        jQuery('#send-sms-form').find('[name=cancel_appointment_date]').val();
    }

    jQuery('#mini-card-doctor').empty();
    jQuery('#mini-card-doctor').html(jQuery('#mini_cart_doctor_' + api_id).html());

    getLittleSchedule(api_id);

    $('.schedule-card__bottom .btn-t.btn').prop('disabled', true);


    if ($(window).width() < 992) {
        jQuery('.schedule-center-left').slideUp();

        // jQuery('.schedule-center-right').show();
    }
    jQuery('.schedule-center-right').show();


    if ($(window).width() > 992 && $(".schedule-top").length > 0) {
        $('html, body').animate({
            scrollTop: $(".schedule-top").offset().top
        }, 500);
    }

    let schedule_day;
    let schedule_time;

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        async: false,
        data: {
            action: 'get_header_contacts'
        },
        success: function (data) {
            schedule_day = data.data.row.headre_booking_by_phone_day;
            schedule_time = data.data.row.headre_booking_by_phone;
        }
    });
    
    if(langSite == 'ru'){
        var schedule_week_title = 'Врач в отпуске. За дополнительной информацией обращайтесь, пожалуйста, в Call-центр.';
        var schedule_week_desc = 'График работы Call-центра';
        var schedule_week_phone = 'Телефоны';
    } else {
        var schedule_week_title = 'Лікар у відпустці. За додатковою інформацією звертайтесь, будь ласка, до Call-центру.';
        var schedule_week_desc = 'Графік роботи Call-центру';
        var schedule_week_phone = 'Телефони';
    }

    let template_no_work_date_week = `<div class="colFlex">
                        <div class="stub-schedule__body mb-40-64">
                            <div class="stub-schedule__body-title">` + schedule_week_title + `</div>
                            <div class="stub-schedule__body-table">
                                <table>
                                    <caption class="title-gray">` + schedule_week_desc + `:</caption>
                                    <tbody><tr>
                                        <th>` + schedule_day + `</th>
                                        <td>` + schedule_time + `</td>
                                    </tr>
                                </tbody></table>
                            </div>
                            <div class="stub-schedule__body-list">
                                <p class="title-gray">` + schedule_week_phone + `:</p>
                                <ul>
                                    <li>+38 (057) 783 33 33</li>
                                    <li>+38 (073) 259 20 94</li>
                                    <li>+38 (098) 298 62 11</li>
                                    <li>+38 (050) 402 01 93</li>
                                </ul>
                            </div>
                        </div>
                    </div>`;


    if(langSite == 'ru'){
        var schedule_month_title = 'Врач в отпуске. За дополнительной информацией обращайтесь, пожалуйста, в Call-центр.';
        var schedule_month_desc = 'График работы Call-центра';
        var schedule_month_phone = 'Телефоны';
    } else {
        var schedule_month_title = 'Лікар у відпустці. За додатковою інформацією звертайтесь, будь ласка, до Call-центру.';
        var schedule_month_desc = 'Графік роботи Call-центру';
        var schedule_month_phone = 'Телефони';
    }

    let template_no_work_date_month = `<div class="colFlex">
                        <div class="stub-schedule__body mb-40-64">
                            <div class="stub-schedule__body-title">` + schedule_month_title + `</div>
                            <div class="stub-schedule__body-table">
                                <table>
                                    <caption class="title-gray">` + schedule_month_desc + `:</caption>
                                    <tbody><tr>
                                        <th>` + schedule_day + `</th>
                                        <td>` + schedule_time + `</td>
                                    </tr>
                                </tbody></table>
                            </div>
                            <div class="stub-schedule__body-list">
                                <p class="title-gray">` + schedule_month_phone + `:</p>
                                <ul>
                                    <li>+38 (057) 783 33 33</li>
                                    <li>+38 (073) 259 20 94</li>
                                    <li>+38 (098) 298 62 11</li>
                                    <li>+38 (050) 402 01 93</li>
                                </ul>
                            </div>
                        </div>
                    </div>`;


    let template = `<tr class="%ROW_CLASS%">
                      <td>%DATE%</td>
                      <td>%TIME%</td>
                      <td>%ALL_SLOTS%</td>
                      <td>%RESERVE_SLOTS%</td>
                      <td>%FREE_SLOTS%</td>
                      <td class="schedule-table-nav"> <button class="btn  btn-sm %BTN_CLASS%">%BTN_WORD%</button>
                          <div class="schedule-table-nav-wrap">
                          <table class="schedule-table-nav__table">
                              <tbody>
                              %TIME_SLOTS%
                              </tbody>
                          </table>
                          </div>
                      </td>
                  </tr>`;

    let enroll_text = (langSite == 'ru') ? 'записаться' : 'записатися';
    let template_mob = `<div class="schedule-table-mob %DISABLE_CLASS%">
                        <div class="schedule-table-mob-top">
                          <div class="schedule-table-mob-top__item">%DATE%</div>
                          <div class="schedule-table-mob-top__item">%TIME%</div>
                        </div>
                        <div class="schedule-table-mob-center">
                          <div class="schedule-table-mob-center__item">
                            Мест <b>%ALL_SLOTS%</b>
                          </div>
                          <div class="schedule-table-mob-center__item">
                            Занято <b>%RESERVE_SLOTS%</b>
                          </div>
                          <div class="schedule-table-mob-center__item">
                            Осталось <b>%FREE_SLOTS%</b>
                          </div>
                        </div>
                        <div class="schedule-table-mob-bottom">
                          <button class="btn btn-sm btn-w %DISABLE_CLASS_BTN%" onclick="get_time_mob('%PARAM2%')">` + enroll_text + `</button>
                          %TIME_SLOT_MOB_ENTER%
                        </div>
                      </div>`;

    let template_mob_time_slot = `<div id="%ID_DATE%" style="display: none;padding: 20px;">
                                <a href="javascript:;" data-fancybox-close class="link-back">
                                <svg class="svg-sprite-icon icon-arrowL">
                                        <use xlink:href="/wp-content/themes/medzdrav/core/images/svg/symbol/sprite.svg#arrowL"></use>
                                        </svg> к расписанию врача</a>
                                <div class="schedule-table-mob enter">
                                  <div class="schedule-table-mob-top">
                                    <div class="schedule-table-mob-top__item">%DATE%</div>
                                    <div class="schedule-table-mob-top__item">%TIME_INTERVAL_MOB%</div>
                                  </div>
                                  %TIME_SLOT_MOB%
                                </div>
                                </div>`;

    let template_mob_time_slot_row = `<div class="schedule-table-mob-center">
                                      <div class="schedule-table-mob-center__item">
                                        <span>%TIME%</span>
                                      </div>
                                      <div class="schedule-table-mob-center__item">
                                        %TIME_SLOT_BTN%
                                      </div>
                                    </div>`;

    let template_mob_time_slot_row_btn_enabled = `<button class="btn btn-sm" href="javascript:;" onclick="get_reserve('%PARAM2%')">записаться</button>`;
    let template_mob_time_slot_row_btn_disabled = `<span class="text-gray-bold">занято</span>`;

    let enroll = (langSite == 'ru') ? 'записаться' : 'записатися';
    let template_row_time_enabled = `<tr class="schedule-table-nav__table__item">
      <td>%TIME_SLOT%</td>
    <td><a class="js__addSchedule btn-sm btn" href="javascript:;" onclick="get_reserve('%PARAM1%')">` + enroll + `</a></td>
    </tr>`;
    let template_row_time_disable = `<tr class="schedule-table-nav__table__item disabled">
      <td>%TIME_SLOT%</td>
    <td><button class="btn-border-0">занято</button></td>
    </tr>`;

    let btn_class_ensbled = 'js__schedule';
    let btn_class_disabled = 'disabled';

    let disable_class_btn = 'btn btn-sm disabled';

    let row_class_disabled = 'disabled';
    let row_class_active = 'active';

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'get_schedule',
            api_id: api_id,
            EmpId: EmpId
        },
        success: function (data) {
            // console.log(data)
            let langSite  = document.documentElement.lang;
            jQuery('#tab-1 .preloader-table-week').remove();
            jQuery('#tab-2 .preloader-table-month').remove();
            $('.schedule-card__bottom .btn-t.btn').prop('disabled', false);

            let resp = data.data;
            let ii = 0;
            let ii_now_row = 0;
            let no_row = false;
            let key_old = '';
            for (let key in resp) {
                if (resp[key].enabled == 0) {
                    ii_now_row++;
                    no_row = true;
                }
                let time_slots = '';
                let time_slots_mob = '';
                let replace_string = template.replace(/%DATE%/g, getFullDate(key).replace(/г\./g, '').replace(/р\./g, ''))
                    .replace(/%TIME%/g, getTime(resp[key].min_time) + ' - ' + getTime(resp[key].max_time))
                    .replace(/%ALL_SLOTS%/g, (resp[key].all_slot == null) ? '' : resp[key].all_slot)
                    .replace(/%RESERVE_SLOTS%/g, (resp[key].reserve_slot == null) ? '' : resp[key].reserve_slot)
                    .replace(/%FREE_SLOTS%/g, (resp[key].free_slot == null) ? '' : resp[key].free_slot);

                let replace_string_mob = template_mob.replace(/%DATE%/g, getFullDate(key).replace(/г\./g, '').replace(/р\./g, ''))
                    .replace(/%TIME%/g, getTime(resp[key].min_time) + ' - ' + getTime(resp[key].max_time))
                    .replace(/%ALL_SLOTS%/g, (resp[key].all_slot == null) ? '' : resp[key].all_slot)
                    .replace(/%RESERVE_SLOTS%/g, (resp[key].reserve_slot == null) ? '' : resp[key].reserve_slot)
                    .replace(/%FREE_SLOTS%/g, (resp[key].free_slot == null) ? '' : resp[key].free_slot);

                if (resp[key].enabled == 1 && resp[key].free_slot != 0) {
                    replace_string = replace_string.replace(/%BTN_CLASS%/g, btn_class_ensbled)
                        .replace(/%ROW_CLASS%/g, '')
                        .replace(/%BTN_WORD%/g, (langSite == 'ru') ? 'записаться' : 'записатися')

                    replace_string_mob = replace_string_mob.replace(/%DISABLE_CLASS_BTN%/g, '')
                        .replace(/%DISABLE_CLASS%/g, '').replace(/%PARAM2%/g, key)
                } else {
                    replace_string = replace_string.replace(/%BTN_CLASS%/g, btn_class_disabled)
                        .replace(/%BTN_WORD%/g, (langSite == 'ru') ? 'запись закрыта' : 'запис закрито')
                        .replace(/%ROW_CLASS%/g, row_class_disabled)

                    replace_string_mob = replace_string_mob.replace(/%DISABLE_CLASS_BTN%/g, disable_class_btn)
                        .replace(/%DISABLE_CLASS%/g, row_class_disabled)
                }

                for (let key2 in resp[key].time) {
                    if (resp[key].time[key2].Reserved == 0) {
                        time_slots = time_slots + template_row_time_enabled.replace(/%TIME_SLOT%/g, getTime(resp[key].time[key2].StartTime) + ' - ' + getTime(resp[key].time[key2].FinalTime))
                            .replace(/%PARAM1%/g, resp[key].time[key2].StartTime)


                        //mobile
                        time_slots_mob = time_slots_mob + template_mob_time_slot_row.replace(/%TIME%/g, getTime(resp[key].time[key2].StartTime) + ' - ' + getTime(resp[key].time[key2].FinalTime))
                            .replace(/%TIME_SLOT_BTN%/g, template_mob_time_slot_row_btn_enabled.replace(/%PARAM2%/g, resp[key].time[key2].StartTime))
                    } else {
                        time_slots = time_slots + template_row_time_disable.replace(/%TIME_SLOT%/g, getTime(resp[key].time[key2].StartTime) + ' - ' + getTime(resp[key].time[key2].FinalTime))


                        //mobile
                        time_slots_mob = time_slots_mob + template_mob_time_slot_row.replace(/%TIME%/g, getTime(resp[key].time[key2].StartTime) + ' - ' + getTime(resp[key].time[key2].FinalTime))
                            .replace(/%TIME_SLOT_BTN%/g, template_mob_time_slot_row_btn_disabled)
                    }
                }

                let get_template_mob_time_slot = template_mob_time_slot.replace(/%DATE%/g, getFullDate(key).replace(/г\./g, '').replace(/р\./g, ''))
                    .replace(/%TIME_INTERVAL_MOB%/g, getTime(resp[key].min_time) + ' - ' + getTime(resp[key].max_time))
                    .replace(/%TIME_SLOT_MOB%/g, time_slots_mob)
                    .replace(/%ID_DATE%/g, 'id_' + key)


                replace_string_mob = replace_string_mob.replace(/%TIME_SLOT_MOB_ENTER%/g, get_template_mob_time_slot)

                replace_string = replace_string.replace(/%TIME_SLOTS%/g, time_slots)

                if (ii >= 0 && ii <= 6) {
                    if (ii == 0) {
                        let langSite  = document.documentElement.lang;
                        let date = (langSite == 'ru') ? 'Дата' : 'Дата';
                        let time = (langSite == 'ru') ? 'Время' : 'Час';
                        let all_place = (langSite == 'ru') ? 'Мест' : 'Місць';
                        let busy_place = (langSite == 'ru') ? 'Занято' : 'Зайнято';
                        let left_place = (langSite == 'ru') ? 'Осталось' : 'Залишилось';
                        jQuery('#table-week').append('<thead><tr><th>' + date + '</th><th>' + time + '</th><th>' + all_place + '</th><th>' + busy_place + '</th><th>' + left_place + '</th></tr></thead>')
                        jQuery('#table-week').append('<tbody class="schedule-table__tbody-parent">')
                        if (ii_now_row != ii + 1 && !no_row) {
                            jQuery('#table-week').append('<tr class="month"><th>' + getMonthName(key) + '</th></tr>')
                        }
                        // jQuery('#table-week').append('<tbody class="schedule-table__tbody-parent">')
                        // jQuery('#table-week').append('<tr class="month"><th>' + getMonthName(key) + '</th></tr>')
                    }

                    if ((key.slice(7, 10).indexOf("01") == 1 && ii != 0 && ii_now_row != ii + 1 && !no_row) || (ii != 0 && parseInt(key.slice(8, 10)) < parseInt(key_old.slice(8, 10)))) {
                        jQuery('#table-week').append(' </tbody> ').append('<tbody class="schedule-table__tbody-parent">').append('<tr class="month"><th>' + getMonthName(key) + '</th></tr>')
                        // jQuery('#table-week').append('<tbody class="schedule-table__tbody-parent">')
                        // jQuery('#table-week').append('</tbody>')
                        // jQuery('#table-week').append('<tbody class="schedule-table__tbody-parent"><tr class="month"><th>' + getMonthName(key) + '</th></tr>');

                    }

                    if (!no_row) {
                        jQuery('#table-week').append(replace_string)
                        jQuery('#schedule-table-mob-week').append(replace_string_mob)
                    }


                    if (ii == 6) {
                        jQuery('#table-week').append(' </tbody> ')
                    }
                }

                if (ii == 0) {
                    let date = (langSite == 'ru') ? 'Дата' : 'Дата';
                    let time = (langSite == 'ru') ? 'Время' : 'Час';
                    let all_place = (langSite == 'ru') ? 'Мест' : 'Місць';
                    let busy_place = (langSite == 'ru') ? 'Занято' : 'Зайнято';
                    let left_place = (langSite == 'ru') ? 'Осталось' : 'Залишилось';
                    jQuery('#table-month').append('<thead><tr><th>' + date + '</th><th>' + time + '</th><th>' + all_place + '</th><th>' + busy_place + '</th><th>' + left_place + '</th></tr></thead>')
                    jQuery('#table-month').append('<tbody class="schedule-table__tbody-parent">')
                    if (ii_now_row != ii + 1 && !no_row) {
                        jQuery('#table-month').append('<tr class="month"><th>' + getMonthName(key) + '</th></tr>')
                    }
                }
                if ((key.slice(7, 10).indexOf("01") == 1 && ii != 0 && ii_now_row != ii + 1 && !no_row) || (ii != 0 && parseInt(key.slice(8, 10)) < parseInt(key_old.slice(8, 10)))) {
                    // jQuery('#table-month').append('')
                    // jQuery('#table-month').append('')
                    jQuery('#table-month').append('</tbody>').append('<tbody class="schedule-table__tbody-parent">').append('<tr class="month"><th>' + getMonthName(key) + '</th></tr>')
                }
                if (!no_row) {
                    jQuery('#table-month').append(replace_string)
                    jQuery('#schedule-table-mob-month').append(replace_string_mob)
                }

                ii++;
                no_row = false;

                if (ii_now_row == 7 && ii == 7) {
                    // console.log(ii_now_row)
                    // console.log(ii)
                    jQuery('#table-week').empty();
                    jQuery('#table-week').append(template_no_work_date_week)
                    if ($(window).width() < 992) {
                        jQuery('#schedule-table-mob-week').empty();
                        jQuery('#schedule-table-mob-week').append(template_no_work_date_week)
                    }
                }
                key_old = key;
            }
            jQuery('#table-month').append('</tbody>')

            if (ii_now_row == 0 && ii == 0) {
                jQuery('#table-week').empty();
                jQuery('#table-week').append(template_no_work_date_week)
                if ($(window).width() < 992) {
                    jQuery('#schedule-table-mob-week').empty();
                    jQuery('#schedule-table-mob-week').append(template_no_work_date_week)
                }
            }

            if (ii_now_row == ii) {
                jQuery('#table-month').empty();
                jQuery('#table-month').append(template_no_work_date_month)
                if ($(window).width() < 992) {
                    jQuery('#schedule-table-mob-month').empty();
                    jQuery('#schedule-table-mob-month').append(template_no_work_date_month)
                }
            }

        }
    })

}

function get_doctors(speciality_id, cancel_api_id, cancel_emp_id, cancel_appointment_id, cancel_appointment_date) {
    jQuery('.schedule-center-left').empty();
    jQuery('.schedule-center-left').show(); //for mobile
    jQuery('.schedule-center-right').hide();

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'get_doctors',
            speciality_id: speciality_id
        },
        success: function (data) {

            let langSite  = document.documentElement.lang;

            let template = `<div class="schedule-card">
                            <div class="schedule-card__top">
                                <div class="schedule-card__img">
                                    <img src="%PHOTO%" alt="%NAME%">
                                </div>
                                <div class="schedule-card__text">
                                    <div class="small-title">%NAME%</div>
                                    <div class="small-decr">
                                        %SPECIALITY%, %CATEGORY%
                                    </div>
                                </div>
                            </div>
                            <div class="schedule-card__bottom">
                                <a href="/${get_locale.locale}%LINK%" class="link-bubbles" style="%STYLE_HIDDEN%">%MORE%</a>
                                <button class="btn-t btn" onclick="get_schedule(%API_ID%, %EMPID%)">%SCHEDULE%</button>
                                <div id="mini_cart_doctor_%API_ID%" style="display: none;">%MINI_CART_DOCTOR%</div>
                            </div>
                        </div>`;

            let template_mini_cart = `<div class="schedule-card-fill">
                                  <div class="schedule-card-fill__img">
                                    <img src="%PHOTO%" alt="%NAME%">
                                  </div>
                                  <div class="schedule-card-fill__text">
                                    <div class="small-title">%NAME_FIRST%</div>
                                    <div class="small-title">%NAME_LAST%</div>
                                    <div class="small-decr">%SPECIALITY%, %CATEGORY%</div>
                                  </div>
                                </div>`;

            let resp = data.data;
            let replace_string = '';
            let mini_cart_doctor = '';
            for (let i = 0; i < resp.length; i++) {
                mini_cart_doctor = template_mini_cart.replace(/%PHOTO%/g, (resp[i].img) ? resp[i].img : '/wp-content/themes/medzdrav/core/images/no_photo.png')
                    .replace(/%NAME%/g, resp[i].Name)
                    .replace(/%SPECIALITY%/g, resp[i].Speciality)
                    .replace(/%CATEGORY%/g, resp[i].Category)
                    .replace(/%NAME_FIRST%/g, resp[i].Name.split(" ")[0])
                    .replace(/%NAME_LAST%/g, resp[i].Name.split(" ")[1] + ' ' + resp[i].Name.split(" ")[2])

                replace_string = template.replace(/%NAME%/g, resp[i].Name)
                    .replace(/%SPECIALITY%/g, resp[i].Speciality)
                    .replace(/%CATEGORY%/g, resp[i].Category)
                    .replace(/%API_ID%/g, resp[i].api_id)
                    .replace(/%EMPID%/g, resp[i].EmpId)
                    .replace(/%PHOTO%/g, (resp[i].img) ? resp[i].img : '/wp-content/themes/medzdrav/core/images/no_photo.png')
                    .replace(/%LINK%/g, (resp[i].link) ? '/' + resp[i].link : '#')
                    .replace(/%STYLE_HIDDEN%/g, (resp[i].link) ? '' : 'visibility: hidden;')
                    .replace(/%MINI_CART_DOCTOR%/g, mini_cart_doctor)
                    .replace(/%MORE%/g, (langSite == 'ru') ? 'подробнее' : 'детальніше')
                    .replace(/%SCHEDULE%/g, (langSite == 'ru') ? 'расписание' : 'розклад')

                jQuery('.schedule-center-left').append(replace_string)
            }

            if (speciality_id && cancel_api_id && cancel_emp_id && cancel_appointment_id) {
                get_schedule(cancel_api_id, cancel_emp_id, speciality_id, cancel_appointment_id, cancel_appointment_date);
            } else {
                if (resp.length == 1) {
                    jQuery('.schedule-card__bottom button.btn-t.btn').trigger('click');
                }
            }
        }
    })
}

function get_specialists(cancel_speciality_id, cancel_api_id, cancel_emp_id, cancel_appointment_id, cancel_appointment_date) {

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: "POST",
        cache: false,
        data: {
            action: 'get_specialists'
        },
        success: function (data) {

            let resp = data.data;
            let arr = [];

            if(document.documentElement.lang == 'ru') {
            arr.push({
                text: 'Выберите направление',
                placeholder: true
            })
            } else {
                arr.push({
                    text: 'Виберіть направлення',
                    placeholder: true
                })
            }
            for (let i = 0; i < resp.length; i++) {
                arr.push({
                    text: resp[i].Name,
                    value: resp[i].api_id
                })
            }


            let selectSchedule = document.querySelector('#schedule-select');

            let select = new SlimSelect({
                select: selectSchedule,
                placeholder: true,
                showSearch: false,
                data: arr,
                beforeOnChange: (select) => {
                    jQuery('[name=SpecialityId]').val(select.value);
                    get_doctors(select.value)
                    console.log('s')
                }
            })
            /* формируем список с отделениями  с api   */
            let arrLinks = [];

            for (let i = 0; i < resp.length; i++) {
                arrLinks.push({
                    text: resp[i].Name,
                    value: resp[i].api_id
                })
            }

            let parentLink = document.querySelector('.selectLint');
            let str = '';

            arrLinks.forEach(function (item) {
                str += `<li>  
                    <a class="js__setToValueSelect" href="${item.value}">${item.text}</a>
                </li>`
            });
            parentLink.innerHTML = str;

            let linksValue = document.querySelectorAll('.js__setToValueSelect');
            let selectWrapper = document.querySelector('.select-wrap');
            let listLinksWrapper = document.querySelector('.listLinksWrapper');

            linksValue.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    selectWrapper.classList.remove('d-none')
                    listLinksWrapper.classList.add('d-none')
                    let value = this.getAttribute('href');
                    select.set(value)
                    jQuery('[name=SpecialityId]').val(value);
                    get_doctors(value)
                });
            });

            /* формируем список с отделениями  с api конец  */

            let choose_doc = getParameterByName('doctor_id')
            if (choose_doc != null && choose_doc != '') {
                jQuery.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: "POST",
                    cache: false,
                    data: {
                        action: 'get_doctor_ids_bysite',
                        choose_doc: choose_doc
                    },
                    success: function (data) {
                        let resp = data.data;
                        if (typeof resp !== 'undefined') {
                            select.set(resp.speciality_id);
                            setTimeout(function () {
                                if (jQuery('.schedule-center-left .schedule-card').length > 1) {
                                    get_schedule(resp.api_id, resp.EmpId)
                                }
                            }, 2500)

                        }
                    }
                })
            }

            jQuery('.select-wrap').css('visibility', 'visible');

            if (cancel_speciality_id && cancel_api_id && cancel_emp_id && cancel_appointment_id) {
                selectWrapper.classList.remove('d-none');
                listLinksWrapper.classList.add('d-none');
                select.set(cancel_speciality_id);
                jQuery('[name=SpecialityId]').val(cancel_speciality_id);
                get_doctors(cancel_speciality_id, cancel_api_id, cancel_emp_id, cancel_appointment_id, cancel_appointment_date);
            }
        }
    })
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
