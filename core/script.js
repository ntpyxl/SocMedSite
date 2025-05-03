$('#userRegisterForm').on('submit', function(event){
    event.preventDefault();
    const formData = {
        username: $('#usernameField').val(),
        password: $('#passwordField').val(),
        firstname: $('#firstnameField').val(),
        lastname: $('#lastnameField').val(),
        userRegisterRequest: 1
    };
    $.ajax({
        type: "POST",
        url: "core/handleForms.php",
        data: formData,
        success: function (data) {
            if (data.trim() == "registrationSuccess") {
                window.location.href = "login.php"; // TODO: add '?registerSuccess=1' to link so there can be a message to say so.
            } else {
                $('#registrationMessage').text("Registration failed. Try again.");
            }
        }
    })
})

