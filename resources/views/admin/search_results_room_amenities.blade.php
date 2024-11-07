@php
    use App\Helpers\IdEncoder;
@endphp

@if ($roomAmenitie->isEmpty())
    <tr>
        <td colspan="3" class="text-center">Không tìm thấy kết quả</td>
    </tr>
@else
    @foreach ($roomAmenitie as $key => $roomAmenities)
        <tr>
            <td style="width: 10%;">{{ $key + 1 }}</td>
            <td style="width: 30%;">{{ $roomAmenities->amenity_name }}</td>
            <td style="width: 40%">{{ $roomAmenities->description }}</td>
            <td style="width: 20%;">
                <div class="d-flex justify-content-around align-items-center">
                    <a href="{{ route('admin.room_amenities.edit', IdEncoder::encodeId($roomAmenities->amenity_id)) }}"
                        class="btn btn-info btn-sm" title="Edit">
                        <i class="bi bi-pencil-fill" style="margin-right: 5px"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal"
                        onclick="setDeleteAction('{{ route('admin.room_amenities.delete', IdEncoder::encodeId($roomAmenities->amenity_id)) }}')">
                        <i class="bi bi-x-circle" style="margin-right: 5px;"></i> Delete
                    </button>

                </div>
            </td>
        </tr>
    @endforeach
@endif
