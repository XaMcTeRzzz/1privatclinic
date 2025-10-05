
jQuery(function(){

    jQuery(".js__import-for-api").one( "click", function () {
        let thisBtn =  jQuery(this);
        jQuery.ajax({
            type : 'GET',
            url : ajaxurl,
            dataType: 'json',
            data:{
                action: 'get_services_from_api',
            },
            beforeSend: function (xhr) {
                thisBtn.text('Идет импорт');
                thisBtn.next().addClass('is-active')
            },
            success : function(data){
                thisBtn.text('Импорт завершен');
                thisBtn.next().removeClass('is-active');

                setTimeout(()=>{
                    thisBtn.text('Перезагрузка страницы');
                },2000);

                setTimeout(()=>{
                    location.reload()
                },3000);
            }
        });
    });


});