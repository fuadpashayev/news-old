$(document).on("click","#modal-pressed",function(){
  $(this).parents('form').submit();
  $('input,textarea,select').val('')
})

$(document).on("click",".category-button",function(){
  let type = $(this).attr("type")
  if(type=="edit"){
    let id = $(this).attr("data-id")
    let name = $(this).attr("data-name")
    $('#category-modal form').attr("action",`${HOME}/ajax/category.php?action=edit`).end().find("#name").val(name).end().find("#category-id").val(id)
    $('#category-modal #modal-pressed').text('Dəyiş')
  }else{
    $('input,textarea,select').val('')
    $('#category-modal form').attr("action",`${HOME}/ajax/category.php?action=add`)
    $('#category-modal #modal-pressed').text('Əlavə et')
  }
})

$(document).on("click",".user-button",function(){
    let type = $(this).attr("type")
    if(type=="edit"){
        let id = $(this).attr("data-id")
        let name = $(this).attr("data-name")
        $.post(`${HOME}/ajax/user.php?action=get`,{id:id},function(res){
          let user = JSON.parse(res)
          Object.keys(user).map(function(key){
            $(`#${key}`).val(user[key])
          })
          $('#user-id').val(user.id)
        })
        $('#user-modal form').attr("action",`${HOME}/ajax/user.php?action=edit`)
        $('#password').parents('.form-group').hide()
        $('#user-modal #modal-pressed').text('Dəyiş')

    }else{
        $('input,textarea,select').val('')
        $('#user-modal form').attr("action",`${HOME}/ajax/user.php?action=add`)
        $('#password').parents('.form-group').show()
        $('#user-modal #modal-pressed').text('Əlavə et')
    }
})


$(document).on("click",".news-button",function(){
    let type = $(this).attr("type")
    if(type=="edit"){
        let id = $(this).attr("data-id")
        $.post(`${HOME}/ajax/news.php?action=get`,{id:id},function(res){
            let user = JSON.parse(res)
            Object.keys(user).map(function(key){
                $(`#${key}`).val(user[key])
            })
            $('#user-id').val(user.id)
        })
        $('#news-modal form').attr("action",`${HOME}/ajax/news.php?action=edit`)
        $('#photo').parents('.form-group').hide()
        $('#news-modal #modal-pressed').text('Dəyiş')

    }else{
        $('input,textarea,select').val('')
        $('#news-modal form').attr("action",`${HOME}/ajax/news.php?action=add`)
        $('#photo').parents('.form-group').show()
        $('#news-modal #modal-pressed').text('Əlavə et')
    }
})



$(document).on("click",".delete",function(){
  let id = $(this).attr("id")
  let type = $(this).attr("type")
  $.post(`${HOME}/ajax/${type}.php?action=delete`,{id:id},function(){
    window.location.href = window.location.href
  })
})
