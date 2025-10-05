<?php
// подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields() {
    add_meta_box( 'extra_fields', 'Привязка к врачу в API', 'extra_fields_box_func', 'doctor', 'normal', 'low'  );
}

function extra_fields_box_func( $post ){
    global $wpdb;
    $table = $wpdb->prefix . 'api_data_cache_doctors';
    $doctors = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM ". $table . " ORDER BY Name"
    ));
    $doctors_meta = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM ". $wpdb->prefix ."postmeta WHERE meta_key = 'api_doctor_id'"
    ));
    ?>
    <p>
        <select name="extra[api_doctor_id]">
            <option value="0" selected disabled>Выберите врача из списка</option>
            <?php foreach ($doctors as $doctor){ ?>
            <option <?php
            foreach ($doctors_meta as $meta) {
                if ($meta->post_id == get_the_ID() && $meta->meta_value == $doctor->api_id) {
                    echo 'selected';
                    break;
                }
            }
            ?> value="<?php echo $doctor->api_id; ?>"><?php echo $doctor->Name; ?></option>
            <?php } ?>
        </select>
    </p>

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <?php
}

add_action( 'save_post', 'my_extra_fields_update', 0 );

## Сохраняем данные, при сохранении поста
function my_extra_fields_update( $post_id ){
    // базовая проверка
    if (
        empty( $_POST['extra'] )
        || ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
        || wp_is_post_autosave( $post_id )
        || wp_is_post_revision( $post_id )
    ) {
        return false;
    }


    // Все ОК! Теперь, нужно сохранить/удалить данные
    $_POST['extra'] = array_map( 'sanitize_text_field', $_POST['extra'] ); // чистим все данные от пробелов по краям
    foreach( $_POST['extra'] as $key => $value ){

            if( empty($value) ){
                delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
                continue;
            }

            update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически

    }

    return $post_id;
}