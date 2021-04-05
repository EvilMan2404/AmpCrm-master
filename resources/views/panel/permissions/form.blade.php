<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            @if(!empty($item->id)) @lang('permissions.edit') @else @lang('permissions.create') @endif
        </div>
        <div class="card-body">
            <form id="formCrud" method="post" enctype="multipart/form-data"
                  action="{{route('permissions.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="title">@lang('permissions.name')</label>
                            <input type="text" id="title" name="name"
                                   class="form-control @error('name') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('permissions.errors.required')"
                                   placeholder="@lang('permissions.name')"
                                   value="{{ old('name',$item->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="guard_name">@lang('permissions.guard_name')</label>
                            <input type="text" id="guard_name" name="guard_name"
                                   class="form-control @error('guard_name') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('permissions.errors.required')"
                                   placeholder="@lang('permissions.guard_name')"
                                   value="{{ old('guard_name',$item->guard_name) }}">
                            @error('guard_name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="desc">@lang('permissions.desc')</label>
                            <input type="text" id="desc" name="desc"
                                   class="form-control @error('desc') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('permissions.errors.required')"
                                   placeholder="@lang('permissions.desc')"
                                   value="{{ old('desc',$item->desc) }}">
                            @error('desc')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row -->
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        @if(!empty($item->id))
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('permissions.edit')
                            </button>
                        @else
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('permissions.create')
                            </button>
                        @endif
                        @if(!empty($item->id))
                            <button type="button" onclick="location='{{route('permissions.index')}}'"
                                    class="btn btn-light waves-effect waves-light m-1"><i
                                        class="fe-x mr-1"></i> Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </form> <!-- end card-body -->
        </div>
    </div>
</div>
