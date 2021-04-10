<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    protected $imageDir = 'customers';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imageId = null;
        for ($i = 0; $i <= 10; $i++) {
            $img_url = 'https://source.unsplash.com/collection/'. $i .'/400x400';
            $content = file_get_contents($img_url);
            $imageId = \App\Services\Imagist\Facades\Imagist::store($content, $this->imageDir);
            \App\Models\Customer::query()->create([
                'id' => Webpatser\Uuid\Uuid::generate(4)->string,
                'name' => 'Random Nama ' . $i,
                'username' => 'username' . $i,
                'status' => 1,
                'photo' => $imageId,
                'trx_count' => rand(1, 200),
                'trx_amount' => rand(10000, 1000000)
            ]);
        }
    }
}
