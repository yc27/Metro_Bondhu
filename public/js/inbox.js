// Update Unseen Message Counter
function updateUnseenMessagesCount(val) {
    $("#Sidebar-Unseen-Messages-Count").text(val);

    if (val > 0) {
        $(".Inbox")
            .removeClass("custom-blue-1")
            .addClass("yellow-text");

        $("#Sidebar-Unseen-Messages-Count")
            .removeClass("d-none")
            .addClass("d-block");
    } else {
        $(".Inbox")
            .removeClass("yellow-text")
            .addClass("custom-blue-1");

        $("#Sidebar-Unseen-Messages-Count")
            .removeClass("d-block")
            .addClass("d-none");
    }
}

// Set Message As Seen
function setMessageRowSeen(id) {
    $("#Message-Id-" + id)
        .removeClass("unseen-message")
        .addClass("seen-message");
    
    const $icon = $("#Message-Id-" + id).find(".mark-message");
    $icon.prop("title", "Mark As Uneen");
    $icon.removeClass("fa-envelope-open").addClass("fa-envelope");
}

// Set Message As Unseen
function setMessageRowUnseen(id) {
    $("#Message-Id-" + id)
        .removeClass("seen-message")
        .addClass("unseen-message");
    
    const $icon = $("#Message-Id-" + id).find(".mark-message");
    $icon.prop("title", "Mark As Seen");
    $icon.removeClass("fa-envelope").addClass("fa-envelope-open");
}

// Close Message
$(".message-close").click(function (e) {
    e.preventDefault();

    $("#Message-View").fadeOut("slow");
    $(".inbox-content").fadeIn("slow");

    $(".inbox").animate(
        {
            height: $(".inbox-content").height()
        },
        1000
    );
});

// Set Content For Message View
function viewMessage(message) {
    $("#Message-Sender-Name").text(message.name);
    $("#Message-Sender-Email").text(message.email);
    $("#Message-Date").text(formatDateTime(new Date(message.created_at)));
    $("#Message-Body").html(message.message);

    $(".inbox-content").fadeOut("slow");
    $("#Message-View").fadeIn("slow");

    $("#Message-View").height(
        Math.max(
            $("#Message-Header").outerHeight() +
            $("#Message-Body").innerHeight(),
            250
        )
    );
    $(".inbox").animate(
        {
            height: $("#Message-View").height()
        },
        1000
    );
}

// View Message
$(".inbox-content").on(
    "click",
    ".message-info, .message-body",
    function () {
        const id = $(this).data("id");

        $.get("/message/view/" + id)
            .done(function (data) {
                updateUnseenMessagesCount(data.unseen_messages_count);
                setMessageRowSeen(data.message.id);
                viewMessage(data.message);
            })
            .fail(function (data) {
                console.log("Error: ", data);
            });
    }
);

// Select/Deselect All Message
$(".inbox").on("click", "#Select-All-Message", function (e) {
    if ($(this).is(":checked", true)) {
        $(".message-check").prop("checked", true);
    } else {
        $(".message-check").prop("checked", false);
    }
});

// Delete Selected Message
$(".inbox").on("click", ".delete-all-message", function (e) {
    e.preventDefault();

    var ids = [];
    $(".message-check:checked").each(function () {
        ids.push($(this).data("id"));
    });

    if (ids.length <= 0) {
        createToast("warning", "NOTICE", "Please select some row.");
    } else {
        var ids_str = ids.join(",");

        $.ajax({
            type: "DELETE",
            url: "/message/delete-all",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: "ids=" + ids_str,
            success: function (response) {
                createToast("danger", "Success", response.msg);

                $.each(ids, function (index, value) {
                    $("#Message-Id-" + value).remove();
                });

                updateUnseenMessagesCount(response.unseen_messages_count);

                $("#Select-All-Message").prop("checked", false);
            },
            error: function (data) {
                console.log("Error: ", data);
            }
        });
    }
});

// Delete Message
$("body").on("click", "#Btn-Delete-Message", function () {
    var messageId = $(this).data("id");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "delete",
        url: "/message/delete/" + messageId,
        success: function (data) {
            createToast("danger", "Success", "Message deleted successfully");

            $("#Message-Id-" + messageId).remove();

            updateUnseenMessagesCount(data);
        },
        error: function (data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".delete-message", function () {
    $("#Btn-Delete-Message").data("id", $(this).data("id"));
});

// Mark Message As Seen or Unseen
$("body").on("click", ".mark-message", function () {
    var messageId = $(this).data("id");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "put",
        url: "/message/mark/" + messageId,
        success: function (data) {
            updateUnseenMessagesCount(data.unseen_messages_count);
            if (data.message.is_opened === false) {
                setMessageRowUnseen(data.message.id);
                createToast("info", "Success", "Message marked as unseen.");
            } else {
                setMessageRowSeen(data.message.id);
                createToast("info", "Success", "Message marked as seen.");
            }
        },
        error: function (data) {
            console.log("Error:", data);
        }
    });
});

// Search Message
$(".inbox").on("click", ".search-message", function (e) {
    e.preventDefault();

    const query = $("#Message-Query").val().trim();

    if (query.length === 0) {
        createToast("warning", "NOTE", "Please type something.");
    } else {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
        });

        $.ajax({
            type: "POST",
            url: "/message/search/",
            data: "query=" + query,
            success: function (data) {
                $(".inbox-content").html(data);
                $("#Message-Query").val(query);

                createToast("info", "SUCCESS", "Showing result for your query.");
            },
            error: function (data) {
                console.log("Error:", data);
            }
        });
    }
})

// Reset Search Result
$(".inbox").on("click", ".reset-search-message", function (e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "POST",
        url: "/message/search/reset",
        success: function (data) {
            $(".inbox-content").html(data);

            createToast("info", "SUCCESS", "Showing default data.");
        },
        error: function (data) {
            console.log("Error:", data);
        }
    });
})

// AJAX Pagination of Unseen Messages
$(window).on("hashchange", function () {
    if (window.location.hash) {
        var page = window.location.hash.replace("#", "");
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getMessages(page);
        }
    }
});
$(document).on("click", ".pagination a", function (e) {
    e.preventDefault();
    getMessages(
        $(this)
            .attr("href")
            .split("page=")[1]
    );
});
function getMessages(page) {
    $.ajax({
        url: "/inbox?page=" + page,
        dataType: "json"
    })
        .done(function (data) {
            $(".inbox-content").html(data);

            $(".inbox").animate(
                {
                    height: $(".inbox-content").height()
                },
                1000
            );
        })
        .fail(function (data) {
            console.log(data);
            alert("Messages Could Not Be Loaded.");
        });
}
