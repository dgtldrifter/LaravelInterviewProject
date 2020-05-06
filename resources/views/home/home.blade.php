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
    <div class="container">
        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Gender</th>
                    <th>IP Address</th>
                    <th>Add Client as User</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $clients = App\Client::all();
                foreach ($clients as $client) {
                    echo '<tr>';
                    echo '<td>'.$client->first_name.'</td>';
                    echo '<td>'.$client->last_name.'</td>';
                    echo '<td>'.$client->email.'</td>';
                    echo '<td>'.$client->gender.'</td>';
                    echo '<td>'.$client->ip_address.'</td>';
                    echo '</tr>';
                }?>
            </tbody>
        </table>
    </div>
@endsection
