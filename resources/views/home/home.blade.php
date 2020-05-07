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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Add Single User
                    </div>
                    <div class="card-body">
                        <form method="post" action="/addSingleUser">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="f_name" class="">First Name:</label>
                                <input type="text" name="f_name" class="form-control" id="f_name" required>
                                <label for="l_name" class="">Last Name:</label>
                                <input type="text" name="l_name" class="form-control" id="l_name" required>
                                <label for="email" class="">Email Address:</label>
                                <input type="text" name="email" class="form-control" id="email" required>
                                <label for="email" class="">Gender:</label>
                                <br>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="male" value="Male" autocomplete="off"> Male
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="female" value="Female" autocomplete="off"> Female
                                    </label>
                                </div>
                                <br>
                                <label for="email" class="">IP Address:</label>
                                <input type="text" name="ip_address" class="form-control" id="ip_address" required>
                            </div>
                            <input type="submit" class="btn btn-outline-secondary" name="submit" value="Add User">
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
            use Illuminate\Support\Facades\DB;
            $clients = App\Client::getClientsByUserId();

                // checks if query returned any rows
                if($clients->first()){
                    foreach ($clients as $client) {
                        echo '<tr name='.$client->id.'>';
                        echo '<td>'.$client->first_name.'</td>';
                        echo '<td>'.$client->last_name.'</td>';
                        echo '<td>'.$client->email.'</td>';
                        echo '<td>'.$client->gender.'</td>';
                        echo '<td>'.$client->ip_address.'</td>';
                        echo '<td><button type="button" class="btn btn-outline-secondary" name="button" value="Create User" onclick="addUser()"></td>';
                        echo '</tr>';
                }
                }?>
            </tbody>
        </table>
    </div>
@endsection
