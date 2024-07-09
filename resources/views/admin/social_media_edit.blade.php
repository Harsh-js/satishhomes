@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">{{ EDIT_SOCIAL_MEDIA_ITEM }}</h1>

    <form action="{{ route('admin_social_media_update',$social_media->id) }}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_social_media_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">{{ URL }} *</label>
                            <input type="text" name="social_url" class="form-control" value="{{ $social_media->social_url }}" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">{{ EXISTING_ITEM }}</label>
                            <div class="col-sm-5">
                                <div class="pt_10">
                                    <i class="{{ $social_media->social_icon }}"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">{{ ICON_FONT_AWESOME_5_CODE }} *</label>
                            <div>
                                <input type="text" class="icp icp_demo form-control dropdown-toggle iconpicker-component" data-toggle="dropdown" name="social_icon" value="{{ $social_media->social_icon }}">
                                <div class="dropdown-menu"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">{{ ORDER }}</label>
                            <input type="text" name="social_order" class="form-control" value="{{ $social_media->social_order }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{ UPDATE }}</button>
            </div>
        </div>
    </form>

@endsection
