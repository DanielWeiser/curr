<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'curr_name' => 'Russian ruble',
            'code' => 'RUB',
            'rate' => 1,
        ]);
    }
}

/*

insert into currency(curr_name, code, rate, state_after_reg, flag) values('Russian ruble', 'RUB', 12.13254325, 1, 'russia.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Australian dollar', 'AUD', 2, 0, 'australia.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Euro', 'EUR', 3, 1, 'eur.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Brazilian real', 'BRL', 4, 0, 'brazil.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Bulgarian lev', 'BGN', 5, 0, 'bulgaria.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Canadian dollar', 'CAD', 6, 0, 'canada.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Chinese yuan', 'CNY', 2, 1, 'china.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Colombian peso', 'COP', 3, 1, 'colombia.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Czech koruna', 'CZK', 4, 0, 'czech.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Indian rupee', 'INR', 5, 0, 'india.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('Japanese yen', 'JPY', 6, 1, 'japan.png');
insert into currency(curr_name, code, rate, state_after_reg, flag) values('United States dollar', 'USD', 1, 1, 'us.png');


*/