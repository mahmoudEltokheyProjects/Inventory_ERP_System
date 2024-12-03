<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ItemCardCategory\InvItemCardCategory;
use App\Models\Treasury;
use Database\Seeders\Location\CitySeeder;
use Database\Seeders\Location\CountrySeeder;
use Database\Seeders\Location\StateSeeder;
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
        // ============= AdminSeeder =============
        $this->call(AdminSeeder::class);
        // ============= Location =============
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        // ============= AdminPanelSettingSeeder =============
        $this->call(AdminPanelSettingSeeder::class);
        // ============= TreasurySeeder =============
        $this->call(TreasurySeeder::class);
        // ============= SalesMaterialTypeSeeder =============
        $this->call(SalesMaterialTypeSeeder::class);
        // ============= StoreSeeder =============
        $this->call(StoreSeeder::class);
        // ============= InvUomSeeder =============
        $this->call(InvUomSeeder::class);
        // ============= InvItemCardCategorySeeder =============
        $this->call(InvItemCardCategorySeeder::class);
        // ============= InvItemCardSeeder =============
        $this->call(InvItemCardSeeder::class);
        // ============= AccountTypesSeeder =============
        $this->call(AccountTypesSeeder::class);
        // ============= AccountsSeeder =============
        $this->call(AccountsSeeder::class);
        // ============= CustomerSeeder =============
        $this->call(CustomerSeeder::class);
        // ============= SuppliersCategorySeeder =============
        $this->call(SuppliersCategorySeeder::class);
        // ============= SuppliersSeeder =============
        $this->call(SuppliersSeeder::class);

    }
}
