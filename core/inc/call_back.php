<div class="modal modal-xl" id="call-back">
    <div class="modal__title mb-30"><?php _e("Обратный звонок",'mz') ?></div>
    <form class="form-default js__call_back">
        <input type="hidden" name="action" value="send_mail_two">
        <input type="hidden" name="call_back" value="call_back">
        <label class="input-form"><?php _e('Имя','mz')?>*
            <input type="text" name="name" required="">
        </label>

        <label class="input-form"><?php _e('Телефон','mz')?>*
            <input type="tel" name="phone" placeholder="+38 (___) __ __ ___" required="">
        </label>

        <div class="text-center">
            <button type="submit" class="btn w-100"><?php _e("записаться на приём",'mz')?></button>
        </div>
    </form>
</div>