$('#add-image').click(function(){
  //get number of futur fields
  const index = +$('#widgets-counter').val();

  //get prototype
  const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
  
  //add new template into the div
  $('#ad_images').append(tmpl);
  $('#widgets-counter').val(index +1);

  //handle delete
  handleDeleteButton();
})

function handleDeleteButton(){
  $('button[data-action="delete"]').click(function(){
    const target = this.dataset.target;
    $(target).remove();
  })
}

function updateCounter(){
  const count = +$('#ad_images div.form-group').length;
  $('#widgets-counter').val(count);
}
updateCounter();
handleDeleteButton();