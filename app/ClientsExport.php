<?php

namespace App;

use App\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection,WithHeadings {

    public function headings(): array {
        return [
            "first_name", "last_name", "user_account"
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {

        return collect(Client::getClientsForExport());
        // return Page::getUsers(); // Use this if you return data from Model without using toArray().
    }
}
