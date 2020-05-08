<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Output\ConsoleOutput;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home');
    }

    public function uploadFile(Request $request)
    {
        $u_id = auth()->user()->id;


        if ($request->input('submit') != null) {
            $file = $request->file('file');

            // gather file information
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // accepted file type
            $accepted_extensions = array('csv');

            //max file size
            $maxFileSize = 2097152;

            //validates file extension
            if (in_array(strtolower($extension), $accepted_extensions)) {
                // validate file size
                if ($fileSize <= $maxFileSize) {
                    // file location
                    $location = 'uploads';

                    // moves file
                    $file->move($location, $filename);

                    $filepath = public_path($location . '/' . $filename);

                    // read file
                    $file = fopen($filepath, "r");

                    $importArray = array();
                    $i = 0;

                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);

                        // skip first row in file
                        if ($i == 0) {
                            $i++;
                            continue;
                        }
                        for ($cell = 0; $cell < $num; $cell++) {
                            $importArray[$i][] = $filedata[$cell];
                        }
                        $i++;
                    }
                    fclose($file);

                    // Insert into DB
                    foreach ($importArray as $importData) {
                        $insertInfo = array(
                            "first_name" => $importData[1],
                            "last_name" => $importData[2],
                            "email" => $importData[3],
                            "gender" => $importData[4],
                            "ip_address" => $importData[5],
                            "user_id" => $u_id);

                        Client::insertData($insertInfo);
                    }
                } else {
                    $request->session()->flash('message', 'File too large. Must be less than 2MB.');
                }
            } else {
                $request->session()->flash('message', "Invalid file extension. Must be a .CSV file.");
            }
        }

        //redirect to clients page
        return redirect()->action('HomeController@index')->with('message', "Data imported!");
    }

    public function addSingleClient(Request $request) {
        $u_id = auth()->user()->id;

        if ($request->input('submit') != null) {
            $first_name = $request->input('f_name');
            $last_name = $request->input('l_name');
            $email = $request->input('email');
            $gender = $request->input('options');
            $ip_address = $request->input('ip_address');

            $insertInfo = array (
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "gender" => $gender,
                "ip_address" => $ip_address,
                "user_id" => $u_id);

            Client::insertData($insertInfo);
        }
        return redirect()->action('HomeController@index')->with('message', 'Client Added!');
    }

    public function createUserFromClient(Request $request) {
        $json = json_decode($request, true);
        $email = $request->email;

        $client = Client::getCilentByEmail($email);

        User::create([
            'name' => $client->first_name." ".$client->last_name,
            'email' => $client->email,
            'password' => Hash::make("password")
        ]);

       return redirect()->action('HomeController@index')->with('message', 'User Created');
    }

    public static function deleteClient($client) {

    }
}
