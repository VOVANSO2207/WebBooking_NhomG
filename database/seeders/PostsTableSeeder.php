<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Posts::insert([
            [
                'title' => 'Khách sạn sang trọng nhất Việt Nam',
                'description' => 'Khám phá những khách sạn sang trọng và đẳng cấp tại Việt Nam.',
                'content' => 'Trong bài viết này, chúng tôi sẽ giới thiệu đến bạn những khách sạn 5 sao nổi bật tại Việt Nam, từ Đà Nẵng đến Hà Nội.',
                'meta_desc' => 'Khách sạn sang trọng tại Việt Nam.',
                'status' => true,
                'url_seo' => 'khach-san-sang-trong-nhat-viet-nam',
                'img' => 'hotel_luxury_vietnam.jpg',
            ],
            [
                'title' => 'Top 10 khách sạn bãi biển đẹp nhất',
                'description' => 'Danh sách những khách sạn nằm bên bờ biển tuyệt đẹp.',
                'content' => 'Nếu bạn đang tìm kiếm một nơi nghỉ dưỡng bên bờ biển, đây là 10 khách sạn lý tưởng dành cho bạn.',
                'meta_desc' => 'Khách sạn bãi biển đẹp nhất.',
                'status' => true,
                'url_seo' => 'top-10-khach-san-bai-bien-dep-nhat',
                'img' => 'beach_hotel_top10.jpg',
            ],
            [
                'title' => 'Khách sạn bình dân tại Hà Nội',
                'description' => 'Những lựa chọn khách sạn bình dân và chất lượng tại Hà Nội.',
                'content' => 'Bài viết sẽ gợi ý cho bạn những khách sạn giá rẻ nhưng vẫn đảm bảo chất lượng tại Hà Nội.',
                'meta_desc' => 'Khách sạn bình dân tại Hà Nội.',
                'status' => true,
                'url_seo' => 'khach-san-binh-dan-tai-ha-noi',
                'img' => 'budget_hotel_hanoi.jpg',
            ],
            [
                'title' => 'Khách sạn có dịch vụ tốt nhất ở Đà Nẵng',
                'description' => 'Top khách sạn có dịch vụ tận tình và chu đáo ở Đà Nẵng.',
                'content' => 'Nếu bạn đang tìm kiếm một trải nghiệm nghỉ dưỡng tuyệt vời ở Đà Nẵng, đây là những khách sạn với dịch vụ tốt nhất.',
                'meta_desc' => 'Khách sạn có dịch vụ tốt nhất ở Đà Nẵng.',
                'status' => true,
                'url_seo' => 'khach-san-co-dich-vu-tot-nhat-o-da-nang',
                'img' => 'best_service_hotel_danang.jpg',
            ],
            [
                'title' => 'Khách sạn thân thiện với môi trường tại Hội An',
                'description' => 'Những khách sạn bảo vệ môi trường và bền vững tại Hội An.',
                'content' => 'Hội An không chỉ nổi tiếng với văn hóa mà còn với những khách sạn chú trọng đến môi trường. Bài viết sẽ gợi ý cho bạn những lựa chọn tốt nhất.',
                'meta_desc' => 'Khách sạn thân thiện với môi trường tại Hội An.',
                'status' => true,
                'url_seo' => 'khach-san-than-thien-voi-moi-truong-tai-hoi-an',
                'img' => 'eco_friendly_hotel_hoian.jpg',
            ],
            [
                'title' => 'Khách sạn phong cách cổ điển tại Huế',
                'description' => 'Khám phá những khách sạn mang đậm phong cách cổ điển tại Huế.',
                'content' => 'Bài viết này sẽ đưa bạn đến với những khách sạn cổ điển, nơi bạn có thể cảm nhận được hơi thở lịch sử của cố đô Huế.',
                'meta_desc' => 'Khách sạn phong cách cổ điển tại Huế.',
                'status' => true,
                'url_seo' => 'khach-san-phong-cach-co-dien-tai-hue',
                'img' => 'classic_hotel_hue.jpg',
            ],
            [
                'title' => 'Khách sạn gần các điểm du lịch tại Nha Trang',
                'description' => 'Những khách sạn gần biển và các điểm du lịch tại Nha Trang.',
                'content' => 'Nếu bạn muốn khám phá Nha Trang, những khách sạn gần biển và các điểm tham quan là lựa chọn tuyệt vời cho chuyến đi của bạn.',
                'meta_desc' => 'Khách sạn gần các điểm du lịch tại Nha Trang.',
                'status' => true,
                'url_seo' => 'khach-san-gan-cac-diem-du-lich-tai-nha-trang',
                'img' => 'hotel_near_tourist_spots_nhatrang.jpg',
            ],
            [
                'title' => 'Những khách sạn lý tưởng cho tuần trăng mật',
                'description' => 'Danh sách những khách sạn lãng mạn cho tuần trăng mật.',
                'content' => 'Bài viết sẽ đưa ra những lựa chọn tuyệt vời cho tuần trăng mật của bạn, từ biển đến núi.',
                'meta_desc' => 'Khách sạn lý tưởng cho tuần trăng mật.',
                'status' => true,
                'url_seo' => 'khach-san-ly-tuong-cho-tuan-trang-mat',
                'img' => 'honeymoon_hotel.jpg',
            ],
            [
                'title' => 'Khách sạn có hồ bơi đẹp tại Phú Quốc',
                'description' => 'Tìm hiểu về những khách sạn có hồ bơi đẹp tại Phú Quốc.',
                'content' => 'Phú Quốc nổi tiếng với những khách sạn có hồ bơi view đẹp, rất thích hợp cho những ngày hè.',
                'meta_desc' => 'Khách sạn có hồ bơi đẹp tại Phú Quốc.',
                'status' => true,
                'url_seo' => 'khach-san-co-ho-boi-dep-tai-phu-quoc',
                'img' => 'pool_view_hotel_phuquoc.jpg',
            ],
            [
                'title' => 'Kinh nghiệm đặt phòng khách sạn trực tuyến',
                'description' => 'Những kinh nghiệm cần biết khi đặt phòng khách sạn trực tuyến.',
                'content' => 'Bài viết sẽ chia sẻ những mẹo hữu ích để bạn có thể đặt phòng khách sạn trực tuyến một cách hiệu quả và tiết kiệm.',
                'meta_desc' => 'Kinh nghiệm đặt phòng khách sạn trực tuyến.',
                'status' => true,
                'url_seo' => 'kinh-nghiem-dat-phong-khach-san-truc-tuyen',
                'img' => 'online_booking_tips.jpg',
            ],
        ]);
    }
}
