// Update Unseen Message Counter
function updateUnseenMessagesCount(val) {
    $("#Sidebar-Unseen-Messages-Count").text(val);
    $("#Unseen-Messages-Count").text(val);
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
        .addClass("blue-gray-text")
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
        .removeClass("blue-gray-text");
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
            } else {
                setMessageCardSeen(data.message.id);
            }
        },
        error: function(data) {
            console.log("Error:", data);
        }
    });
});

// AJAX Pagination of Unseen Messages
// $(document).ready(function() {
//     $(document).on('click', '.unseen-messages .pagination a', function(event) {
//         event.preventDefault();

//         $('li').removeClass('active');
//         $(this).parent('li').addClass('active');
//         var myurl = $(this).attr('href');
//         var page = $(this).attr('href').split('page=')[1];
//         getUnseenMessages(page);
//     });
// });
// function getUnseenMessages(page) {
//     $.ajax({
//         url: '?page=' + page,
// 		type: "get",
// 		datatype: "html"
//     }).done(function(data) {
//         $("#Unseen-Messages").empty().html(data);
//     }).fail(function(jqXHR, ajaxOptions, thrownError) {
//         console.log('No response from server');
//     });
// }

// AJAX Pagination of Seen Messages
// $(window).on('hashchange', function() {
//     if (window.location.hash) {
//         var page = window.location.hash.replace('#', '');
//         if (page == Number.NaN || page <= 0) {
//             return false;
//         }else{
//             getData(page);
//         }
//     }
// });
// $(document).ready(function() {
//     $(document).on('click', '.seen-messages .pagination a', function(event) {
//         event.preventDefault();

// 		$('.seen-messages .pagination').children('li').removeClass('active');
//         $(this).parent('li').addClass('active');
// 		var myurl = $(this).attr('href');
// 		var page = $(this).attr('href').split('page=')[1];
// 		console.log(myurl, page);
//         getSeenMessages(page);
//     });
// });
// function getSeenMessages(page) {
//     $.ajax({
//         url: 'http://localhost:8000/dashboard/inbox?page=' + page,
// 		type: "get",
// 		datatype: "html"
//     }).done(function(data) {
// 		$("#Seen-Messages").empty().html(data);
// 		location.hash = page;
//     }).fail(function(jqXHR, ajaxOptions, thrownError) {
//         console.log('No response from server');
//     });
// }