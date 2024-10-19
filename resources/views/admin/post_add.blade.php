@extends('admin.layouts.master')
@section('admin-container')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <!-- Account -->
                <hr class="my-0"/>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="{{ asset('/images/img-upload.jpg') }}"
                                    alt="user-avatar"
                                    class=""
                                    height="100"
                                    width="100"
                                    id="fileUpload"
                                />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input
                                            type="file"
                                            id="upload"
                                            name="fileUpload"
                                            class="account-file-input"
                                            hidden
                                            accept="image/png, image/jpeg, image/jpg"
                                        />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="formAccountSettings" method="GET" onsubmit="return false" enctype="multipart/form-data">
                        <div class="row">
                                <div class="mb-3 col-md-12">
                                <label class="form-label">Title</label>
                                <input class="form-control" type="text" name="title" id="title" placeholder="title" required/>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="description"></textarea>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Content</label>
                                <textarea name="content" id="content"></textarea>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Meta Desc</label>
                                <input class="form-control" type="text" id="meta_desc" name="meta_Desc" placeholder="Meta Desc" autofocus required/>
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label">Status</label>
                                <select id="status" class="select2 form-select">
                                    <option value="show" selected>Show</option>
                                    <option value="hidden">Hidden</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Url Seo</label>
                                <input class="form-control" type="text" id="Url_Seo" name="url_Seo" placeholder="Url Seo" autofocus readonly/>
                            </div>
                        </div>
                        <div class="mt-2" style="text-align: right">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="button" class="btn btn-outline-danger" onclick="window.location.href='{{ route('admin.viewpost') }}'">Close</button>
                            <button type="submit" class="btn btn-outline-success me-2 add_post">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<script>
      window.onload = function() {
        CKEDITOR.replace('content',{
            filebrowserUploadUrl: "path/to/upload/image"
        });
    };
     
        CKEDITOR.replace('description',{
            filebrowserUploadUrl: "path/to/upload/image"
        });
  
</script>
@endsection

