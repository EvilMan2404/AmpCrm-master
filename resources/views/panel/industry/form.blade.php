<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            @if(!empty($item->id)) @lang('industry.edit') @else @lang('industry.create') @endif
        </div>
        <div class="card-body">
            <form class="companyForm" method="post" enctype="multipart/form-data"
                  action="{{route('industry.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="title">@lang('industry.name')</label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('industry.errors.name')"
                                   placeholder="@lang('industry.name')"
                                   value="{{ old('title',$item->title) }}">
                            @error('title')
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
                                        class="fe-check-circle mr-1"></i> @lang('industry.edit')
                            </button>
                        @else
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('industry.create')
                            </button>
                        @endif
                        @if(!empty($item->id))
                            <button type="button" onclick="location='{{route('industry.index')}}'"
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
