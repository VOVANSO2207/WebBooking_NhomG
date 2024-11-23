@php
    use App\Helpers\IdEncoder;
@endphp

@forelse ($vouchers as $index => $voucher)
    <tr class="voucher-detail1" data-id="{{ IdEncoder::encodeId($voucher->promotion_id) }}"
        data-updated-at="{{ $voucher->updated_at }}">
        <td>{{ $index + 1 }}</td>
        <td>{{ $voucher->pro_title }}</td>
        <td>{{ $voucher->promotion_code }}</td>
        <td>{{ $voucher->discount_amount }}%</td>
        <td>{{ \Str::limit($voucher->pro_description, 10) }}</td>

        <td>{{ $voucher->start_date }}</td>
        <td>{{ $voucher->end_date }}</td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">Không có voucher nào hiển thị.</td>
    </tr>
@endforelse

<script>
    $(document).ready(function () {
        let currentVoucherId = null; // Lưu ID voucher hiện tại
        let currentUpdatedAt = null; // Biến lưu updated_at

        // Khi người dùng nhấn vào một dòng voucher
        $('.voucher-detail1 td').on('click', function () {
            const $row = $(this).closest('tr'); // Lấy hàng tương ứng
            currentVoucherId = $row.data('id'); // Lấy ID voucher
            currentUpdatedAt = $row.data('updated-at'); // Lấy updated_at

            console.log(`/voucher/${currentVoucherId}/detail`);

            // Gọi AJAX để lấy thông tin chi tiết voucher
            $.ajax({
                url: `/voucher/${currentVoucherId}/detail`,
                method: 'GET',
                dataType: 'json',
                success: function (voucher) {
                    $('#modalPromotionTitle').text(voucher.pro_title);
                    $('#modalPromotionCode').text(voucher.promotion_code);
                    let discountAmount = voucher.discount_amount;
                    let formattedAmount = Number(discountAmount).toLocaleString('vi-VN') + ' VND';
                    $('#modalDiscountAmount').text(formattedAmount);
                    $('#modalProDescription').text(voucher.pro_description);


                    $('#modalStartDate').text(voucher.start_date);
                    $('#modalEndDate').text(voucher.end_date);

                    // Thiết lập đường dẫn cho nút Edit
                    const editRoute = "{{ route('voucher.edit', ['promotion_id' => ':id']) }}".replace(':id', currentVoucherId);

                    document.getElementById('editVoucherButton').setAttribute('href', editRoute);
                    // Hiển thị modal
                    $('#voucherDetailModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Có lỗi xảy ra với yêu cầu AJAX:', error);
                    alert('Có lỗi xảy ra khi lấy thông tin voucher. Vui lòng thử lại.');
                }
            });
        });

        // Khi người dùng nhấn nút "Delete"
        $('.delete-voucher').on('click', function () {
            currentVoucherId = $(this).data('id');

            // Hiển thị modal xác nhận xóa
            $('#confirmDeleteModal').modal('show');
        });

        // Khi người dùng nhấn nút "OK" trong modal xác nhận xóa
        $('#confirmDeleteButton').on('click', function () {
            if (currentVoucherId) {
                // Sử dụng route để tạo URL xóa
                const deleteRoute = "{{ route('voucher.delete', ['promotion_id' => ':id']) }}".replace(':id', currentVoucherId);

                // Gửi yêu cầu xóa bằng AJAX
                $.ajax({
                    url: deleteRoute,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({ updated_at: currentUpdatedAt }), // Gửi updated_at
                    success: function (data) {
                        // Hiển thị modal thông báo thành công
                        $('#notificationModalBody').text('Xóa Voucher Thành Công');
                        $('#notificationModal').modal('show');

                        // Tải lại trang sau khi xóa thành công
                        setTimeout(() => {
                            location.reload();
                        }, 1500); // Thay đổi thời gian nếu cần
                    },
                    error: function (xhr) {
                        console.error('Có lỗi xảy ra:', xhr.responseJSON);
                        // Hiển thị modal thông báo lỗi
                        $('#notificationModalBody').text('Có lỗi xảy ra: ' + (xhr.responseJSON.error || 'Đã xảy ra lỗi không xác định.'));
                        $('#notificationModal').modal('show');
                    }
                });
            }
        });
    });
</script>