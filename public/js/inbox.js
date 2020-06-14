// Update Unseen Message Counter
function updateUnseenMessagesCount(val) {
    $("#Sidebar-Unseen-Messages-Count").text(val);
    $("#Unseen-Messages-Count").text(val);

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

// Set Message Card As Seen
function setMessageCardSeen(id) {
    $("#Message-Id-" + id)
        .find("div.card-header")
        .addClass("white")
        .removeClass("light-blue darken-4");
    $("#Message-Id-" + id)
        .find(".message-name")
        .addClass("blue-text")
        .removeClass("custom-blue-1");
    $("#Message-Id-" + id)
        .find(".message-email")
        .addClass("blue-grey-text")
        .removeClass("custom-blue-2");
    $("#Message-Id-" + id)
        .find(".message-date")
        .addClass("text-black-50")
        .removeClass("text-white");
    $("#Message-Id-" + id)
        .find(".mark-message")
        .html('<i class="fas fa-check-square mr-2"></i>Mark As Unseen');
}

// Set Message Card As Unseen
function setMessageCardUnseen(id) {
    $("#Message-Id-" + id)
        .find("div.card-header")
        .addClass("light-blue darken-4")
        .removeClass("white");
    $("#Message-Id-" + id)
        .find(".message-name")
        .addClass("custom-blue-1")
        .removeClass("blue-text");
    $("#Message-Id-" + id)
        .find(".message-email")
        .addClass("custom-blue-2")
        .removeClass("blue-grey-text");
    $("#Message-Id-" + id)
        .find(".message-date")
        .addClass("text-white")
        .removeClass("text-black-50");
    $("#Message-Id-" + id)
        .find(".mark-message")
        .html('<i class="far fa-check-square mr-2"></i>Mark As Seen');
}

// Show Message In Modal
function showMessage(message) {
    $("#Modal-Message-Name").text(message.name);
    $("#Modal-Message-Email").text(message.email);
    $("#Modal-Message-Date").text(formatDate(new Date(message.created_at)));
    $("#Modal-Message-Body").html(message.message);
}

// View Message
$("body").on("click", ".view-message", function() {
    var messageId = $(this).data("id");
    $("#Btn-Delete-Message").data("id", messageId);
    $("#Btn-Mark-Message").data("id", messageId);
    $.ajax({
        type: "get",
        url: "/message/view/" + messageId,
        success: function(data) {
            updateUnseenMessagesCount(data.unseen_messages_count);
            setMessageCardSeen(data.message.id);
            showMessage(data.message);
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});

// Delete Message
$("body").on("click", "#Btn-Delete-Message", function() {
    var messageId = $(this).data("id");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "delete",
        url: "/message/delete/" + messageId,
        success: function(data) {
            updateUnseenMessagesCount(data);
            $("#Message-Id-" + messageId).remove();
            createToast("danger", "Success", "Message deleted successfully");
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});
$("body").on("click", ".delete-message", function() {
    $("#Btn-Delete-Message").data("id", $(this).data("id"));
});

// Mark Message As Seen or Unseen
$("body").on("click", ".mark-message", function() {
    var messageId = $(this).data("id");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "put",
        url: "/message/mark/" + messageId,
        success: function(data) {
            updateUnseenMessagesCount(data.unseen_messages_count);
            if (data.message.is_opened === false) {
                setMessageCardUnseen(data.message.id);
                createToast("info", "Success", "Message marked as unseen.");
            } else {
                setMessageCardSeen(data.message.id);
                createToast("info", "Success", "Message marked as seen.");
            }
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});

// AJAX Pagination of Unseen Messages
$(window).on("hashchange", function() {
    if (window.location.hash) {
        var page = window.location.hash.replace("#", "");
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getMessages(page);
        }
    }
});
$(document).on("click", ".pagination a", function(e) {
    getMessages(
        $(this)
            .attr("href")
            .split("page=")[1]
    );
    e.preventDefault();
});
function getMessages(page) {
    $.ajax({
        url: "/inbox?page=" + page,
        dataType: "json"
    })
        .done(function(data) {
            $(".inbox").html(data);
            // location.hash = page;
        })
        .fail(function(data) {
            console.log(data);
            alert("Messages Could Not Be Loaded.");
        });
}
