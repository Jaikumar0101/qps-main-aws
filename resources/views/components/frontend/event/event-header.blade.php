<!--another menu-->
<div class="container-fluid" style="padding-right:0px!important; padding-left:0px!important; margin:0px">
    <div class="row" style="padding-right:0px!important; padding-left:0px!important">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light"
                 style="background-color:rgb(26, 24, 32, 0.5); border-bottom:1px solid #333;font-size:14px; height:140px">
                <div class="container">
                    <a class="navbar-brand"
                       href="{{ route('frontend::event.detail',['slug'=>$slug]) }}"
                    >
                        @if(isset($event))
                            <img src="{{ asset($event->logo ??'assets/frontend/img/edge2023.png') }}" height="50">
                        @else
                            <img src="{{ asset('assets/frontend/img/edge2023.png') }}" width="180" />
                        @endif
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"> </span>
                    </button>
                    <div class="collapse navbar-collapse nav2" id="navbarSupportedContent">

                        <ul class="navbar-nav ms-auto nav2">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('frontend::event.detail',['slug'=>$slug]) }}"
                                >HOME</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false" style=" text-align:center">ABOUT</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                    style="left:0!important">
                                    <li><a class="dropdown-item d-none" href="{{ route('frontend::event.about',['slug'=>$slug]) }}">Agenda</a></li>
                                    <li><a class="dropdown-item" href="{{ route('frontend::event.venue',['slug'=>$slug]) }}">Venue</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link	"
                                   href="{{ route('frontend::event.speakers',['slug'=>$slug]) }}"
                                >SPEAKERS</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false" style=" text-align:center">SPONSORS</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                    style="left:0!important">
                                    <li><a class="dropdown-item" href="{{ route('frontend::event.sponsors',['slug'=>$slug]) }}">All Sponsor</a></li>
                                    <li><a class="dropdown-item" href="{{ route('frontend::event.sponsor-with-us',['slug'=>$slug]) }}">Sponsor with us</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false" style=" text-align:center">MEDIA</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown"
                                    style="left:0!important">
                                    <li><a class="dropdown-item" href="{{ route('frontend::event.articles',['slug'=>$slug]) }}">Article</a></li>
                                    <li><a class="dropdown-item" href="{{ route('frontend::event.gallery',['slug'=>$slug]) }}">Gallery</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link	"
                                                    href="{{ route('frontend::event.faq',['slug'=>$slug]) }}"
                                >FAQ</a></li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="{{ route('frontend::contact') }}">GET INVOLVED</a></li>
                            <li class="nav-item"><a href="{{ $event->registerUrl() }}" target="_blank" class="nav-link calci" >REGISTER NOW</a></li>

                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

</div>
