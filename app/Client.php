<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public static function insertData($data) {
        $value=DB::table('clients')->where('email', $data['email'])->get();
        if($value->count() == 0) {DB::table('clients')->insert($data); }
    }
}
