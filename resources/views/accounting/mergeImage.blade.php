@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .images-preview-div img {
            padding: 10px;
            max-width: 200px;
        }

    </style>
    <div class="card">
        <div class="card-header font-weight-bold text-center">
            <h3 class="well">Merging Images</h3>
        </div>
        <div class="card-body">
            <form name="images-upload-form" method="post" action="{{ route('merge.image') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" name="images[]" id="images" class="myfrm form-control"
                                placeholder="Choose images" multiple>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-1 text-center">
                            <div class="images-preview-div"> </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="submit">Merging and Download</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(function() {
            // Multiple images preview with JavaScript
            var previewImages = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#images').on('change', function() {
                previewImages(this, 'div.images-preview-div');
            });
        });
    </script>
@endsection
