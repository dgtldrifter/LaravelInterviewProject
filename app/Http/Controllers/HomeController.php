<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.home');
    }

    public function uploadFile(Request $request)
    {
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
                            "first-name" => $importData[1],
                            "last-name" => $importData[2],
                            "email" => $importData[3],
                            "gender" => $importData[4],
                            "ip_address" => $importData[5]);

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
}
