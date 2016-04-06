@extends('emails.layouts.welcome')

@section('heading')
    Welcome, {{ $name }} and Goodbye
    @endsection

@section('topLinkHref1')#
@endsection
@section('topLinkText1')About Us
@endsection

@section('topLinkHref2')#
@endsection
@section('topLinkText2')Upcoming Films
@endsection

@section('topLinkHref3')#
@endsection
@section('topLinkText3')Why Armageddon?
@endsection

@section('topLinkHref4')#
@endsection
@section('topLinkText4')Cognitive Benefits of Slinkys
@endsection

@section('centerImgHref')https://s3.amazonaws.com/dysonlogos/endofworldemail.jpg
@endsection

@section('bottomHeading')
    Copy and paste your code to continue
@endsection

@section('bottomText')
Copy this code: {{ $code }} . Then paste it in registration area.
@endsection

@section('bottomLinkHref1')#
@endsection
@section('bottomLinkText1')Category Standings
@endsection

@section('bottomLinkHref2')#
@endsection
@section('bottomLinkText2')Film Standings
@endsection

@section('bottomLinkHref3')#
@endsection
@section('bottomLinkText3')Donor Standings
@endsection

@section('bottomLinkHref4')#
@endsection
@section('bottomLinkText4')Nathan Standing
@endsection

