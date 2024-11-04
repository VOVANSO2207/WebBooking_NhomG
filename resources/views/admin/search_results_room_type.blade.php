@php
    use App\Helpers\IdEncoder;
@endphp

@if($roomType->isEmpty())
    <tr>
        <td colspan="3" class="text-center">Không tìm thấy kết quả</td>
    </tr>
@else
    @foreach ($roomType as $key => $roomTypes)
        <tr>
            <td style="width: 10%;">{{ $key + 1 }}</td>
            <td style="width: 70%;">{{ $roomTypes->name }}</td>
            <td style="width: 20%;">
                <div class="d-flex justify-content-around align-items-center">
                    <a href="{{ route('admin.roomtype.edit', IdEncoder::encodeId($roomTypes->room_type_id)) }}" class="btn btn-info btn-sm" title="Edit">
                        <i class="bi bi-pencil-fill" style="margin-right: 5px"></i> Edit
                    </a>
                    <button type="button" 
                            class="btn btn-danger btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmDeleteModal" 
                            onclick="setDeleteAction('{{ route('admin.roomtype.delete', IdEncoder::encodeId($roomTypes->room_type_id)) }}')">
                        <i class="bi bi-x-circle" style="margin-right: 5px;"></i> Delete
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
@endif
