imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    imgInpPreview.src = URL.createObjectURL(file)
  }
}

var modal = document.getElementById("profilePicture");
var uploadForm = document.getElementById("uploadForm");

function openChangeProfilePicture(){
  modal.style.display = "block";
  closeAccountSidebar();
}

function openUploadForm(){
  uploadForm.style.display = "block";
  closeAccountSidebar();
}


function closeProfilePictureModal(){
  modal.style.display = "none";
}

function closeUploadForm(){
  uploadForm.style.display = "none";
}

function openAccountSidebar() {
  document.getElementById("account-sidebar").style.right = "0";
}

function openBookmark() {
  document.getElementById("bookmark-sidebar").style.right = "0";
}

function openNotification() {
  document.getElementById("notification-sidebar").style.right = "0";
}

function closeAccountSidebar() {
  document.getElementById("account-sidebar").style.right = "-300px";
}
function closeBookmark() {
  document.getElementById("bookmark-sidebar").style.right = "-300px";
}

function closeNotification() {
  document.getElementById("notification-sidebar").style.right = "-300px";
}

function showBookmark(){
  $.ajax({
    method: 'get',
    url: 'showBookmarks.php',
    success: function(response){
      $('.bookmark-holder').html(response);
    }
  })
}

$(document).ready(function(){
  showBookmark();
  
  $('.upload-button').click(function(){
    window.location.href = "../upload";
  })

  $('.upload-button-mobile').click(function(){
    window.location.href = "../upload";
  })

  $('.filter-form').submit(function(event){
    $.ajax({
      type: 'post',
      url: 'filter.php',
      data: {
        keyword: $("input[name='keyword']").val(),
        department: $("#department").val(),
        date_from: $("input[name='date_from']").val(),
        date_to: $("input[name='date_to']").val()
      },
      success: function(response){
        console.log(response)
        $('#filter').hide();
        $('.thesis-result-container').html(response);
      }
    })
    event.preventDefault();
  })

  $('.save').click(function(){
    var target = $(this).attr('id');
    $(this).addClass('selected').addClass('unsave');
    $(this).removeClass('save');
    $.ajax({
      method: 'post',
      url: 'save.php',
      data: {
        unique_id: target
      },
      success: function(response){
        showBookmark();
      }
    })
  })

  $('.unsave').click(function(){
    var target = $(this).attr('id');
    $(this).addClass('save');
    $(this).removeClass('selected').removeClass('unsave');
    $.ajax({
      method: 'post',
      url: 'unsave.php',
      data: {
        unique_id: target
      },
      success: function(response){
        console.log(response);
        showBookmark();
      }
    })
  })


  $('.search-form').submit(function(event){
    var search = $("#main-search").val();
    $.ajax({
      method: 'post',
      url: 'search.php',
      data: {
        keyword: search
      },
      success: function(response){
        $('.thesis-result-container').html(response);
        console.log('1');
      }
    })

    event.preventDefault();
    
  })

  $('.filter-button').click(function(){
    $("#filter").show();
  })

  $('.close').click(function(){
    $(this).parent().parent().parent().hide();
  })

  // $('.open-thesis').click(function(){
  //   var target_url = $(this).attr('id');

  //   window.location.href = "../pdf-viewer/index.php?file=" + target_url;
  //   // let screensize = (window.screen.availHeight);
  //   //   if(screensize <= 736){
  //   //     var target_url = $(this).attr('title')
  //   //     window.location.href = "../" + target_url;
  //   //     // $(location).attr("href", "../" + target_url);
  //   //   }else {
  //   //     var target = $(this).parent().attr('title');
  //   //     $(location).attr("href", "../thesis/view.php?thesis=" + target);
  //   //   }
  // })
})