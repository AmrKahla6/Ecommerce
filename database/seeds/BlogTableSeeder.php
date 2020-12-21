<?php

use Illuminate\Database\Seeder;
use App\Blog;
use App\Status;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status=Status::where('slug','active')->firstOrFail()->id;

        $blog                        = new Blog;
        $blog->{'title:en'}          = 'About our website';
        $blog->{'title:ar'}          = 'نبذة عن موقعنا';
        $blog->{'description:en'}    = 'This web site discusses exchange-traded options issued by The Options Clearing Corporation';
        $blog->{'description:ar'}    = ' موقعنا عباره عن مجموعة من العمليّات التجاريّة التي تشمل على شراء وبيع الخدمات والسلع،';
        $blog->image                 = 'blog_1.jpg';
        $blog->order                 = 1;
        $blog->status_id             = $status;
        $blog->save();

        $blog                        = new Blog;
        $blog->{'title:en'}          = 'science';
        $blog->{'title:ar'}          = 'العلم';
        $blog->{'description:ar'}    = 'هو الفكرُ الناتج عن دراسة سلوك وشكّل وطبيعة الأشياء';
        $blog->{'description:en'}    = ' It is the thought resulting from the study of the behavior, form and nature of things';
        $blog->image                 = 'blog_2.jpg';
        $blog->order                 = 1;
        $blog->status_id             = $status;
        $blog->save();
    }
}
