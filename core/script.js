const handleFormDirectory = "core/handleForms.php";

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
        url: handleFormDirectory,
        data: formData,
        success: function(data) {
            if(data.trim() == "registrationSuccess") {
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
        url: handleFormDirectory,
        data: formData,
        success: function(data) {
            if(data.trim() == "loginSuccess") {
                window.location.href = "index.php?loginSuccess=1"
            } else {
                $('#failMessage').text(data.trim());
                $('#loginFailMessage').removeClass("hidden");
            }
        }
    })
})

$('#postForm').on('submit', function(event){
    const formData = {
        postContent: $('#postContent').val(),
        submitPostRequest: 1
    };
    $.ajax({
        type: "POST",
        url: handleFormDirectory,
        data: formData,
        success: function(data) {
            if(data.trim() == "postSubmissionSuccess") {
                window.location.href = "index.php?postSubmissionSuccess=1"
            } else {
                $('#failMessage').text(data.trim());
                $('#postFailedMessage').removeClass("hidden");
            }
        }
    })
})

////////////////////////////////////////////////
////////////////////////////////////////////////

$('.editPostButton').on('click', function(event) {
    const post_id = $(this).closest('.post').find('.post_id');
    const displayOnlyPostContent = $(this).closest('.post').find('.displayOnlyPostContent');
    const editablePostContent = $(this).closest('.post').find('.editablePostContent');
    const confirmationSection = $(this).closest('.post').find('.confirmationSection');
    const confirmMessage = $(this).closest('.post').find('.confirmMessage');
    const confirmButton = $(this).closest('.post').find('.confirmSec_Y');
    const cancelButton = $(this).closest('.post').find('.confirmSec_N');
    const commentSection = $(this).closest('.post').find('.commentSection');

    displayOnlyPostContent.addClass("hidden");
    commentSection.addClass("hidden");
    editablePostContent.removeClass("hidden");
    confirmMessage.text("Are you sure you want to edit this post?");
    confirmationSection.removeClass("hidden");
    
    $(confirmButton).on('click', function(event){
        if(displayOnlyPostContent.text().trim() !== editablePostContent.val().trim()) {
            const formData = {
                post_id: parseInt(post_id.text()),
                newPostContent: editablePostContent.val(),
                editPostRequest: 1
            };
            $.ajax({
                type: "POST",
                url: handleFormDirectory,
                data: formData,
                success: function(data) {
                    if(data.trim() == "postEditingSuccess") {
                        window.location.href = "index.php?postEditSuccess=1"
                    } else {
                        $('#failMessage').text(data.trim());
                        $('#editPostFailedMessage').removeClass("hidden");
                    }
                }
            })
        }
    })

    $(cancelButton).on('click', function(event){
        editablePostContent.addClass("hidden");
        confirmationSection.addClass("hidden");
        editablePostContent.val(displayOnlyPostContent.text().trim());
        displayOnlyPostContent.removeClass("hidden");
        commentSection.removeClass("hidden");
    })
})