function update() {
  var date = document.getElementById('input_date').value;
  var time = document.getElementById('input_time').value;
  var classroom = document.getElementById('input_classroom').value;
  console.log(date + " " +time);
  console.log(classroom);
  $.post("private/is_available.php", {"date": date, "time": time, "classroom": classroom }, function(data) {
    if(data){
      $("#aviable_msg").html("<i class='fa fa-check' style='color: green'></i>");
    }else{
      $("#aviable_msg").html("<i class='fa fa-times' style='color: red'></i>");
    }
  });
}

$(document).ready(function(){
  $('.main_title').click(function(){
    window.location.href = "index.html";
  })
})
