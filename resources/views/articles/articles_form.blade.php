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




                <form id="taskForm" method="post" action="{{route('save_article')}}" enctype="multipart/form-data" >
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12 row" >

                            <div class="col-md-6">
                                <label for="basic-url" class="form-label">{{ translate('title') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}" aria-describedby="basic-addon3">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <div class="col-md-6">
                                <label for="images" class="form-label">{{ translate('Images') }}</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" id="images[]" aria-describedby="images-help" multiple>
                                @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ translate('body') }}</label>
                                <textarea class="form-control @error('title') is-invalid @enderror" id="editor" name="body" rows="3" >{{ old('body') }}</textarea>
                                <span style="color: red; font-size: 14px;" class="span_error_field_msg"></span>
                                @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>



                        <div class="col-md-12">
                            <div class="form-group text-end" style="margin-top: 27px;">
                                <button type="submit"  name="btnSave" value="btnSave" id="btnSave" class="btn btn-success btn-flat ">
                                    <i class="bi bi-save"></i> {{ translate('SaveButton') }}
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
