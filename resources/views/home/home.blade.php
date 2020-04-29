@extends('layouts.app')

@section('title', 'View Client Data')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Import Data from CSV
                </div>
                <div class="card-body">
                    <form method="post" action="/uploadFile" enctype="multipart/form-data">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <input type="file" class="form-control-file" name="file"/>
                        </div>

                        <input type="submit" class="btn btn-primary" name="submit" value="Import"/>
                    </form>
                </div>
                @if(session('message'))
                    <div class="card-footer text-muted">
                            {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
