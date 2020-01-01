//Открытие и закрытие меню
  var i = 0;
  $('#burger').click(function(){
    if( i==0 )
    {
     $('.mobile-menu, .mobile-menu-bg').show("slow");
     i++;
   }
   else
   {
    $('.mobile-menu, .mobile-menu-bg').hide("slow");
    i = 0;
  }

});


//наведение на кнопку профиля
$("#profil_user_btn")
  .mouseover(function() {
    // навели курсор на объект
    $('#profil_user_btn img').attr('src', '/wp-content/uploads/profil_active.png');
  })
  .mouseout(function(){           
    // отвели курсор с объекта
    $('#profil_user_btn img').attr('src', '/wp-content/uploads/profil.png');
  });

//открытие текста вопроса
    $('.question').click(function (){
        var id = this.id;
        var block = $('#'+id+ ' .question-text').css('display');
        if (block == 'none')
        {
            $('#' + id + ' .question-text').slideDown("slow");
            $('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/open.png')
        }
        else
        {
            $('#' + id + ' .question-text').slideUp("slow");
            $('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/close.png')
        }

    });
    //exchange
    //open and close mobile form exchange
    $('.click_ex').click(function(){
        var id = this.id;
        var block = $('#'+id+ ' .tab-ex').css('display');
        if (block == 'none')
        {
            $('#' + id + ' .tab-ex').slideDown("slow");
            $('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/open.png')
        }
        else
        {
            $('#' + id + ' .tab-ex').slideUp("slow");
            $('#'+id + ' img').attr('src', '/wp-content/uploads/2019/12/close.png')
        }
    });