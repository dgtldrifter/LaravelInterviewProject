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
                        <form method="post" action="/addSingleClient">
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Export Data to CSV
                    </div>
                    <div class="card-body">
                        <form method="post" action="/exportData">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-outline-secondary" name="exportcsv" value='CSV Export'>
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
    <?php
        $noOfRows = App\Client::getNumberOfClients();
        echo '<div class="align-content-center text-center"><p>There is a total of '.$noOfRows.' users that you\'re responsible for.</p></div>'
    ?>
    <div class="align-content-center text-center flash-message"></div>
    <div class="container">
        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Gender</th>
                    <th>IP Address</th>
                    <th>User Operations</th>
                </tr>
            </thead>
            <tbody>
            <?php
            use Illuminate\Support\Facades\DB;
            $clients = App\Client::getClientsByUserId();
                // checks if query returned any rows
                if($clients->first()){
                    foreach ($clients as $client) {
                        echo '<tr>';
                        echo '<td id="firstName">'.$client->first_name.'</td>';
                        echo '<td id="lastName">'.$client->last_name.'</td>';
                        echo '<td id="email">'.$client->email.'</td>';
                        echo '<td id="gender">'.$client->gender.'</td>';
                        echo '<td id="ipAddress">'.$client->ip_address.'</td>';
                        echo '<td><input id="createBtn" type="submit" class="btn btn-outline-secondary" name="createUser" value="Create User">
                                <input id="deleteBtn" type="submit" class="btn btn-outline-danger" name="deleteUser" value="Delete User"></td>';
                        echo '</tr>';
                }
                }?>
            </tbody>
        </table>
    </div>
@endsection
