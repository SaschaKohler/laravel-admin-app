<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MergeFirstLastOnCustomer extends Seeder
{
    /**≠≠
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = DB::table('customers')->get(['id', 'first', 'last','brand']);

        foreach ($rows as $row) {

            DB::table('customers')
                ->where('id', $row->id)
                ->update(['name' => $row->last . ' ' . $row->first]);
        }

    }
}
