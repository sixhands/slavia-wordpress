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
    $('#profil_user_btn img').attr('src', 'img/profil_active.png');
  })
  .mouseout(function(){           
    // отвели курсор с объекта
    $('#profil_user_btn img').attr('src', 'img/profil.png');
  });
