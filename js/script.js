$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


$(window).ready(function (){

  $('.toast').toast({delay: 3000});
  $('.toast').toast('show');

});