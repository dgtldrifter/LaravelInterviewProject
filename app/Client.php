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

    public static function getClientsForExport() {
        DB::raw("drop view clients_users");

        DB::raw("create view clients_users as
            select users.id as UserID, clients.first_name, clients.last_name, COALESCE(users.email , 'N/A') as UserAccount, clients.email as ClientEmail
            from clients
            left join users on users.email = clients.email
            where clients.user_id = 1");

        return DB::select(DB::raw("select clients_users.first_name, clients_users.last_name, clients_users.UserAccount, count(clients.id) as numberOfClients
            from clients
            right join clients_users on clients_users.UserID = clients.user_id
            group by ClientEmail"));
    }
}
