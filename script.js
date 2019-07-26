$(document).on("click","#modal-pressed",function(){
  $(this).parents('form').submit();
})

$(document).on("click",".category-button",function(){
  let type = $(this).attr("type")
  if(type=="edit"){
    let id = $(this).attr("data-id")
    let name = $(this).attr("data-name")
    $('#category-modal form').attr("action",`${HOME}/ajax/category.php?action=edit`).end().find("#name").val(name).end().find("#category-id").val(id)
    $('#modal-pressed').text('Dəyiş')
  }else{
    $('#category-modal form').attr("action",`${HOME}/ajax/category.php?action=ad`)
    $('#modal-pressed').text('Əlavə et')
  }
})


$(document).on("click",".delete",function(){
  let id = $(this).attr("id")
  $.post(`${HOME}/ajax/category.php?action=delete`,{id:id},function(){
    window.location.href = window.location.href
  })
})
