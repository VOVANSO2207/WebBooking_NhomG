@forelse($results as $key => $room)
    <tr data-room="{{ $room->toJson() }}" style="cursor: pointer;">
        <td>{{ $key + 1 }}</td>
        <td>
            <div class="swiper room-swiper">
                <div class="swiper-wrapper">
                    @foreach ($room->room_images as $image)
                        <div class="swiper-slide">
                            @if (file_exists(public_path('images/' . $image->image_url)))
                                <img src="{{ asset('images/' . $image->image_url) }}" alt="Room Image">
                            @elseif (file_exists(public_path('storage/images/' . $image->image_url)))
                                <img src="{{ asset('storage/images/' . $image->image_url) }}" alt="Room Image">
                            @else
                                <img src="{{ asset('images/img-upload.jpg') }}" alt="Default Image">
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </td>
        <td>{{ $room->name }}</td>
        <td>{{ $room->capacity }}</td>
        <td>{{ $room->roomType ? $room->roomType->name : 'N/A' }}</td>
        <td>{{ $room->price }}</td>
        <td>{{ $room->discount_percent }}%</td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">Không có kết quả nào để hiển thị.</td>
    </tr>
@endforelse
