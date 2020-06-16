// Append Notice To Masonary Layout
function appendNotice(notice) {
    var [yyyy, m, d] = notice.date.split("-");

    var cardHeader =
        '<div class="card-header">\n' +
        '<h5 class="card-title  font-weight-bold mb-0">\n' +
        notice.title +
        "</h5>\n" +
        "<small>\n" +
        formatDate(parseInt(d), parseInt(m), parseInt(yyyy)) +
        "</small>\n" +
        "</div>\n";

    var cardBody = '<div class="card-body">\n' + notice.body + "</div>\n";

    var btnEdit =
        '<button class="btn btn-sm btn-indigo edit-notice" data-id="' +
        notice.id +
        '" data-toggle="modal" data-target="#Modal-Notice-Form"><i class="fas fa-edit mr-2"></i> Edit</button>\n';

    var btnDelete =
        '<button class="btn btn-sm btn-danger delete-notice" data-id="' +
        notice.id +
        '" data-toggle="modal" data-target="#Modal-Notice-Delete"><i class="fas fa-trash-alt mr-2"></i> Delete</button>\n';

    var $card = $(
        '<div class="grid-item col-12 col-sm-6 col-md-4 col-lg-3" id="Notice-Id-' +
        notice.id +
        '">\n' +
        '<div class="card text-white mb-3 view overlay ' +
        notice.color +
        '">\n' +
        cardHeader +
        cardBody +
        '<div class="mask flex-center rgba-blue-strong">\n' +
        btnEdit +
        btnDelete +
        "</div>\n</div>"
    );

    $noticeMason.append($card).masonry("appended", $card);
}

// Initialize Tiny Editor
tinymce.init({
    selector: "#Notice-Body",
    skin: "oxide-dark",
    content_css: "css/style.css",
    extended_valid_elements: "blockquote[class=blockquote]",
    plugins: "lists",
    toolbar:
        "undo redo | bold italic underline | fontsizeselect | alignleft aligncenter alignright alignjustify | blockquote | bullist numlist | subscript superscript | forecolor backcolor | outdent indent | removeformat",
    menubar: false,
    forced_root_block: "div",
    min_height: 250,
    max_height: 250
});

// Create Notice
$("#Create-Notice").click(function () {
    $("#Form-Notice").trigger("reset");
    $("#Notice-Id").val('');
});

// Store Notice
$("#Form-Notice").on("submit", function (e) {
    e.preventDefault();
    tinymce.triggerSave();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        type: "POST",
        url: "notice/store",
        data: $("#Form-Notice").serialize(),

        success: function (response) {
            $("#Btn-Form-Notice-Close").click();
            createToast("success", "Success", response.msg);

            if ( parseInt( $("#Notice-Id").val() ) === response.data.id ) {
                $noticeMason.masonry("remove", $("#Notice-Id-" + response.data.id)).masonry();
            }

            appendNotice(response.data);

            $("Form-Notice").trigger("reset");
            $("#Notice-Id").val("");
        },

        error: function (xhr) {
            $.each(xhr.responseJSON.errors, function (key, item) {
                if ($.isArray(item)) {
                    $.each(item, function (key, value) {
                        $("#Form-Notice-Error-Message").append(
                            "<li>" + value + "</li>"
                        );
                    });
                } else {
                    $("#Form-Notice-Error-Message").append(
                        "<li>" + item + "</li>"
                    );
                }
            });

            $("#Form-Notice-Error").removeClass("d-none");
            setTimeout(function () {
                $("#Form-Notice-Error").addClass("d-none");
                $("#Form-Notice-Error-Message").empty();
            }, 10000);
        }
    });
});

// Cliked To Edit Notice
$("body").on("click", ".edit-notice", function () {
    const id = $(this).data("id");
    $("Form-Notice").trigger("reset");
    $.get("notice/show/" + id).done(function (notice) {
        $("#Notice-Id").val(notice.id);
        $("#Notice-Color option[value='" + notice.color + "']").prop( "selected", true );
        $("#Notice-Date").val(notice.date);
        $("#Notice-Topic").val(notice.topic);
        $("#Notice-Title").val(notice.title);
        tinyMCE.activeEditor.setContent(notice.body);
    });
});

// Delete Notice
$("body").on("click", "#Btn-Delete-Notice", function () {
    var id = $(this).data("id");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "delete",
        url: "/notice/delete/" + id,
        success: function (response) {
            createToast("danger", "Success", response.msg);
            $noticeMason.masonry('remove', $("#Notice-Id-" + id)).masonry();
        },
        error: function (data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".delete-notice", function () {
    $("#Btn-Delete-Notice").data("id", $(this).data("id"));
});
