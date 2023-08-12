
$(document).ready(function () {

  function checkNewRecords(){
    $.ajax({
      url: "check_new_records/check_new_records.php",
      success: function (result) {
        if (result === true){
          alert ("Soy laika");
          //location.reload();
        }
      }
    });
  }

  checkNewRecords();

  //setInterval(checkNewRecords,5000)
 
});
