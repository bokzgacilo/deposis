<?php
  session_start();

  include('../connection.php');

  if($_SESSION['role'] != 'Representative' && !isset($_SESSION['email'])){
    header("location: ../?error=You need to login first");
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css"  rel ="stylesheet" type = "text/css">
    <link href="../css/base.css"  rel ="stylesheet" type = "text/css">
    <script src="../js/jquery.js"></script>
    <title>Upload Thesis - Deposis</title>
</head>
<body>
  <div class="alert-modal">
    <div class="alert-modal-content">
      <div class='alert-modal-header'>
        Alert
        <i class="close-alert fa-solid fa-xmark"></i>
      </div>
      <div class='alert-modal-body'>
        <p class="alert-message">Upload Complete..</p>
        <!-- <p class="alert-countdown">Refreshing in <span class="countdown">5</span> secs</p> -->
      </div>
    </div>
  </div>
  </div>
  <div class="">
    <header>
      <!-- <a href='../search'>Back</a> -->
      <div class="brand">
        <img src="../files/admin/deposis-white.png">
      </div>       
    </header>
    <main>
      <div class="search-proponent">
        <p>Select Author: </p>
        <div class="result">
        </div>
      </div>
      <p>Upload thesis</p>
      <form id='uploadForm'>
        <div>
          <p>Title</p>
          <input required type="text" placeholder="Thesis Title" name='title'> 
        </div>

        <div>
          <p>Abstract</p>
          <input required type="text" placeholder="Type or paste your thesis's abstract here." name='abstract'> 
        </div>
        <script>
          $(document).ready(function(){
            $('.close-alert').click(function(){
              $(this).parent().parent().parent().hide();
            })


            $('.author').keyup(function(){
              var author = $('.author').val();
              if(author != ''){
                $.ajax({
                  method: 'post',
                  url: 'search-proponent.php',
                  data: {
                    author: author
                  },
                  success: function(response){
                    $('.search-proponent').show();
                    $('.result').html(response);
                  }
                })
              }else {
                $('.search-proponent').hide();
              }
            })
            
          })

          function addMe(x){
            
            var selected = x;
            var picture_url = $(this).parents().text()  ;
            // console.log(picture_url)
            var newElement = "<input value='"+x+"' type='text' placeholder='Type authors name (Lastname, Firstname)' name='authors[]' readonly>";
            $('.author-container').append(newElement)
            $('.message').remove();
            $('.search-proponent').hide();
            $('.author').val('');
          }
          
        </script>
        <div class="authors">
          <p>Add Author<span></span></p>
          <input type="text"  class='author'  placeholder="Type author's name (Lastname, Firstname)" > 
          <div class="author-container">
            <p class="message">No author selected. Search user on the input above to add. Thanks!</p>
          </div>
        </div> 

        <div>
          <p>Publication Date:</p>
          <input required type="date" name='pubdate'>
        </div>

        <div>
          <p>Select Category:</p>
          <select name='category'>
            <option>Game</option>
            <option>Mobile</option>
            <option>Web</option>
          </select>
        </div>

        <div>
          <p class="group-label">Upload soft copy: </p>
          <input required class='group-input' type="file" name='soft_copy'> 
        </div>

        <div>
          <button type="submit">
            <i class="fa-solid fa-upload me-2"></i>
            Upload
          </button>
        </div>
      </form>
  </main>
  </div>

  <script defer>
    $(document).ready(function(){
      

      $('#uploadForm').submit(event => {
        event.preventDefault();

        var form = $('#uploadForm')[0];
        var data = new FormData(form);

        $.ajax({
          type: 'post',
          enctype: 'multipart/form-data',
          url: 'upload.php',
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          success: function (data) {
            // $('.alert-modal').css('display', 'flex');

            // if(data == 0){
            //   $('.alert-message').text('Thesis publication date is out of range.');
            // }

            // if(data == 3){
            //   $('.alert-message').text('Thesis uploaded successfully.');
            //   $('#uploadForm').trigger("reset");
            // }
            console.log(data)
          }
        })
      })
    })
  </script>
</body>
</html>