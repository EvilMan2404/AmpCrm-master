<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            @if(!empty($item->id)) @lang('purchaseStatus.edit') @else @lang('purchaseStatus.create') @endif
        </div>
        <div class="card-body">
            <form class="companyForm" method="post" enctype="multipart/form-data"
                  action="{{route('purchaseStatus.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="name">@lang('purchaseStatus.name')</label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('purchaseStatus.errors.name')"
                                   placeholder="@lang('purchaseStatus.name')"
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
                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" name="final" value="1" class="custom-control-input" id="final"
                                       @if(old('final',$item->final)) checked @endif>
                                <label class="custom-control-label"
                                       for="final">@lang('purchaseStatus.final')</label>
                                <button class="btn" title="@lang('purchaseStatus.prompt')"
                                        data-plugin="tippy" data-tippy-placement="top">
                                    <i class="fas fas fa-question-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row -->
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        @if(!empty($item->id))
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('purchaseStatus.edit')
                            </button>
                        @else
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('purchaseStatus.create')
                            </button>
                        @endif
                        @if(!empty($item->id))
                            <button type="button" onclick="location='{{route('purchaseStatus.index')}}'"
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
