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
                $('#mainMessage').text("Failed to Register User!");
                $('#subMessage').text(data.trim());
                $('#subMessage').removeClass('hidden');
                $('#message').addClass('bg-red-400');
                $('#message').removeClass('bg-green-400');
                $('#message').removeClass('hidden');
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
                $('#mainMessage').text("Failed to Log In!");
                $('#subMessage').text(data.trim());
                $('#subMessage').removeClass('hidden');
                $('#message').addClass('bg-red-400');
                $('#message').removeClass('bg-green-400');
                $('#message').removeClass('hidden');
            }
        }
    })
})

$('#postForm').on('submit', function(){
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
                $('#mainMessage').text("Failed to Submit Post!");
                $('#subMessage').text(data.trim());
                $('#subMessage').removeClass('hidden');
                $('#message').addClass('bg-red-400');
                $('#message').removeClass('bg-green-400');
                $('#message').removeClass('hidden');
            }
        }
    })
})

$('.editPostButton').on('click', function() {
    resetAllPostCommentAlterations();

    const post = $(this).closest('.post');
    const post_id = post.find('.post_id');
    const displayOnlyPostContent = post.find('.displayOnlyPostContent');
    const editablePostContent = post.find('.editablePostContent');
    const confirmationSection = post.find('.confirmationSection');
    const confirmMessage = post.find('.confirmMessage');
    const confirmButton = post.find('.confirmSec_Y');
    const cancelButton = post.find('.confirmSec_N');
    const commentSection = post.find('.commentSection');
    const lineSplitComment = post.find('.lineSplitComment');

    displayOnlyPostContent.addClass("hidden");
    commentSection.addClass("hidden");
    lineSplitComment.addClass("hidden");
    editablePostContent.removeClass("hidden");
    confirmMessage.text("Are you sure you want to edit this post?");
    confirmationSection.removeClass("hidden");
    
    $(confirmButton).on('click', function(event){
        if(displayOnlyPostContent.text().trim() !== editablePostContent.val().trim()) {
            const formData = {
                post_id: parseInt(post_id.text()),
                new_post_content: editablePostContent.val(),
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
                        $('#mainMessage').text("Failed to Edit Post!");
                        $('#subMessage').text(data.trim());
                        $('#subMessage').removeClass('hidden');
                        $('#message').addClass('bg-red-400');
                        $('#message').removeClass('bg-green-400');
                        $('#message').removeClass('hidden');
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
        lineSplitComment.removeClass("hidden");
    })
})

$('.deletePostButton').on('click', function() {
    resetAllPostCommentAlterations();

    const post = $(this).closest('.post');
    const post_id = post.find('.post_id');
    const confirmationSection = post.find('.confirmationSection');
    const confirmMessage = post.find('.confirmMessage');
    const confirmButton = post.find('.confirmSec_Y');
    const cancelButton = post.find('.confirmSec_N');
    const commentSection = post.find('.commentSection');
    const lineSplitComment = post.find('.lineSplitComment');

    commentSection.addClass("hidden");
    lineSplitComment.addClass("hidden");
    confirmMessage.text("Are you sure you want to delete this post?");
    confirmationSection.removeClass("hidden");
    
    $(confirmButton).on('click', function(event){
        const formData = {
            post_id: parseInt(post_id.text()),
            deletePostRequest: 1
        };
        $.ajax({
            type: "POST",
            url: handleFormDirectory,
            data: formData,
            success: function(data) {
                if(data.trim() == "postDeletionSuccess") {
                    window.location.href = "index.php?postDeleteSuccess=1"
                } else {
                    $('#mainMessage').text("Failed to Delete Post!");
                    $('#subMessage').text(data.trim());
                    $('#subMessage').removeClass('hidden');
                    $('#message').addClass('bg-red-400');
                    $('#message').removeClass('bg-green-400');
                    $('#message').removeClass('hidden');
                }
            }
        })
    })

    $(cancelButton).on('click', function(event){
        confirmationSection.addClass("hidden");
        commentSection.removeClass("hidden");
        lineSplitComment.removeClass("hidden");
    })
})

$('.commentForm').on('submit', function(event){
    event.preventDefault();
    const formData = {
        post_id: parseInt($(this).closest('.post').find('.post_id').text()),
        comment_content: $(this).find('.commentContent').val(),
        submitCommentRequest: 1
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: handleFormDirectory,
        data: formData,
        success: function(data) {
            if(data.trim() == "commentSubmissionSuccess") {
                window.location.href = "index.php?commentSubmissionSuccess=1"
            } else {
                $('#mainMessage').text("Failed to Submit Comment!");
                $('#subMessage').text(data.trim());
                $('#subMessage').removeClass('hidden');
                $('#message').addClass('bg-red-400');
                $('#message').removeClass('bg-green-400');
                $('#message').removeClass('hidden');
            }
        }
    })
})

$('.editCommentButton').on('click', function() {
    resetAllPostCommentAlterations();

    const comment = $(this).closest('.comment');
    const comment_id = comment.find('.comment_id');
    const displayOnlyCommentContent = comment.find('.displayOnlyCommentContent');
    const editableCommentContent = comment.find('.editableCommentContent');
    const confirmationSection = comment.find('.confirmationSection');
    const confirmMessage = comment.find('.confirmMessage');
    const confirmButton = comment.find('.confirmSec_Y');
    const cancelButton = comment.find('.confirmSec_N');

    displayOnlyCommentContent.addClass("hidden");
    editableCommentContent.removeClass("hidden");
    confirmMessage.text("Are you sure you want to edit this post?");
    confirmationSection.removeClass("hidden");
    
    $(confirmButton).on('click', function(event){
        if(displayOnlyCommentContent.text().trim() !== editableCommentContent.val().trim()) {
            const formData = {
                comment_id: parseInt(comment_id.text()),
                new_comment_content: editableCommentContent.val(),
                editCommentRequest: 1
            };
            $.ajax({
                type: "POST",
                url: handleFormDirectory,
                data: formData,
                success: function(data) {
                    if(data.trim() == "commentEditingSuccess") {
                        window.location.href = "index.php?commentEditSuccess=1"
                    } else {
                        $('#mainMessage').text("Failed to Edit Post!");
                        $('#subMessage').text(data.trim());
                        $('#subMessage').removeClass('hidden');
                        $('#message').addClass('bg-red-400');
                        $('#message').removeClass('bg-green-400');
                        $('#message').removeClass('hidden');
                    }
                }
            })
        }
    })

    $(cancelButton).on('click', function(event){
        editableCommentContent.addClass("hidden");
        confirmationSection.addClass("hidden");
        editableCommentContent.val(displayOnlyCommentContent.text().trim());
        displayOnlyCommentContent.removeClass("hidden");
    })
})

$('.deleteCommentButton').on('click', function() {
    resetAllPostCommentAlterations();
    
    const comment = $(this).closest('.comment')
    const comment_id = comment.find('.comment_id');
    const confirmationSection = comment.find('.confirmationSection');
    const confirmMessage = comment.find('.confirmMessage');
    const confirmButton = comment.find('.confirmSec_Y');
    const cancelButton = comment.find('.confirmSec_N');
    const commentSection = comment.find('.commentSection');

    commentSection.addClass("hidden");
    confirmMessage.text("Are you sure you want to delete this comment?");
    confirmationSection.removeClass("hidden");
    
    $(confirmButton).on('click', function(event){
        const formData = {
            comment_id: parseInt(comment_id.text()),
            deleteCommentRequest: 1
        };
        $.ajax({
            type: "POST",
            url: handleFormDirectory,
            data: formData,
            success: function(data) {
                if(data.trim() == "commentDeletionSuccess") {
                    window.location.href = "index.php?commentDeleteSuccess=1"
                } else {
                    $('#mainMessage').text("Failed to Delete Comment!");
                    $('#subMessage').text(data.trim());
                    $('#subMessage').removeClass('hidden');
                    $('#message').addClass('bg-red-400');
                    $('#message').removeClass('bg-green-400');
                    $('#message').removeClass('hidden');
                }
            }
        })
    })

    $(cancelButton).on('click', function(event){
        confirmationSection.addClass("hidden");
        commentSection.removeClass("hidden");
    })
})

function resetAllPostCommentAlterations() {
    $('#postsSection').find('.post').each(function() {
        const post = $(this);
        const displayOnlyPostContent = post.find('.displayOnlyPostContent');
        const editablePostContent = post.find('.editablePostContent');
        const postConfirmationSection = post.find('.confirmationSection');
        const PostCommentSection = post.find('.commentSection');
        const lineSplitComment = post.find('.lineSplitComment');
    
        editablePostContent.addClass("hidden");
        postConfirmationSection.addClass("hidden");
        editablePostContent.val(displayOnlyPostContent.text().trim());
        displayOnlyPostContent.removeClass("hidden");
        PostCommentSection.removeClass("hidden");
        lineSplitComment.removeClass("hidden");
    
        post.find('.comment').each(function() {
            const comment = $(this);
            const displayOnlyCommentContent = comment.find('.displayOnlyCommentContent');
            const editableCommentContent = comment.find('.editableCommentContent');
            const commentConfirmationSection = comment.find('.confirmationSection');
    
            editableCommentContent.addClass("hidden");
            commentConfirmationSection.addClass("hidden");
            editableCommentContent.val(displayOnlyCommentContent.text().trim());
            displayOnlyCommentContent.removeClass("hidden");
        })
    })
}