@extends('app')

@section('content')
    <img class="img-responsive" style="position: absolute; top: 0; left: 0;" src="/images/endoftheworld.jpg" />
<div class="container">
    <div class="row">
        <div class="col-xs-12" style="color: black; margin-top: 20%;">
            <h1 class="text-center">
                28th Annual <br>
                End Of The World Film Festival <br>
                <small>
                    This really could be the last one :(
                </small>
            </h1>
        </div>
        <div class="col-xs-12" style="text-align: center;">
            <a href="/register"
               class="btn btn-info btn-lg"
               style="margin-top: 50px;">
                Register The Last Film(s) I Will Ever Make
            </a>
        </div>
    </div>
</div>
@endsection
