@extends('layouts.master')
@section('css')


@endsection
@section('content')


    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="t_container">


            <div class="card shadow-sm" style="border-top: 3px solid #007bff;">
                <div class="card-header" style="background-color: #f8f9fa;">
                    <h3 class="card-title"></i> {{translate('images')}}</h3>
                    <div class="card-toolbar">
                        <div class="text-center">
                            <a class="btn btn-primary" href="{{ route('articles_data') }}">
                                <i class="bi bi-arrow-clockwise fs-3"></i>{{translate('back')}}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="padding-left: 0px !important;">
                    <div class="col-md-12 row">
                        <div class="col-md-8">

                            <div class="" style="margin-top: 30px">
                                @if(!empty($images) && $images->isNotEmpty())
                                    <table id="table"
                                           class="example table table-bordered responsive nowrap text-center"
                                           cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr class="greentd" style="background-color: lightgrey">
                                            <th>{{translate('hash') }}</th>
                                            <th>{{ translate('image_type') }}</th>
                                            <th>{{ translate('attachment') }}</th>
                                            <th>{{ translate('image_size') }}</th>
                                            <th>{{ translate('added_date') }}</th>
                                            <th>{{ translate('added_time') }}</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $x = 1;
                                            $image = ['gif', 'Gif', 'ico', 'ICO', 'jpg', 'JPG', 'jpeg', 'JPEG', 'BNG', 'png', 'PNG', 'bmp', 'BMP'];
                                            $file = ['pdf', 'PDF', 'xls', 'xlsx', ',doc', 'docx', 'txt'];
                                        @endphp
                                        @foreach ($images as $morfaq)
                                            @php
                                                $ext = pathinfo($morfaq->image, PATHINFO_EXTENSION);
                                                $folder = Storage::disk('images');
                                                $Destination = $folder->path($morfaq->image);
                                                if(file_exists($Destination)) {
                                                                           $size= formatFileSize($Destination);
                                                                            }else{
                                                                            $size =0;
                                                                            }

                                            @endphp
                                            <tr>
                                                <td>{{ $x++ }}</td>
                                                <td>

                                                    @if (in_array($ext, $image))
                                                        <i class="bi bi-image fs-2" aria-hidden="true"></i>
                                                    @elseif (in_array($ext, $image))
                                                        <i class="bi bi-image-pdf fs-2" aria-hidden="true"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (in_array($ext, $image))
                                                        <a data-bs-toggle="modal"
                                                           data-bs-target="#myModal-view-{{ $morfaq->id }}">
                                                            <i class="bi bi-eye fs-2"
                                                               title="{{ __('view_image') }}"></i>
                                                        </a>

                                                        <div class="modal fade" tabindex="-1"
                                                             id="myModal-view-{{ $morfaq->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title">Modal title</h3>

                                                                        <!--begin::Close-->
                                                                        <div
                                                                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <i class="ki-duotone ki-cross fs-1">&times;</i>
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <img
                                                                            src="{{ asset(Storage::disk('images')->url($morfaq->image)) }}"
                                                                            width="100%" alt="">
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                                class="btn btn-light"
                                                                                data-bs-dismiss="modal">Close
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @elseif (in_array($ext, $image))
                                                        <a data-bs-toggle="modal"
                                                           data-bs-target="#myModal-pdf-{{ $morfaq->id }}">
                                                            <i class="bi bi-eye fs-2"
                                                               title="{{ __('view_image') }}"></i>
                                                        </a>

                                                        <div class="modal fade" tabindex="-1"
                                                             id="myModal-pdf-{{ $morfaq->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h3 class="modal-title">Modal title</h3>

                                                                        <!--begin::Close-->
                                                                        <div
                                                                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <i class="ki-duotone ki-cross fs-1">&times;</i>
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <iframe
                                                                            src="{{ route('admin.case_read_image',$morfaq->id) }}"
                                                                            style="width: 100%; height: 640px;"
                                                                            frameborder="0"></iframe>

                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                                class="btn btn-light"
                                                                                data-bs-dismiss="modal">Close
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif

                                                </td>
                                                <td class="fnt_center_blue">
                                                    {{ $size }}
                                                </td>

                                                <td class="fnt_center_black">{{ \Illuminate\Support\Carbon::parse($morfaq->created_at)->format('Y-m-d') }}</td>
                                                <td class="fnt_center_red">{{ \Illuminate\Support\Carbon::parse($morfaq->created_at)->format('H:i:s') }}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>


                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow  bg-white rounded">
                                <div class="card-header" style="background-color: #f8f9fa;">
                                    <h3 class="card-title"><i
                                            class="fas fa-text-width"></i> <?= translate('article_details') ?></h3>
                                </div>
                                <div class="card-body" style="padding: 20px !important;">
                                    <table class="table table-bordered table-sm table-striped">
                                        <tbody>
                                        <tr>
                                            <td class="class_label" style="width: 25%"><?= translate('title') ?></td>
                                            <td class="class_result"><?php echo $article->title; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="class_label" style="width: 25%"><?= translate('body') ?></td>
                                            <td class="class_result"><?php echo $article->body; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

    </div>









@endsection

@section('js')


    @notifyJs

@endsection



