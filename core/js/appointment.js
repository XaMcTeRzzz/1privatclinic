jQuery(document).ready(function ($) {
    let cachedSchedule = null;

    $(document).on("click", "#appointment-call", function () {
        $("#appointment-header").html(
            '<p>Графік прийому лікаря, та вільні місця</p>'
        );
        let doctorId = $("#appointment-container").data("doctor-id");

        $("#appointment-container").html(
            '<div class="indicator preloader-modal-send">' +
            '<svg width="32px" height="24px">' +
            '<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '</svg></div>'
        );

        getAppointmentHtml(doctorId);
    });

    function getAppointmentHtml(doctorId = 0) {
        $("#appointment-block").data("doctor-id", doctorId);

        // показываем прелоудер
        $("#appointment-block").show();

        $.post('/wp-admin/admin-ajax.php', {
            action: 'dd_get_schedule',
            doctor_id: doctorId
        }, function (response) {

            if (response && response.success) {
                cachedSchedule = response.data;
                renderSchedule(response.data);

                $("#appointment-container .indicator").hide();

            } else {
                $("#appointment-block").html('<p>❌ Не вдалося отримати розклад</p>');
            }
        }, 'json').fail(function () {
            $("#appointment-block").html('<p>⚠️ Помилка запиту до сервера</p>');
        });
    }

    function renderSchedule(data) {
        let daysHtml = '';

        data.forEach(function (day) {
            let slotsHtml = '';
            if (day.slots && day.slots.length > 0) {
                day.slots.forEach(function (time) {
                    slotsHtml += `<button class="time-slot" data-date="${day.dateFull}" data-time="${time}">${time}</button>`;
                });
            } else {
                slotsHtml = `<div class="no-slots">Немає доступних записів</div>`;
            }

            daysHtml += `
        <div class="day-column">
            <div class="day-header">${day.date}<br><span>${day.weekday}</span></div>
            <div class="time-list">${slotsHtml}</div>
        </div>`;
        });

        let html = `
    <div class="appointment-slider">
        <button class="slider-btn prev" disabled>←</button>
        <div class="appointment-scroll">${daysHtml}</div>
        <button class="slider-btn next">→</button>
    </div>`;

        $("#appointment-block").html(html);

        const $slider = $("#appointment-block .appointment-slider");
        const $scroll = $slider.find(".appointment-scroll");
        const columnsCount = $scroll.find(".day-column").length;

        if (columnsCount <= 7) {
            $scroll.addClass("full-width");
            $slider.addClass("no-arrows");
        } else {
            $scroll.removeClass("full-width");
            $slider.removeClass("no-arrows");
            toggleArrows($slider);
        }
    }


    // Управління стрілками
    $(document).on("click", ".appointment-slider .slider-btn", function () {
        const $slider = $(this).closest(".appointment-slider");
        const $scroll = $slider.find(".appointment-scroll");
        const scrollAmount = $scroll.width();

        if ($(this).hasClass("next")) {
            $scroll.animate({scrollLeft: $scroll.scrollLeft() + scrollAmount}, 400, function () {
                toggleArrows($slider);
            });
        } else {
            $scroll.animate({scrollLeft: $scroll.scrollLeft() - scrollAmount}, 400, function () {
                toggleArrows($slider);
            });
        }
    });

    function toggleArrows($slider) {
        const $scroll = $slider.find(".appointment-scroll");
        const scrollLeft = $scroll.scrollLeft();
        const maxScroll = $scroll[0].scrollWidth - $scroll.outerWidth();

        $slider.find(".slider-btn.prev").prop("disabled", scrollLeft <= 0);
        $slider.find(".slider-btn.next").prop("disabled", scrollLeft >= maxScroll - 5);
    }

    // Кнопка "Назад до розкладу"
    $(document).on("click", ".back-to-schedule", function () {
        // читаем атрибут, по умолчанию cache
        const mode = $(this).data("mode") || 'api';
        const doctorId = $("#appointment-block").data("doctor-id") || 0;


        $("#appointment-header").html(
            '<p>Графік прийому лікаря, та вільні місця</p>'
        );

        // Показываем прелоудер
        $("#appointment-block").html(
            '<div class="row-btn justify-center">' +
            '<div class="indicator preloader-modal-send">' +
            '<svg width="32px" height="24px">' +
            '<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '</svg></div>' +
            '</div>'
        );

        if (mode === 'cache' && cachedSchedule) {
            renderSchedule(cachedSchedule);
        } else {
            getAppointmentHtml(doctorId);
        }
    });

    // Клик по слоту времени → форма
    $(document).on("click", ".time-slot", function () {
        $("#appointment-header").html(
            '<p>Для запису спершу потрібно ідентифікуватися та вибрати послугу, на яку бажаєте записатися.<br>Заповніть, будь ласка, поля нижче.</p>'
        );

        let time = $(this).data("time");
        let date = $(this).data("date");
        let doctorId = $("#appointment-block").data("doctor-id");

        // Показываем прелоудер
        $("#appointment-block").html(
            '<div class="row-btn justify-center">' +
            '<div class="indicator preloader-modal-send">' +
            '<svg width="32px" height="24px">' +
            '<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '</svg></div>' +
            '</div>'
        );

        $.post('/wp-admin/admin-ajax.php', {
            action: 'dd_get_services',
            doctor_id: doctorId
        }, function (response) {

            if (response && response.success) {
                let optionsHtml = '<option data-placeholder="true"></option>';

                response.data.forEach(function (service) {
                    optionsHtml += `
                    <option value="${service.id}" data-duration="${service.duration}">
                        ${service.name} — ${service.price} грн
                    </option>`;
                });

                let doctorId = $("#appointment-container").data("doctor-id");
                let formHtml = `
            <form class="form-default js__form-sing-up">
                <input type="hidden" name="doctor_id" value="${doctorId}">
                <input type="hidden" name="date" value="${date}">
                <input type="hidden" name="time" value="${time}">

                <label class="input-form">
                  Послуга
                  <div class="select-wrap w-100 input-form">
                    <select name="service" id="serviceSS" data-placeholder="Виберіть послугу" required>
                        ${optionsHtml}
                    </select>
                  </div>
                </label>                

                <label class="input-form">Дата народження*<input type="date" name="birth_date" required></label>
                <label class="input-form">Телефон*<input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required></label>
               
                <div class="text-center" style="margin-top:15px;">
                    <button type="submit" class="btn w-100">Записатися на прийом</button>
                    <button type="button"
                        class="btn btn-secondary w-100 back-to-schedule"
                        data-mode="cache"
                        style="margin-top:10px;">
                        ← Назад до розкладу
                    </button>
                </div>
            </form>`;

                $("#appointment-block").html(formHtml);

                // Init Mask
                initInputMask();

                // SlimSelect
                let serviceSelect = document.querySelector('#serviceSS');
                if (serviceSelect) {
                    let slim = new SlimSelect({
                        select: serviceSelect,
                        placeholder: serviceSelect.getAttribute('data-placeholder'),
                        showSearch: false,
                    });

                    slim.open(); // сразу раскрыть список
                }
            } else {
                $("#appointment-block").html('<p>❌ Не вдалося отримати послуги</p>');
            }
        }, 'json');
    });


    function initInputMask() {
        const inputTels = document.querySelectorAll('input[type="tel"]');

        if (inputTels != null) {
            inputTels.forEach(inputTel => {
                Inputmask({
                    "mask": "+38 (999) 99 99 999"
                }).mask(inputTel);
            });
        }
    }

    // Отправка формы
    $(document).on("submit", ".js__form-sing-up", function (e) {
        e.preventDefault();
        let $form = $(this);

        // Собираем данные формы в объект
        let formData = {};
        $form.serializeArray().forEach(function (field) {
            formData[field.name] = field.value;
        });

        // Добавляем длительность выбранной услуги
        let selectedOption = $('#serviceSS').find(':selected');
        if (selectedOption.length) {
            formData['service_duration'] = selectedOption.data('duration');
        }

        $("#appointment-block").data("pending-form", formData);

        $("#appointment-block").html(
            '<div class="row-btn justify-center">' +
            '<div class="indicator preloader-modal-send">' +
            '<svg width="32px" height="24px">' +
            '<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
            '</svg>' +
            '</div>' +
            '</div>'
        );

        $.post('/wp-admin/admin-ajax.php', {
            action: 'dd_send_sms_code',
            form_data: formData
        }, function (response) {
            if (response && response.success) {
                showSmsCodeForm(formData);
            } else {
                $("#appointment-block").html('<p>❌ Не вдалося відправити код СМС</p>');
            }
        }, 'json').fail(function () {
            $("#appointment-block").html('<p>⚠️ Помилка запиту до сервера</p>');
        });
    });


    function showSmsCodeForm(formData) {
        $("#appointment-header").html(
            '<h3>Введіть код підтвердження</h3>' +
            '<p>Ми надіслали код на ваш телефон</p>'
        );

        let html = `
            <div class="sms-code-confirm text-center">
                <input type="text" name="sms_code" class="sms-code-input" maxlength="6" style="font-size:18px;text-align:center;">
                <button type="button" class="btn btn-primary w-100 confirm-sms-code" style="margin-top:15px;">
                    Підтвердити код
                </button>
                <button type="button"
                        class="btn btn-secondary w-100 back-to-schedule"
                        data-mode="cache"
                        style="margin-top:10px;">
                    ← Назад до розкладу
                </button>
            </div>`;
        $("#appointment-block").html(html);

        // Сохраняем данные формы в атрибуте, чтобы использовать после подтверждения
        $("#appointment-block").data("pending-form", formData);
    };

    $(document).on("click", ".confirm-sms-code", function () {
        let code = $(".sms-code-input").val().trim();
        let formData = $("#appointment-block").data("pending-form");

        if (code === "") {
            alert("Введіть код");
            return;
        }

        $.post('/wp-admin/admin-ajax.php', {
            action: 'dd_verify_and_save',
            sms_code: code,
            form_data: formData
        }, function (response) {
            if (response && response.success) {
                const data = response.data;

                if (data.status === 'not_found') {
                    // 1. Пацієнт не знайдений

                    // получаем дату в формате yyyy-mm-dd
                    const rawDate = formData.birth_date;
                    // если есть значение и оно в нужном формате
                    let formattedDate = rawDate;
                    if (rawDate && rawDate.includes('-')) {
                        const parts = rawDate.split('-');
                        formattedDate = parts[2] + '.' + parts[1] + '.' + parts[0];
                    }
                    $("#appointment-header").html(
                        '<p>Вибачте, ми не знайшли користувача з такими даними:</p>' +
                        '<p><strong>Дата народження:</strong> ' + formattedDate + '</p>' +
                        '<p><strong>Телефон:</strong> ' + formData.phone + '</p>' +
                        '<p>Заповніть, будь ласка, поля для створення картки</p>'
                    );

                    let extraForm = `
                        <form class="form-default js__form-new-patient">
                          <input type="hidden" name="doctor_id" value="${formData.doctor_id}">
                          <input type="hidden" name="date" value="${formData.date}">
                          <input type="hidden" name="time" value="${formData.time}">
                          <input type="hidden" name="service" value="${formData.service}">
                          <input type="hidden" name="phone" value="${formData.phone}">
                          <input type="hidden" name="birth_date" value="${formData.birth_date}">
                          <input type="hidden" name="service_duration" value="${formData.service_duration}">
                          
                          <label class="input-form">Прізвище*<input type="text" name="last_name" required></label>
                          <label class="input-form">Імʼя*<input type="text" name="first_name" required></label>
                          <label class="input-form">По батькові<input type="text" name="middle_name"></label>
                          <label class="input-form">Email<input type="email" name="email"></label>
                    
                          <label class="input-form">
                          Стать*
                          <div class="select-wrap w-100">
                            <select name="gender" id="genderSelect" data-placeholder="Виберіть стать" required>
                              <option data-placeholder="true"></option>
                              <option value="Male">Чоловіча</option>
                              <option value="Female">Жіноча</option>
                            </select>
                          </div>
                        </label>
                    
                          <div class="text-center" style="margin-top:15px;">
                            <button type="submit" class="btn w-100">Записати нового пацієнта</button>
                            <button type="button"
                                    class="btn btn-secondary w-100 back-to-schedule"
                                    data-mode="cache"
                                    style="margin-top:10px;">
                                ← Назад до розкладу
                            </button>
                          </div>
                        </form>
                      `;
                    $("#appointment-block").html(extraForm);

                    // SlimSelect
                    let serviceSelect = document.querySelector('#genderSelect');
                    if (serviceSelect) {
                        let slim = new SlimSelect({
                            select: serviceSelect,
                            placeholder: serviceSelect.getAttribute('data-placeholder'),
                            showSearch: false,
                        });
                    }
                }

                if (data.status === 'single') {
                    // 2. Один пацієнт — показуємо успіх (або створюємо запис)
                    $("#appointment-header").html('');
                    $("#appointment-block").html(`
                    <div class="appointment-success text-center">
                        <h3>Запис створено!</h3>
                        <p>Наш менеджер зв'яжеться з вами найближчим часом.</p>
                        <button type="button" class="btn back-to-schedule" style="margin-top:15px;">← Назад до розкладу</button>
                    </div>
                `);
                }

                if (data.status === 'multiple') {
                    // 3. Декілька пацієнтів — показуємо кнопки для вибору
                    $("#appointment-header").html(
                        '<p>За вказаними даними знайдено кількох пацієнтів.</p>' +
                        '<p>Будь ласка, оберіть потрібного зі списку нижче.</p>'
                    );

                    let html = `
                        <div class="text-center" style="margin-top:15px;">
                    `;

                    data.patients.forEach(function (p) {
                        html += `
                            <button class="btn w-100 select-patient" data-id="${p.id}" style="margin-top:10px;">
                                ${p.lastName} ${p.firstName} ${p.patronymicName}
                            </button>
                        `;
                    });

                    html += `
                            <button type="button"
                                    class="btn btn-secondary w-100 back-to-schedule"
                                    data-mode="cache"
                                    style="margin-top:10px;">
                                ← Назад до розкладу
                            </button>
                        </div>
                    `;

                    $("#appointment-block").html(html);

                    // зберігаємо formData для подальшого використання при виборі пацієнта
                    $("#appointment-block").data("pending-form", formData);
                }
            } else {
                $(".sms-code-input").val('');
                alert("Невірний код, спробуйте ще раз");
            }
        }, 'json').fail(function () {
            alert("⚠️ Помилка перевірки коду");
        });
    });

    // Клик по кнопке выбора пациента
    $(document).on("click", ".select-patient", function () {
        // id выбранного пациента
        let patientId = $(this).data("id");
        // данные формы, которые мы сохранили ранее
        let formData = $("#appointment-block").data("pending-form");

        // вызываем AJAX для создания заявки по выбранному пациенту
        $.post('/wp-admin/admin-ajax.php', {
            action: 'dd_create_appointment', // этот PHP-action должен обработать создание заявки
            patient_id: patientId,
            form_data: formData
        }, function (response) {
            if (response && response.success) {
                $("#appointment-header").html('');
                $("#appointment-block").html(`
                <div class="appointment-success text-center">
                    <h3>Запис створено!</h3>
                    <p>Наш менеджер зв'яжеться з вами найближчим часом.</p>
                    <button type="button"
                        class="btn btn-secondary w-100 back-to-schedule"
                        style="margin-top:10px;">
                        ← Назад до розкладу
                    </button>
                </div>
            `);
            } else {
                alert("Помилка створення заявки");
            }
        }, 'json').fail(function () {
            alert("⚠️ Помилка сервера при створенні заявки");
        });
    });
});

// Отправка формы нового пациента
$(document).on("submit", ".js__form-new-patient", function (e) {
    e.preventDefault();
    let $form = $(this);

    // собираем данные
    let newPatientData = {};
    $form.serializeArray().forEach(function (field) {
        newPatientData[field.name] = field.value;
    });

    // показываем прелоудер
    $("#appointment-block").html(
        '<div class="row-btn justify-center">' +
        '<div class="indicator preloader-modal-send">' +
        '<svg width="32px" height="24px">' +
        '<polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
        '<polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>' +
        '</svg>' +
        '</div>' +
        '</div>'
    );

    // отправляем на сервер
    $.post('/wp-admin/admin-ajax.php', {
        action: 'dd_create_new_patient', // PHP-action создаёт пациента и запись
        form_data: newPatientData
    }, function (response) {
        if (response && response.success) {
            $("#appointment-header").html('');
            $("#appointment-block").html(`
                <div class="appointment-success text-center">
                    <h3>Запис створено!</h3>
                    <p>Наш менеджер зв'яжеться з вами найближчим часом.</p>
                    <button type="button"
                            class="btn back-to-schedule"
                            style="margin-top:15px;">
                        ← Назад до розкладу
                    </button>
                </div>
            `);
        } else {
            alert("Помилка створення нового пацієнта");
        }
    }, 'json').fail(function () {
        alert("⚠️ Помилка сервера при створенні нового пацієнта");
    });
});