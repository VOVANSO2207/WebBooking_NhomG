@php
    use App\Helpers\IdEncoder;
@endphp
@forelse ($results as $index => $post)
    <tr class="post-detail1" data-id="{{ IdEncoder::encodeId($post->post_id) }}" data-updated-at="{{ $post->updated_at }}">
        <td>{{ $index + 1 }}</td>
        <td>
            <img src="{{ asset('images/' . $post->img) }}" alt="{{ $post->title }}" style="width: 100px; height: auto;">
        </td>
        <td>{{ Str::limit($post->title, 60) }}</td>
        <td>{{ Str::limit($post->description, 60) }}</td>
        <td>{{ Str::limit($post->content, 60) }}</td>
        <td>{{ Str::limit($post->meta_desc, 60) }}</td>
        <td>{{ $post->url_seo }}</td>
        <td>{{ $post->status ? 'Show' : 'Hidden' }}</td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">Không có bài viết nào để hiển thị.</td>
    </tr>
@endforelse

<div class="d-flex justify-content-center mt-3">
    {{ $results->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
</div>

<script>

    $(document).ready(function () {
        let currentPostId = null; // Lưu ID bài viết hiện tại
        let currentUpdatedAt = null; // Biến lưu updated_at
        // Khi người dùng nhấn vào một bài viết
        $('.post-detail1 td').on('click', function () {
            const $row = $(this).closest('tr'); // Lấy hàng tương ứng
            currentPostId = $row.data('id');
            currentUpdatedAt = $row.data('updated-at'); // Lấy updated_at
            // Gọi AJAX để lấy thông tin chi tiết bài viết
            $.ajax({
                url: `/posts/${currentPostId}/detail`,
                method: 'GET',
                dataType: 'json',
                success: function (post) {
                    const limitText = (text, maxLength = 60) => {
                        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                    };

                    // Cập nhật nội dung modal
                    $('#modalTitle').text(limitText(post.title));
                    $('#modalDescription').text(limitText(post.description));
                    $('#modalContent').text(limitText(post.content));
                    $('#modalMetaDesc').text(limitText(post.meta_desc));
                    $('#modalUrlSeo').text(limitText(post.url_seo));
                    $('#modalStatus').text(post.status ? 'Show' : 'Hidden');
                    const imageUrl = post.img ? `/images/${post.img}` : '/path/to/default/image.jpg';
                    $('#modalImage').attr('src', imageUrl);
                    const editRoute = "{{ route('post.edit', ['post_id' => ':id']) }}".replace(':id', currentPostId);
                    document.getElementById('editPostButton').setAttribute('href', editRoute);
                    // Hiển thị modal
                    $('#postDetailModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Có vấn đề với yêu cầu AJAX:', error);
                }
            });
        });

        // Khi người dùng nhấn nút "Delete"
        $('#deletePostButton').on('click', function () {
            $('#confirmDeleteModal').modal('show');
        });

        // Khi người dùng nhấn nút "OK" trong modal xác nhận
        $('#confirmDeleteButton').on('click', function () {

            if (currentPostId) {
                // Sử dụng tên route để tạo URL
                const deleteRoute = "{{ route('post.delete', ['post_id' => ':id']) }}".replace(':id', currentPostId);
                $.ajax({
                    url: deleteRoute,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: JSON.stringify({ updated_at: currentUpdatedAt }),
                    contentType: 'application/json', // Đảm bảo rằng content type là JSON
                    success: function (response) {
                        alert("Xoá Bài Viết Thành Công");
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Có lỗi xảy ra khi xóa bài viết:', error);
                        alert('Có lỗi xảy ra: ' + xhr.responseText); // Hiện thông báo lỗi
                    }
                });
            }

        });

        // Lắng nghe sự kiện khi modal đã hoàn toàn đóng
        $('#confirmDeleteModal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove(); // Loại bỏ lớp mờ
        });

        // Đảm bảo nút Cancel đóng modal
        $('#cancelButton').on('click', function () {
            $('#confirmDeleteModal').modal('hide'); // Ẩn modal
        });
    });

</script>