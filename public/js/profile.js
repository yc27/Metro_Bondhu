// Open File Dialog for Profile Photo Update
$("#Update-Profile-Photo").click(function(e) {
    e.preventDefault();
    $("#File-Profile-Photo").click();
});

// Submit Form to Update Profile Photo
$("#Form-Profile-Photo").on("change", "#File-Profile-Photo", function() {
    $("#Form-Profile-Photo").submit();
});

// Update Photo
$("#Form-Profile-Photo").on("submit", function(e) {
	e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "POST",
        url: "/profile/update/photo",
        data: new FormData(this),
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,

        success: function(response) {
            $("#User-Photo").attr("src", "img/admins/" + response.image);

            $("Form-Profile-Photo").trigger("reset");
            createToast("success", "Success", response.msg);
        },

        error: function(xhr) {
            $.each(xhr.responseJSON.errors, function(key, item) {
                if ($.isArray(item)) {
                    $.each(item, function(key, value) {
						createToast("danger", "ERROR", value);
                    });
                } else {
                    createToast("danger", "ERROR", item);
                }
            });
        }
    });
});

// Reveal/Unreveal Password Fields
$("#Change-Password").click(function(e) {
    e.preventDefault();
    $("#Passwords").slideToggle();
});

// Show Save Button
$("#Form-Profile").change(function() {
    $("#Save-Profile").fadeIn();
});

// Update Profile
$("#Form-Profile").on("submit", function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "POST",
        url: "/profile/update",
        data: $(this).serialize(),

        success: function (response) {
            $("#Form-Profile").trigger("reset");
            $("#Passwords").slideUp();
            $("#Save-Profile").fadeOut();

            $("#User-Name").text(response.name);
            $("#User-Name-Form").val(response.name);
            $("#User-Mobile-No-Form").val(response.mobile);

            createToast("success", "SUCCESS", response.msg);
        },

        error: function (xhr) {
            console.log(xhr);
            $.each(xhr.responseJSON.errors, function(key, item) {
                if ($.isArray(item)) {
                    $.each(item, function(key, value) {
                        createToast("danger", "ERROR", value);
                    });
                } else {
                    createToast("danger", "ERROR", item);
                }
            });
        }
    });
});
