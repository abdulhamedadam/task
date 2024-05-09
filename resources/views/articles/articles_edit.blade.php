@extends('layouts.master')
@section('css')

@endsection
@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid" >
        <div id="kt_app_content_container" class="t_container" >
            <div class="card shadow-sm " style="border-top: 3px solid #007bff;">
                <div class="card-header">
                    <h3 class="card-title"></i> {{translate('add_articles')}}</h3>
                    <div class="card-toolbar">
                        <div class="text-center">
                            <a class="btn btn-primary" href="{{ route('articles_data') }}">
                                <i class="bi bi-arrow-clockwise fs-3"></i>{{translate('back')}}
                            </a>
                        </div>
                    </div>
                </div>

                <form id="taskForm" method="post" action="{{route('update_article',$article->id)}}" enctype="multipart/form-data" >
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12 row" >

                            <div class="col-md-6">
                                <label for="basic-url" class="form-label">{{ translate('title') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title',$article->title) }}" aria-describedby="basic-addon3">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>



                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ translate('body') }}</label>
                                <textarea class="form-control @error('title') is-invalid @enderror" id="editor" name="body" rows="3" >{{ old('body',$article->body) }}</textarea>
                                <span style="color: red; font-size: 14px;" class="span_error_field_msg"></span>
                                @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>



                        <div class="col-md-12">
                            <div class="form-group text-end" style="margin-top: 27px;">
                                <button type="submit"  name="btnSave" value="btnSave" id="btnSave" class="btn btn-success btn-flat ">
                                    <i class="bi bi-save"></i> {{ translate('update') }}
                                </button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>




        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid" >
        <div id="kt_app_content_container" class="t_container" >
            <div class="card shadow-sm " style="border-top: 3px solid #007bff;">
                <div class="card-header">
                    <h3 class="card-title"></i> {{translate('images')}}</h3>
                </div>

                <form method="post" action="{{route('save_article_image',$article->id)}}" enctype="multipart/form-data" >
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12 row" style="margin-bottom: 50px">

                            <div class="col-md-6">
                                <label for="images" class="form-label">{{ translate('Images') }}</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror" name="images[]" id="images[]" aria-describedby="images-help" multiple>
                                <small id="images-help" class="form-text text-muted">{{ translate('Upload multiple images. Max file size 2MB per image.') }}</small>
                                @error('images')
                                <div class="invalid-feedback">{{ $error }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="image-gallery row">
                            @foreach($images as $image)
                                <div class="col-md-2 mb-3">
                                    <div class="card h-100">
                                        <div class="position-relative">
                                            <img src="{{ asset(Storage::disk('images')->url($image->image)) }}"  class="card-img-top gallery-image">
                                            <a   style="margin-top: -8px" onclick="return confirm('Are You Sure To Delete?')" href="{{route('delete_image',[$image->id,$article->id])}}" class=" position-absolute top-0 end-0 delete-icon" >
                                                <i  class="bi bi-trash text-danger fs-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>









                        <div class="col-md-12">
                            <div class="form-group text-end" style="margin-top: 27px;">
                                <button type="submit"  name="btnSave" value="btnSave" id="btnSave" class="btn btn-success btn-flat ">
                                    <i class="bi bi-save"></i> {{ translate('save_image') }}
                                </button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>




        </div>
    </div>








@endsection

@section('js')
    <script>
        var lang = '{{ app()->getLocale() }}'; // Wrap the locale in quotes and ensure it's a string
        ClassicEditor
            .create(document.querySelector('#editor'), {
                language: lang,
                // contentsLangDirection: 'rtl'
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

@endsection
