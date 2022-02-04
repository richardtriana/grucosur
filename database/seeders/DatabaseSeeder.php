<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(CompanySeeder::class);
    $this->call(HeadquarterSeeder::class);
    $this->call(ClientSeeder::class);
    $this->call(ProviderSeeder::class);
    $this->call(CreditSeeder::class);
    $this->call(MainBoxSeeder::class);
    $this->call(BoxSeeder::class);
    $this->call(ExpenseSeeder::class);
    $this->call(TypeExpenseSeeder::class);
  }
}
