<!-- Inbox -->
<div id="Inbox" class="tabcontent">
    <div class="container">
        <div class="text-dark title h1">
            Inbox
        </div>
        <div class="py-1 px-2 my-2 mx-0 align-middle rounded warning-color text-dark" style="width: fit-content;">
            Total Unseen Messages:
		<span class="badge primary-color p-2" id="Unread-Message-Count">{{ $unseen_message_count }}</span>
        </div>
		<hr>
		@if($unseen_messages->isEmpty() && $seen_messages->isEmpty())
		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="h2 text-center indigo-text">Inbox Empty</h2>
				</div>
			</div>
		</div>
		@endif
		@if(!$unseen_messages->isEmpty())
		<div id="Unseen-Messages">
			@include('admin.inbox.unseenMessages')
		</div>
		@endif
		@if(!$seen_messages->isEmpty())
		<div id="Seen-Messages">
			@include('admin.inbox.seenMessages')
		</div>
		@endif
    </div>
</div>

<!-- Delete Modal -->
<div id="Modal-Message-Delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal-Message-Delete-Label" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <div class="modal-content text-dark" style="font-size: 14px">
            <div class="modal-header">
                <p class="heading lead" id="Modal-Message-Delete-Label">Confirme Delete?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this message?
                    <br><br>
                    <div class="text-danger">This action cannot be undone.</div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="Btn-Delete-Message" class="btn btn-danger btn-sm" data-dismiss="modal">Delete</button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<script type="text/javascript">
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
	$(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            }else{
                getData(page);
            }
        }
    });
	$(document).ready(function() {
        $(document).on('click', '.seen-messages .pagination a', function(event) {
            event.preventDefault();

			$('.seen-messages .pagination').children('li').removeClass('active');
            $(this).parent('li').addClass('active');
			var myurl = $(this).attr('href');
			var page = $(this).attr('href').split('page=')[1];
			console.log(myurl, page);
            getSeenMessages(page);
        });
    });
    function getSeenMessages(page) {
        $.ajax({
            url: 'http://localhost:8000/dashboard/inbox?page=' + page,
			type: "get",
			datatype: "html"
        }).done(function(data) {
			$("#Seen-Messages").empty().html(data);
			location.hash = page;
        }).fail(function(jqXHR, ajaxOptions, thrownError) {
            console.log('No response from server');
        });
    }

	// Delete Message
	$("body").on("click", "#Btn-Delete-Message", function() {
		var messageId = $("#Delete-Message").data("id");
		$("#Delete-Message").prop("id", "");
		$.ajaxSetup({
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
			}
		});

		$.ajax({
			type: "delete",
			url: "/inbox/delete/message/" + messageId,
			success: function(data) {
				getData();
			},
			error: function(data) {
				console.log("Error:", data);
			}
		});
	});
	$("body").on("click", ".delete-message", function() {
		$("#Delete-Message").prop("id", "");
		$(this).prop("id", "Delete-Message");
	});
</script>
<!-- /Inbox -->