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
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="file" class="form-control-file" id="importFile">
                        </div>
                            <input type="submit" class="btn btn-outline-secondary" name="submit" value="Import Data">
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
