@extends('admin.layouts.master')

@php
    use App\Helpers\IdEncoder;
    use Carbon\Carbon;
@endphp

@section('admin-container')
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center" style="width: 100%;">
            <div class="nav-item d-flex align-items-center" style="width: 100%;">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" id="search_voucher" placeholder="Search..."
                    aria-label="Search..." style="width: 100%;" />
            </div>
        </div>
        <!-- /Search -->
    </div>
</nav>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header" style="background-color: #696cff; border-color: #696cff; color:#fff">VOUCHER</h5>
            <div class="add">
                <a href="{{route(name: 'voucher_add')}}" class="btn btn-success">Add</a>
            </div>
            <div class="table-responsive text-nowrap content1">
                <table class="table">
                    <thead>
                        <tr class="color_tr">
                            <th>STT</th>
                            <th>Promotion Title</th>
                            <th>Promotion Code</th>
                            <th>Discount Amount</th>
                            <th>Promotion Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @if($vouchers->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Không có voucher nào hiển thị</td>
                            </tr>
                        @else
                                                @php
                                                    $today = Carbon::today();
                                                @endphp

                                                @foreach($vouchers as $key => $voucher)
                                                                    @php
                                                                        $textClass = '';
                                                                        $endDate = Carbon::createFromFormat('d/m/Y', $voucher->end_date);
                                                                        if ($endDate->isPast()) {
                                                                            $textClass = 'text-danger';
                                                                        }
                                                                    @endphp
                                                                    <tr class="voucher-detail" data-id="{{ IdEncoder::encodeId($voucher->promotion_id) }}"
                                                                        data-updated-at="{{ $voucher->updated_at }}">
                                                                        <td class="{{ $textClass }}">{{ $key + 1 }}</td>
                                                                        <td class="{{ $textClass }}">{{ Str::limit( $voucher->pro_title, 30)}}</td>
                                                                        <td class="{{ $textClass }}">{{ $voucher->promotion_code }}</td>
                                                                        <td class="{{ $textClass }}">{{ $voucher->discount_amount }}%
                                                                        </td>
                                                                        <td class="{{ $textClass }}">{{ \Str::limit($voucher->pro_description, 10) }}</td>
                                                                        <td class="{{ $textClass }}">{{ $voucher->start_date }}</td>
                                                                        <td class="{{ $textClass }}">{{ $voucher->end_date }}</td>
                                                                    </tr>
                                                                   
                                                @endforeach
                        @endif
                    </tbody>
                    <tbody id="Content" class="searchdata">
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 pagination-voucher">
                {{ $vouchers->appends(['csrf_token' => csrf_token()])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal for voucher details -->
<div class="modal fade" id="voucherDetailModal" tabindex="-1" aria-labelledby="voucherDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherDetailModalLabel">Voucher Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="voucher-detail">
                    <div class="voucher-detail-item detail-item">
                        <strong>Promotion Title:</strong>
                        <span id="modalPromotionTitle"></span>
                    </div>
                    <div class="voucher-detail-item detail-item">
                        <strong>Promotion Code:</strong>
                        <span id="modalPromotionCode"></span>
                    </div>
                    <div class="voucher-detail-item detail-item">
                        <strong>Discount Amount:</strong>
                        <span id="modalDiscountAmount"></span>
                    </div>
                    <div class="voucher-detail-item detail-item">
                        <strong>Promotion Description:</strong>
                        <span id="modalProDescription"></span>
                    </div>

                    <div class="voucher-detail-item detail-item">
                        <strong>Start Date:</strong>
                        <span id="modalStartDate"></span>
                    </div>
                    <div class="voucher-detail-item detail-item">
                        <strong>End Date:</strong>
                        <span id="modalEndDate"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: space-between;">
                <a id="editVoucherButton" class="btn btn-info">Edit</a>
                <button type="button" class="btn btn-danger" id="deleteVoucherButton" data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal">Delete</button>
            </div>
            <div class="modal-footer" style="width: 100%; position: relative; bottom: 0;">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for confirm delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">XÁC NHẬN XOÁ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa Voucher này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for notifications -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Thông Báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificationModalBody">
                <!-- Nội dung thông báo sẽ được chèn vào đây -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="#3B79C9 !important" data-bs-dismiss="modal"
                    onclick="location.reload()">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const voucherDetailRows = document.querySelectorAll('.voucher-detail');
        let currentVoucherId = null;
        let currentUpdatedAt = null;

        // Handle row click for details
        voucherDetailRows.forEach(row => {
            row.addEventListener('click', function () {
                currentVoucherId = this.getAttribute('data-id');
                currentUpdatedAt = this.getAttribute('data-updated-at');

                // Fetch voucher details
                fetch(`/voucher/${currentVoucherId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(voucher => {
                        document.getElementById('modalPromotionTitle').innerText = voucher.pro_title;
                        document.getElementById('modalPromotionCode').innerText = voucher.promotion_code;
                        let discountAmount = voucher.discount_amount;
                        let formattedAmount = Number(discountAmount).toLocaleString('vi-VN') + '%';
                        document.getElementById('modalDiscountAmount').innerText = formattedAmount;
                        document.getElementById('modalProDescription').innerText = voucher.pro_description ? voucher.pro_description.substring(0, 10) : 'Không có mô tả';

                        document.getElementById('modalStartDate').innerText = voucher.start_date;
                        document.getElementById('modalEndDate').innerText = voucher.end_date;

                        // Thiết lập đường dẫn cho nút Edit
                        const editRoute = "{{ route('voucher.edit', ['promotion_id' => ':id']) }}".replace(':id', currentVoucherId);

                        document.getElementById('editVoucherButton').setAttribute('href', editRoute);

                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('voucherDetailModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    });
            });
        });

        // Handle delete button click
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.addEventListener('click', function () {
            if (currentVoucherId) {
                const deleteRoute = "{{ route('voucher.delete', ['promotion_id' => ':id']) }}".replace(':id', currentVoucherId);

                fetch(deleteRoute, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ updated_at: currentUpdatedAt }) // Gửi updated_at
                })
                    .then(response => {
                        return response.json().then(data => {
                            if (!response.ok) {
                                // Nếu có lỗi từ server, hiển thị thông báo lỗi
                                console.error('Error response:', data);
                                document.getElementById('notificationModalBody').innerText = 'Lỗi: ' + (data.error || 'Đã xảy ra lỗi không xác định.');
                                const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                                modal.show();
                            } else {
                                // Nếu không có lỗi, hiển thị thông báo thành công
                                document.getElementById('notificationModalBody').innerText = 'Xóa Voucher Thành Công';
                                const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                                modal.show();

                                // Reload the page after a short delay (optional)
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra:', error);
                        document.getElementById('notificationModalBody').innerText = 'Có lỗi xảy ra: ' + error.message;
                        const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                        modal.show();
                    });
            }
        });

        // Lắng nghe sự kiện khi modal đã hoàn toàn đóng
        document.getElementById('confirmDeleteModal').addEventListener('hidden.bs.modal', function () {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove(); // Loại bỏ lớp mờ
            }
        });

        // Đảm bảo nút Cancel đóng modal
        document.getElementById('cancelButton').addEventListener('click', function () {
            const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            confirmDeleteModal.hide(); // Ẩn modal
        });
    });


</script>




@endsection