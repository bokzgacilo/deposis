let searchParams = new URLSearchParams(window.location.search);
let param = searchParams.get('page')

$(document).ready(function(){
  showTableData();

  $('.import-faculty').click(function(){
    $('#importModal').show();
  })
  $('.import-student').click(function(){
    $('#importStudent').show();
  })

  $('.add-single').click(function(){
    $('#importStudent').show();
  })

  $('.close').click(function(){
    $(this).parent().parent().parent().hide();
  })


  $('.deleteButton').click(function(){
    if(confirm('Are you sure want to delete this?')){
      var id = [];

      $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
      })
      
      if(id.length === 0){
        alert("Please Select atleast one checkbox");
      }else {
        $.ajax({
          method: 'post',
          url: 'delete.php',
          data:{ 
            id : id,
            table: param
          },
          success:function(){
            for(var i = 0; i < id.length; i++){
              $('td#' + id[i] + '').css('background-color', '#ccc');
              $('td#' + id[i] + '').fadeOut('slow');
            }
          }
        })
      }
    }
    
  })

  $('.refresh').click(function(){
    location.reload(true);
  })

  $('.approve').click(function(){
    if(confirm('Are you sure want to approve this?')){
      var id = [];

      $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
      })
      
      if(id.length === 0){
        alert("Please Select atleast one checkbox");
      }else {
        $.ajax({
          method: 'post',
          url: 'approve.php',
          data:{ 
            id : id
          },
          success:function(response){
            console.log(response);
            for(var i = 0; i < id.length; i++){
              $('td#' + id[i] + '').css('background-color', '#ccc');
              $('td#' + id[i] + '').fadeOut('slow');
            }
          }
        })
      }
    }
    
  })

  $('.archive').click(function(){
    if(confirm('Are you sure want to archive this?')){
      var id = [];

      $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
      })
      
      if(id.length === 0){
        alert("Please Select atleast one checkbox");
      }else {
        $.ajax({
          method: 'post',
          url: 'archive.php',
          data:{ 
            id : id
          },
          success:function(response){
            console.log(response);
            for(var i = 0; i < id.length; i++){
              $('td#' + id[i] + '').css('background-color', '#ccc');
              $('td#' + id[i] + '').fadeOut('slow');
            }
          }
        })
      }
    }
    
  })

  $('.coordinator').click(function(){
    if(confirm('Are you sure want to make this user/s a coordinator?')){
      var id = [];

      $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
      })
      
      if(id.length === 0){
        alert("Please Select atleast one checkbox");
      }else {
        $.ajax({
          method: 'post',
          url: 'coordinator.php',
          data:{ 
            id : id
          },
          success:function(response){
            console.log(response);
          }
        })
      }
    }
  })

  $('.representative').click(function(){
    if(confirm('Are you sure want to make this user/s a coordinator?')){
      var id = [];

      $(':checkbox:checked').each(function(i){
        id[i] = $(this).val();
      })
      
      if(id.length === 0){
        alert("Please Select atleast one checkbox");
      }else {
        $.ajax({
          method: 'post',
          url: 'representative.php',
          data:{ 
            id : id
          },
          success:function(response){
            console.log(response);
          }
        })
      }
    }
  })

  $('.deposis').click(function(){
    window.location = '../search';
  })
  

  $('#search').keyup(function(){
    var keyword = $(this).val();

    $.ajax({
      method: 'post',
      url: 'search.php',
      data: {
        keyword: keyword,
        table: param
      },
      success: function(response){
        $('.result-table').html(response);
      }
    })
  })
})

function showTableData(){
  $.ajax({
    type: 'post',
    url: 'query-2.php',
    data: {
      table: param,
    },
    success: function(response){
      $('.result-table').html(response);
    }
  })
}
