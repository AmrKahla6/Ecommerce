<?php

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
        $this->call(CityTableSeeder::class);
        $this->call(AboutSeeder::class);
        $this->call(ContactInfoTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(BlogTableSeeder::class);
        $this->call(PermissionsTableDataSeeder::class);
        $this->call(RoleTableDataSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SubcategoryTableSeeder::class);
        $this->call(HomesectionSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(GeneralsettingSeeder::class);
        $this->call(CoverPagesTableSeeder::class);
        $this->call(TestimationSeeder::class);
        $this->call(SocialTableSeeder::class);

    }
}
