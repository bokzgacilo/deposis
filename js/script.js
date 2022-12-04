var modal = document.getElementById("myModal");
var btn = document.getElementById("openTAC");
var span = document.getElementsByClassName("close")[0];

// btn.onclick = function() {
//   modal.style.display = "block";
//   $('.open-filter-modal').click(function(){
//     // $('#filter').show()
//     alert('sdsd');
//   })
// }

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

$(document).ready(function(){
  $('.microsoft-login-button').click(function(){
    $('#myModal').css('display', 'flex');
  })
})