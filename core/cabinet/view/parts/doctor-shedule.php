<?php

?>
<div class="page-title-mobile">
    <h1><?php _e('Графік лікаря', 'mz'); ?></h1>
</div>
<div class="c-doctor-shedule-wrap">
    <div class="loading-frame loading-frame-select-download d-none">
        <svg width="32px" height="24px">
            <polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
            <polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
        </svg>
    </div>
    <span class="error-msg"></span>
    <form id="js-cabinet-create-doctor-shedule-data-form" class="form-default">
        <div class="select-month-block">
            <div class="select-month">
                <label class="select-label" for="month-select">Відділення</label>
                <div class="select-wrap" style="visibility: visible;">
                    <select id="month-select">
                        <option value="undefined" data-placeholder="true">Виберіть місяць</option>
                        <option value="01">01. Січень</option>
                        <option value="02">02. Лютий</option>
                        <option value="03">03. Березень</option>
                        <option value="04">04. Квітень</option>
                        <option value="05">05. Травень</option>
                        <option value="06">06. Червень</option>
                        <option value="07">07. Липень</option>
                        <option value="08">08. Серпень</option>
                        <option value="09">09. Вересень</option>
                        <option value="10">10. Жовтень</option>
                        <option value="11">11. Листопад</option>
                        <option value="12">12. Грудень</option>
                    </select>
                </div>
            </div>
            <div class="select-month-get-last-month">
                <a href="" data-routelink="" class="btn"
                   id="download-last-doctor-shedule"><?php _e("Завантажити останній графік", 'mz') ?></a>
            </div>
        </div>
        <div class="select-day-block" data-day="monday">
            <div class="select-day-block-title">
                <?php _e("Понеділок", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="monday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="monday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="monday-fields-clone"></div>
        </div>
        <div class="select-day-block gray" data-day="tuesday">
            <div class="select-day-block-title">
                <?php _e("Вівторок", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="tuesday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="tuesday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="tuesday-fields-clone"></div>
        </div>
        <div class="select-day-block" data-day="wednesday">
            <div class="select-day-block-title">
                <?php _e("Середа", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="wednesday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="wednesday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="wednesday-fields-clone"></div>
        </div>
        <div class="select-day-block gray" data-day="thursday">
            <div class="select-day-block-title">
                <?php _e("Четверг", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="thursday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="thursday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="thursday-fields-clone"></div>
        </div>
        <div class="select-day-block" data-day="friday">
            <div class="select-day-block-title">
                <?php _e("П'ятниця", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="friday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="friday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="friday-fields-clone"></div>
        </div>
        <div class="select-day-block gray" data-day="saturday">
            <div class="select-day-block-title">
                <?php _e("Субота", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="saturday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="saturday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="saturday-fields-clone"></div>
        </div>
        <div class="select-day-block" data-day="sunday">
            <div class="select-day-block-title">
                <?php _e("Неділя", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="sunday_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="sunday_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="sunday-fields-clone"></div>
        </div>
        <div class="select-day-block gray" data-day="vacation" id="vacation-template">
            <div class="select-day-block-title">
                <?php _e("Відпустка", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-dates">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select" name="vacation_start">
                                <option value="undefined" data-placeholder="true">Початок</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                                <option>24</option>
                                <option>25</option>
                                <option>26</option>
                                <option>27</option>
                                <option>28</option>
                                <option>29</option>
                                <option>30</option>
                                <option>31</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select" name="vacation_end">
                                <option value="undefined" data-placeholder="true">Кінець</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                                <option>24</option>
                                <option>25</option>
                                <option>26</option>
                                <option>27</option>
                                <option>28</option>
                                <option>29</option>
                                <option>30</option>
                                <option>31</option>
                            </select>
                        </div>
                    </label>
                </div>
                <div class="select-day-block-fields-btn">
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-vacation-button">додати</a>
                    </label>
                </div>
            </div>
            <div class="select-day-block-fields-clone" id="vacation-fields-clone"></div>
        </div>
        <div class="select-day-block" data-day="individual-day" id="individual-day-template">
            <div class="select-day-block-title">
                <?php _e("Індивідуальні дні", 'mz') ?>
            </div>
            <div class="select-day-block-fields">
                <div class="select-day-block-fields-dates">
                    <label class="input-form">
                        <?php _e("День", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select">
                                <option value="undefined" data-placeholder="true">Виберіть день</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                <option>17</option>
                                <option>18</option>
                                <option>19</option>
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option>23</option>
                                <option>24</option>
                                <option>25</option>
                                <option>26</option>
                                <option>27</option>
                                <option>28</option>
                                <option>29</option>
                                <option>30</option>
                                <option>31</option>
                            </select>
                        </div>
                    </label>
                </div>
                <div class="select-day-block-fields-time">
                    <label class="input-form">
                        <?php _e("Початок", 'mz') ?>
                        <input type="time" name="individual-day_start" placeholder="Оберіть час">
                    </label>
                    <label class="input-form">
                        <?php _e("Кінець", 'mz') ?>
                        <input type="time" name="individual-day_end" placeholder="Оберіть час">
                    </label>
                </div>
                <div class="select-day-block-fields-type">
                    <label class="input-form">
                        <?php _e("Тип", 'mz') ?>
                        <div class="select-wrap" style="visibility: visible;">
                            <select class="type-select" name="individual-day_type">
                                <option value="undefined" data-placeholder="true">Виберіть тип</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="break">Перерва</option>
                            </select>
                        </div>
                    </label>
                    <label class="input-form">
                        <a href="#" class="btn c-sidebar-mob-button add-individual-day-button">додати</a>
                    </label>
                </div>
                <div class="select-day-block-fields-clone" id="individual-day-fields-clone"></div>
            </div>
        </div>


        <div class="loading-frame loading-frame-select d-none">
            <svg width="32px" height="24px">
                <polyline id="back" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
                <polyline id="front" points="2 12 8 12 12 22 20 2 24 12 30 12"></polyline>
            </svg>
        </div>
        <div class="button-container">
            <a href="/cabinet/doctor-shedule/" class="btn btn-secondary" style="margin-top: 20px;">скасувати</a>
            <button class="btn btn-confirm" id="check-doctor-shedule">Зберегти</button>
        </div>
    </form>
</div>