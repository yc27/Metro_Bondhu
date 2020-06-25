<!-- Notices -->
<section class="py-4 mb-4" id="Notices">
    <h2 class="h2 text-center">Notices</h2>
    <hr class="w-25 w-sm-50 mt-2 mb-4">

    <div class="container-fluid">
        <div id="carousel-notice" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner row w-100 mx-auto" role="listbox">
                @php
                    $noticeCount = 0;
                @endphp
                @foreach($notices as $notice)
                @php
                    $noticeCount += 1;
                @endphp
                <div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 {{$noticeCount == 1 ? 'active' : ''}}">
                    <div class="card text-white {{ $notice->color }}">
                        <div class="card-header">
                            <h5 class="card-title mb-0 font-weight-bold">{{ $notice->title }}</h5>
                            <small>{{ \Carbon\Carbon::parse($notice->date)->format('F d, Y') }}</small>
                        </div>

                        <div class="card-body">
                            {{ $notice->getNotice() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <a class="carousel-control-prev" href="#carousel-notice" role="button" data-slide="prev">
                <i class="fas fa-angle-left"></i>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#carousel-notice" role="button" data-slide="next">
                <i class="fas fa-angle-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</section>
<!-- /Notices -->