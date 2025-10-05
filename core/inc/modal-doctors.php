<div class="modal-with-footer" id="sign-up-modal-doctors">
    <div class="modal modal-xl">
        <div class="modal__title"><?php _e("Запись на прием",'mz') ?></div>
        <form class="form-default js__form-sing-up">
            <input type="hidden" name="action" value="send_mail_two">
            <input type="hidden" name="sign_up_special" value="sign_up_special">
            <div class="select-wrap w-100 input-form">
                <input type="hidden" class="js__chek-select" name="select-selected" value="">
                <select name="doctor" id="signUpSelectDoctors" data-placeholder="<?php _e('Выберите специалиста','mz') ?>"></select>
            </div>

            <label class="input-form"><?php _e('Имя','mz') ?>*
                <input type="text" name="name" required="">
            </label>

            <label class="input-form"><?php _e('Телефон','mz') ?>*
                <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
            </label>

            <div class="text-center">
                <button type="submit" class="btn w-100"><?php _e('записаться на приём','mz') ?></button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <?php $contacts = pods('header_contacts'); ?>
        <div class="modal-footer__top">
            <svg width="14" height="20" viewBox="0 0 14 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-pin">
                <path d="M6.99997 9.5C6.33693 9.5 5.70104 9.23661 5.2322 8.76777C4.76336 8.29893 4.49997 7.66304 4.49997 7C4.49997 6.33696 4.76336 5.70107 5.2322 5.23223C5.70104 4.76339 6.33693 4.5 6.99997 4.5C7.66301 4.5 8.2989 4.76339 8.76774 5.23223C9.23658 5.70107 9.49997 6.33696 9.49997 7C9.49997 7.3283 9.43531 7.65339 9.30967 7.95671C9.18403 8.26002 8.99988 8.53562 8.76774 8.76777C8.53559 8.99991 8.25999 9.18406 7.95668 9.3097C7.65337 9.43534 7.32828 9.5 6.99997 9.5ZM6.99997 0C5.14345 0 3.36298 0.737498 2.05022 2.05025C0.737467 3.36301 -3.05176e-05 5.14348 -3.05176e-05 7C-3.05176e-05 12.25 6.99997 20 6.99997 20C6.99997 20 14 12.25 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85649 0 6.99997 0Z"
                      fill="#707E98">
                </path>
            </svg>
            <?php echo $contacts->field('header_address_' . LOCALE); ?>
        </div>
        <div class="modal-footer__row">
            <div class="modal-footer__column">
                <div class="modal-footer__text">
                    <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone' )) ?>" class="">
                        <?php echo $contacts->field('header_phone'); ?>
                    </a>
                    <small>(Viber, Telegram, Whatsapp)</small>
                    <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_5' )) ?>" class="">
                        <?php echo $contacts->field('header_phone_5'); ?>
                    </a>
                </div>
            </div>
            <div class="modal-footer__column">
                <div class="modal-footer__text">
                    <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_2' )) ?>" class="">
                        <?php echo $contacts->field('header_phone_2'); ?>
                    </a>
                    <a href="tel:<?= '+'.preg_replace('/[^0-9]/', '', $contacts->field( 'header_phone_3' )) ?>" class="">
                        <?php echo $contacts->field('header_phone_3'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>