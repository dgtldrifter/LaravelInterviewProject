<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'clients';

    public static function insertData($data) {
        $value=DB::table('clients')->where('email', $data['email'])->get();
        if($value->count() == 0) {DB::table('clients')->insert($data); }
    }

    public static function getClientsByUserId()
    {
        return DB::table('clients')->where('user_id', auth()->user()->id)->get();
    }

    public static function getNumberOfClients(){
        return DB::table('clients')->where('user_id', auth()->user()->id)->get()->count();
    }

    public static function getCilentByEmail($email) {
        return DB::table('clients')
            ->where('email', $email)
            ->first();
    }

    public function getClientsForExport() {
        return DB::select(DB::raw("select c.first_name, c.last_name, COALESCE(u.email, 'N/A') as 'User Account'
                                from clients as c
                                left join users as u on c.email = u.email
                                where c.user_id = 1  "));
    }
}
