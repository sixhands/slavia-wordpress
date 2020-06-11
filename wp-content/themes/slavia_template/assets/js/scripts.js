//Открытие и закрытие меню
  var i = 0;
jQuery('#burger').click(function(){
    if( i==0 )
    {
     jQuery('.mobile-menu, .mobile-menu-bg').show("slow");
     i++;
   }
   else
   {
    jQuery('.mobile-menu, .mobile-menu-bg').hide("slow");
    i = 0;
  }

});


//наведение на кнопку профиля
jQuery("#profil_user_btn")
  .mouseover(function() {
    // навели курсор на объект
    jQuery('#profil_user_btn img').attr('src', '/wp-content/uploads/2019/12/profil_active.png');
  })
  .mouseout(function(){           
    // отвели курсор с объекта
    jQuery('#profil_user_btn img').attr('src', '/wp-content/uploads/2019/12/profil.png');
  });

jQuery('div.question-text a').attr('target', '_blank');
//открытие текста вопроса
jQuery('.question-title').click(function (){
        var id = jQuery(this).parents('.question').attr('id');
        var block = jQuery('#'+id+ ' .question-text').css('display');
        if (block == 'none')
        {
            jQuery('#' + id + ' .question-text').slideDown("slow");
            jQuery('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/open.png')
        }
        else
        {
            jQuery('#' + id + ' .question-text').slideUp("slow");
            jQuery('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/close.png')
        }

    });

//Скрипты для страницы профиля
if (top.location.pathname === '/profile/') {
    //Делаем картинку текущего таба активной
    jQuery(document).ready(function () {
        let active_img = jQuery('#left-menu > li > a.active').find('img');
        let active_img_src = active_img.attr('src');
        if (active_img_src.includes('document_dis'))
            active_img.attr('src', active_img_src.replace('document_dis', 'documents_active'))
        else
            active_img.attr('src', active_img_src.replace('dis', 'active'));
    });
    jQuery('#left-menu > li').click(function () {
        //Меняем картинку текущего таба на активную
        let non_active_img = jQuery('#left-menu > li').not(this).find('img');
        non_active_img.each(function (index, item) {
            if (jQuery(item).attr('src').includes('active')) {
                if (jQuery(item).attr('src').includes('documents_active'))
                    jQuery(item).attr('src', jQuery(item).attr('src').replace('documents_active', 'document_dis'));
                else
                    jQuery(item).attr('src', jQuery(item).attr('src').replace('active', 'dis'));
            }
        });

        let active_img = jQuery(this).find('img');
        let active_img_src = active_img.attr('src');
        if (active_img_src.includes('document_dis'))
            active_img.attr('src', active_img_src.replace('document_dis', 'documents_active'))
        else
            active_img.attr('src', active_img_src.replace('dis', 'active'));
    });

    //Вывод мобильного левого меню
    jQuery('#left-mobile-menu-location').append('<select class="profil-mobile-menu w-100"></select>');
    jQuery('#left-menu > li').each(function(index, el){
        let el_url = jQuery(this).find("a").attr('href');
        let el_name = jQuery(this).find("p").text();
        jQuery('#left-mobile-menu-location > select').append('<option' + (el_url===window.location.href ? ' class="current-menu-item"' : '')
            + ' value="' + el_url + '">' + el_name + '</option>');
    });

}

jQuery(document).ready(function(){
    let curEl = jQuery("select.profil-mobile-menu.w-100 > option.current-menu-item");
    curEl.attr("selected", "selected");
    curEl.attr("disabled", "disabled");
});
jQuery('select.profil-mobile-menu.w-100').change(function(){

    let selectedVal = this.options[this.selectedIndex].value;
    window.location = selectedVal;
});