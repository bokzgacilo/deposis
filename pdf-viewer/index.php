<?php
  session_start();

  include('../connection.php');
  $target = $_GET['file'];
  $document_url = '';
  $document_title = '';
  $document_comments = '';

  $result = $conn -> query("SELECT * FROM approved WHERE unique_id='$target'");
  while($row = $result -> fetch_array()){
    $document_title = $row['title'];
    $document_url = $row['document_url'];
    $document_comments = $row['comments'];
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="shortcut icon" type="image/x-icon" href="../files/admin/deposis-icon.ico" />
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="../js/jquery.js"></script>
    <title><?php echo $document_title; ?></title>
  </head>
  <body>
    <div id='comments-mobile'>
      <div class="comment-body">
        <div class="comment-header">
          <p>Comments</p>
          <i class="close fa-solid fa-x"></i>
        </div>
        <div class="comment-list">
          <!-- Insert comments here. -->
        </div>
        <div class="comment-input">
          <div id='commentForm'>
            <div class="star-rating">
              <input type="radio" value="1" name="rate">1
              <input type="radio" value="2" name="rate">2
              <input type="radio" value="3" name="rate">3
              <input type="radio" value="4" name="rate">4
              <input type="radio" value="5" name="rate" checked>5
            </div>
            <button class="btn btn-primary cast-rate">Rate</button>
          </div>
          <div id='commentForm'>
            <input type="text" id="comment" value='' placeholder="Post comment">
            <button id='<?php echo $target;?>' class="btn btn-primary post">Post</button>
          </div>
        </div>
      </div>
    </div>

    <div id='comments-web'>
      <div class="comment-body">
        <div class="comment-header">
          <p>Comments</p>
          <i class="close-web fa-solid fa-x"></i>
        </div>
        <div class="comment-list">

        </div>
        <div id='commentForm'>
          <input type="text" id="comment-web" value='' placeholder="Post comment">
          <button id='<?php echo $target;?>' class="btn btn-primary post-web">Post</button>
        </div>
      </div>
    </div>

    <header class="top-bar">
      <div class='top-bar-a'>
        <a href='../search/'>
          Back
        </a>
        <i class="message fa-solid fa-message"></i>
      </div>
      <div class='top-bar-b'>
        
        <button class="btn" id="prev-page">
          <i class="fa fa-arrow-circle-left"></i> Prev Page
        </button>
        <span class="page-info">
          Page <span id="page-num"></span> of <span id="page-count"></span>
        </span>
        <button class="btn" id="next-page">
          Next Page <i class="fa fa-arrow-circle-right"></i>
        </button>
        
      </div>
    </header>

    

    <div id="rate-modal">
      <div class="rate-modal">
        <div class="rate-modal-header">
          <p>Rate</p>
          <i class="close-rate fa-solid fa-x"></i>
        </div>
        <div class="rate-modal-body">
          <div class="star-rating">
            <input type="radio" value="1" name="rate">1
            <input type="radio" value="2" name="rate">2
            <input type="radio" value="3" name="rate">3
            <input type="radio" value="4" name="rate">4
            <input type="radio" value="5" name="rate" checked>5
          </div>
        </div>
        <div class="rate-modal-footer">
          <button class="btn btn-primary cast-rate">Rate</button>
        </div>
      </div>
    </div>
    <div class="open-rate-button" title='Show comments'>
      <i class="fa-solid fa-star fa-xl"></i>
    </div>

    <div class="open-comments-button" title='Show rate  '>
      <i class="message fa-solid fa-message fa-xl"></i>
    </div>
    <canvas id="pdf-render"></canvas>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script>
      function getAllComment(){
        $('.comment-list').html('');

        var documments = '<?php echo $document_comments; ?>';

        $.ajax({
          type: 'get',
          url: 'getComments.php',
          data: {
            comments: documments
          },
          success: function(response){
            $('.comment-list').html(response);
          }
        })
      }

      $(document).ready(function(){
        getAllComment();
        // $.ajax({
        //   type: 'get',
        //   url: 'getComments.php',
        //   data: {
        //     comments: documments
        //   },
        //   success: function(response){
        //     $('.comment-list').html(response);
        //   }
        // })
        // getAllComment();

        $('.open-rate-button').click(function(){
          $('#rate-modal').css('display', 'flex');
        })
        $('.close-rate').click(function(){
          $('#rate-modal').css('display', 'none');
        })

        $('.cast-rate').click(function(){
          let ratebox = $("input[name='rate']:checked").val();

          if(ratebox == ''){
            alert('Please cast your rate')
          }else {
            $.ajax({
              type: 'post',
              url: 'rate.php',
              data: {
                rate: ratebox,
                file: <?php echo $target; ?>
              },
              success: function(response){
                $('#rate-modal').css('display', 'none');
                if(response == 1){
                  alert('You already rated this thesis.');
                }else {
                  alert('Rate successfully');
                }
              }
            })
          }
        })


        $('.post').click(function(){
          var comment_value = $('#comment').val();

          if(comment_value == ''){
            console.log('no value.');
          }else {
            $.ajax({
              type: 'post',
              url: 'comment.php',
              data: {
                comment: comment_value,
                file: $(this).attr('id')
              },
              success: function(response){
                // $('.comment-list').html('');
                // $('#comment').val('');
                // alert('Comment Posted');
                getAllComment();
              }
            })
          }
        })  
        $('.post-web').click(function(){
          var comment_value = $('#comment-web').val();

          if(comment_value == ''){
            console.log('no value.');
          }else {
            $.ajax({
              type: 'post',
              url: 'comment.php',
              data: {
                comment: comment_value,
                file: $(this).attr('id')
              },
              success: function(response){
                // $('.comment-list').html('');
                $('#comment-web').val('');
                if(response == 0){
                  alert('Invalid comment - has bad words. ');
                }else {
                  // getAllComment();
                }
              }
            })
          }
        })  

        $('.close').click(function(){
          $('#comments-mobile').css('right', '-100vw');
          $('.comment-list').html('');
        })

        $('.message').click(function(){
          $('#comments-mobile').css('right', '0');
          getAllComment();
        })

        $('.open-comments-button').click(function(){
          $('#comments-web').show();
        })

        $('.close-web').click(function(){
          $('#comments-web').hide();
        })
      })
    </script>
    <script>
      const url = '../<?php echo $document_url; ?>';
      
      let pdfDoc = null,
      pageNum = 1,
      pageIsRendering = false,
      pageNumIsPending = null;

      const scale = 1.5,
        canvas = document.querySelector('#pdf-render'),
        ctx = canvas.getContext('2d');

      // Render the page
      const renderPage = num => {
        pageIsRendering = true;

        // Get page
        pdfDoc.getPage(num).then(page => {
          // Set scale
          const viewport = page.getViewport({ scale });
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          const renderCtx = {
            canvasContext: ctx,
            viewport
          };

          page.render(renderCtx).promise.then(() => {
            pageIsRendering = false;

            if (pageNumIsPending !== null) {
              renderPage(pageNumIsPending);
              pageNumIsPending = null;
            }
          });

          // Output current page
          document.querySelector('#page-num').textContent = num;
        });
      };

      // Check for pages rendering
      const queueRenderPage = num => {
        if (pageIsRendering) {
          pageNumIsPending = num;
        } else {
          renderPage(num);
        }
      };

      // Show Prev Page
      const showPrevPage = () => {
        if (pageNum <= 1) {
          return;
        }

        pageNum--;
        queueRenderPage(pageNum);
      };

      // Show Next Page
      const showNextPage = () => {
        if (pageNum >= pdfDoc.numPages) {
          return;
        }
        pageNum++;
        queueRenderPage(pageNum);
      };

      // Get Document
      pdfjsLib
        .getDocument(url)
        .promise.then(pdfDoc_ => {
          pdfDoc = pdfDoc_;

          document.querySelector('#page-count').textContent = pdfDoc.numPages;

          renderPage(pageNum);
        })
        .catch(err => {
          // Display error
          const div = document.createElement('div');
          div.className = 'error';
          div.appendChild(document.createTextNode(err.message));
          document.querySelector('body').insertBefore(div, canvas);
          // Remove top bar
          document.querySelector('.top-bar').style.display = 'none';
        });

      // Button Events
      document.querySelector('#prev-page').addEventListener('click', showPrevPage);
      document.querySelector('#next-page').addEventListener('click', showNextPage);

      
    </script>
  </body>
</html>

<?php
  $conn -> close();
?>