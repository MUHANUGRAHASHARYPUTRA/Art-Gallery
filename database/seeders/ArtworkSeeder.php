<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan folder ada dan bersih
        Storage::deleteDirectory('public/artworks');
        Storage::makeDirectory('public/artworks');

        // Ambil User Member (pastikan UserSeeder sudah jalan duluan)
        $member = User::where('email', 'member@example.com')->first();
        if (!$member) {
            $this->command->error('Member user not found! Please run UserSeeder first.');
            return;
        }

        $categories = [
            'Photography', 'UI/UX Design', '3D Art', 'Illustration', 'Digital Painting'
        ];

        $this->command->info('Generating Artworks... This might take a moment.');

        foreach ($categories as $catName) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName]
            );

            $this->command->info("Processing Category: {$catName}");

            // Buat 6 Artwork per kategori (Total 30)
            for ($i = 1; $i <= 6; $i++) {
                $title = "{$catName} Project #{$i}";
                $filename = Str::slug($title) . '-' . Str::random(5) . '.jpg';
                $path = 'artworks/' . $filename;
                
                // Gunakan Lorem Picsum (Lebih cepat & stabil buat dummy)
                // Format: https://picsum.photos/seed/{seed}/{width}/{height}
                $imageUrl = "https://picsum.photos/seed/" . Str::random(5) . "/800/600";

                $contents = null;

                try {
                    // Timeout 5 detik agar tidak kelamaan menunggu
                    $response = Http::timeout(5)->withoutVerifying()->get($imageUrl);
                    if ($response->successful()) {
                        $contents = $response->body();
                    } else {
                        throw new \Exception("Download failed");
                    }
                } catch (\Exception $e) {
                    $this->command->warn("  - Failed download ($title). Creating placeholder.");
                    // Fallback: Buat gambar warna solid jika download gagal
                    if (extension_loaded('gd')) {
                        $image = imagecreatetruecolor(800, 600);
                        // Warna random pastel
                        $bg = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
                        imagefill($image, 0, 0, $bg);
                        // Text warna gelap
                        $text_color = imagecolorallocate($image, 50, 50, 50);
                        imagestring($image, 5, 50, 50, "Dummy: $title", $text_color);
                        
                        ob_start();
                        imagejpeg($image);
                        $contents = ob_get_clean();
                    } else {
                        // Kalau GD tidak ada, isi file teks (daripada error)
                        $contents = 'Image placeholder';
                    }
                }

                Storage::disk('public')->put($path, $contents);

                Artwork::create([
                    'user_id' => $member->id,
                    'category_id' => $category->id,
                    'title' => $title,
                    'description' => "This is a comprehensive description for {$title}. It showcases creativity and passion in the field of {$catName}.",
                    'image_path' => $path,
                ]);
            }
        }
        
        $this->command->info('All artworks generated successfully!');
    }
}