@php
    use App\Helpers\IdEncoder;
@endphp

@forelse ($vouchers as $index => $voucher)
    <tr class="voucher-detail1" 
        data-id="{{ IdEncoder::encodeId($voucher->promotion_id) }}" 
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


