<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            @if(!empty($item->id)) @lang('taskPriority.edit') @else @lang('taskPriority.create') @endif
        </div>
        <div class="card-body">
            <form id="formCrud" method="post" enctype="multipart/form-data"
                  action="{{route('taskPriority.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="name">@lang('taskPriority.name')</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('taskPriority.errors.name')"
                                   placeholder="@lang('taskPriority.name')"
                                   value="{{ old('name',$item->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text_color">@lang('taskPriority.text_color')</label>
                            <input type="color" id="text_color" name="text_color"
                                   class="form-control @error('text_color') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('taskPriority.errors.text_color')"
                                   placeholder="@lang('taskPriority.text_color')"
                                   value="{{ old('text_color',$item->text_color) ?? '#ffffff' }}">
                            @error('text_color')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="background_color">@lang('taskPriority.background_color')</label>
                            <input type="color" id="background_color" name="background_color"
                                   class="form-control @error('background_color') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('taskPriority.errors.background_color')"
                                   placeholder="@lang('taskPriority.background_color')"
                                   value="{{ old('background_color',$item->background_color) }}">
                            @error('background_color')
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
                                        class="fe-check-circle mr-1"></i> @lang('taskPriority.edit')
                            </button>
                        @else
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('taskPriority.create')
                            </button>
                        @endif
                        @if(!empty($item->id))
                            <button type="button" onclick="location='{{route('taskPriority.index')}}'"
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
