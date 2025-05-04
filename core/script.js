$('#userRegisterForm').on('submit', function(event){
    event.preventDefault();
    const formData = {
        username: $('#usernameField').val(),
        password: $('#passwordField').val(),
        verifyPassword: $('#verifyPasswordField').val(),
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
                window.location.href = "login.php?registerSuccess=1";
            } else {
                $('#failMessage').text(data.trim());
                $('#registerFailMessage').removeClass("hidden");
            }
        }
    })
})

$('#userLoginForm').on('submit', function(event){
    event.preventDefault();
    const formData = {
        username: $('#usernameField').val(),
        password: $('#passwordField').val(),
        userLoginRequest: 1
    };
    $.ajax({
        type: "POST",
        url: "core/handleForms.php",
        data: formData,
        success: function (data) {
            if (data.trim() == "loginSuccess") {
                window.location.href = "index.php"; // TODO: add '?loginSuccess=1' to link so there can be a message to say so.
            } else {
                $('#failMessage').text(data.trim());
                $('#loginFailMessage').removeClass("hidden");
            }
        }
    })
})
