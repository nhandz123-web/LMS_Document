<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Document;
use App\Models\User;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first() ?? User::factory()->create();

        Document::create([
            'title' => 'Giáo trình Lập trình Web',
            'type' => 'giaotrinh',
            'author_id' => $author->id,
            'published_at' => now()->subDays(5),
        ]);

        Document::create([
            'title' => 'Đề cương Mạng máy tính',
            'type' => 'decuong',
            'author_id' => $author->id,
            'published_at' => now()->subDays(2),
        ]);
    }
}