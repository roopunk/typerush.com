@extends('layouts.main')

@section('content')

Added successfully! <br><br>
<strong>Track Summary</strong> :<br>
Characters : {{ $length }} <br>
Words : {{ $num_words }}<br>
<br><br>
<a href="/?trackid={{ $id }}">Play this track</a> &nbsp;
<a href="/">Back Home</a>

@endsection

