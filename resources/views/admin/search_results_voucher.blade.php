@php
    use App\Helpers\IdEncoder;
@endphp

@forelse ($vouchers as $index => $voucher)
    <tr class="voucher-detail1" data-id="{{ IdEncoder::encodeId($voucher->promotion_id) }}"
        data-updated-at="{{ $voucher->updated_at }}">
        <td>{{ $index + 1 }}</td>
        <td>{{ $voucher->promotion_code }}</td>
        <td>{{ $voucher->discount_amount }}</td>
        <td>{{ $voucher->start_date }}</td>
        <td>{{ $voucher->end_date }}</td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">Không có bài viết nào để hiển thị.</td>
    </tr>
@endforelse
<div class="d-flex justify-content-center mt-3">
    {{ $vouchers->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
</div>
<script>
    $(document).ready(function () {
        let currentVoucherId = null; 
        let currentUpdatedAt = null; 

        $('.voucher-detail1 td').on('click', function () {
            const $row = $(this).closest('tr'); 
            currentVoucherId = $row.data('id'); 
            currentUpdatedAt = $row.data('updated-at'); 

            console.log(`/voucher/${currentVoucherId}/detail`);

            $.ajax({
                url: `/voucher/${currentVoucherId}/detail`,
                method: 'GET',
                dataType: 'json',
                success: function (voucher) {
                    $('#modalPromotionCode').text(voucher.promotion_code);
                    $('#modalDiscountAmount').text(voucher.discount_amount);
                    $('#modalStartDate').text(voucher.start_date);
                    $('#modalEndDate').text(voucher.end_date);

                    $('#voucherDetailModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Có lỗi xảy ra với yêu cầu AJAX:', error);
                    alert('Có lỗi xảy ra khi lấy thông tin voucher. Vui lòng thử lại.');
                }
            });
        });

        $('.delete-voucher').on('click', function () {
            currentVoucherId = $(this).data('id');

            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDeleteButton').on('click', function () {
            if (currentVoucherId) {
                const deleteRoute = "{{ route('voucher.delete', ['promotion_id' => ':id']) }}".replace(':id', currentVoucherId);
                $.ajax({
                    url: deleteRoute,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({ updated_at: currentUpdatedAt }), 
                    success: function (data) {
                        $('#notificationModalBody').text('Xóa Voucher Thành Công');
                        $('#notificationModal').modal('show');

                        setTimeout(() => {
                            location.reload();
                        }, 1500); 
                    },
                    error: function (xhr) {
                        console.error('Có lỗi xảy ra:', xhr.responseJSON);
                        $('#notificationModalBody').text('Có lỗi xảy ra: ' + (xhr.responseJSON.error || 'Đã xảy ra lỗi không xác định.'));
                        $('#notificationModal').modal('show');
                    }
                });
            }
        });
    });
</script>