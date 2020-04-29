@extends('layouts.app')

@section('title', 'View Client Data')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
                <p>{{ session('message') }}</p>
            @endif

            <form method="post" action="/uploadFile" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="file"/>
                <input type="submit" name="submit" value="Import"/>
            </form>
        </div>
    </div>
</div>
@endsection
