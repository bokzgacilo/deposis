

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
  closeNotification();
  closeBookmark();
  $('.filter-close').click();
}

function openFilter() {
  document.getElementById("filter").style.bottom = "0";
}

// function openFilter2() {
//   $('.open-filter-modal').click(function(){
//     $('#filter').show()
//   })
// }

function openBookmark() {
  document.getElementById("bookmark-sidebar").style.right = "0";
  closeAccountSidebar();
  closeNotification();
  $('.filter-close').click();
}

function openNotification() {
  document.getElementById("notification-sidebar").style.right = "0";
  closeAccountSidebar();
  closeBookmark();
  $('.filter-close').click();
}

function closeAccountSidebar() {
  document.getElementById("account-sidebar").style.right = "-100%";
}
function closeBookmark() {
  document.getElementById("bookmark-sidebar").style.right = "-100%";
}

function closeNotification() {
  document.getElementById("notification-sidebar").style.right = "-100%";
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
  $('.open-filter-modal').click(function(){
    $('#filter-web').css('display', 'flex');
  })

  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      imgInpPreview.src = URL.createObjectURL(file)
    }
  }

  showBookmark();

  $('.upload-button').click(function(){
    window.location.href = "../upload";
  })

  $('.view-my-thesis').click(function(){
    $('#my-thesis').show();
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
        $('#filter-web').css('display', 'none');
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
    var search_value = $("#main-search").val();

    $.ajax({
      method: 'post',
      url: 'search.php',
      data: {
        keyword: search_value
      },
      success: function(response){
        console.log(response);
        $('.thesis-result-container').html(response);
        $('#main-search').blur();
      }
    })

    event.preventDefault();
  })

  $('.category').click(function(){
    var category = $(this).attr('id');

    $.ajax({
      method: 'post',
      url: 'category.php',
      data: {
        category: category
      },
      success: function(response){
        $('.thesis-result-container').html(response);
      }
    })
  })

  $('.sort').click(function(){
    var condition = $(this).attr('id');

    $.ajax({
      method: 'post',
      url: 'sort.php',
      data: {
        condition: condition
      },
      success: function(response){
        $('.thesis-result-container').html(response);
      }
    })
  })

  $('.search-form-web').submit(function(event){
    var search_value = $("#main-search-web").val();

    $.ajax({
      method: 'post',
      url: 'search.php',
      data: {
        keyword: search_value
      },
      success: function(response){
        console.log(response);
        $('.thesis-result-container').html(response);
        $('#main-search-web').blur();
      }
    })

    event.preventDefault();
  })

  $('.filter-button').click(function(){
    $("#filter").css('display', 'flex');

    $(".filter-content").animate({
      bottom: 0
    }, 200)
    
    closeAccountSidebar();
    closeBookmark();
    closeNotification();
  })

  $('.filter-close').click(function(){
    $(".filter-content").animate({
      bottom: '-100%'
    }, 200, function(){
    $("#filter").css('display', 'none');
    })
  })

  $('.close').click(function(){
    $(this).parent().parent().parent().hide();
  }) 
})