@extends('master')

@section('page_scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLECRzlb30dt6EfPvRoXg2n_YtWtp1LBw&callback=initMap"></script>
@endsection

@section('content')

    <div class="contact-information-area section-padding-0-80">

        <div class="container">

            <div class="row col-12">
                <h1>About us</h1>
            </div>

            <div class="row">

                <div class="col-12 col-lg-8">
                    <div class="contact-text">
                        <p>Foodelicious is a leading site in the UK and the world's largest and most active online food community serving more than 1 billion visits annually, energising home cooks to confidently accomplish all their cooking goals – no matter the size or scope. Home cooks discover and share food ideas and experiences with Foodelicious through our authentic, relevant, trusted community. Foodelicious offers authentic food experiences for home cooks worldwide.</p>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="single-contact-information mb-30">
                        <h6>Address:</h6>
                        <p>19 Fake House, Marvel Road, SV2 9JA</p>
                    </div>

                    <div class="single-contact-information mb-30">
                        <h6>Email:</h6>
                        <p>s6.vora@gmail.com</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="comment-block" class="contact-area section-padding-0-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sdection-heading">
                        <h2>Get In Touch</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="contact-form-area">
                        <form action="#" method="post" id="contact">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <input type="text" class="form-control" id="name" placeholder="Name">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <input type="email" class="form-control" id="email" value="{{$email ?: ''}}" placeholder="E-mail">
                                </div>
                                <div class="col-12">
                                    <textarea name="comment" id="comment" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    <div class="word_counter" data-link="comment" data-char-limit="500"></div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn delicious-btn mt-30 right" type="submit">Send comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gMap"></div>

    @include("theme._instagram_feed")

@endsection
