$(document).ready(function() {
  $("#novaComanda").submit(function(event) {
    event.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
      url: "criarComanda.php", // PHP script to process the registration data
      method: "POST",
      data: formData,
      success: function(response) {
        $("#messageContainer").text(response);
      },
      error: function(xhr, status, error) {
        console.log("An error occurred: " + error);
      }
    });
  });
});


