<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            @if(!empty($item->id)) @lang('space.edit') @else @lang('space.create') @endif
        </div>
        <div class="card-body">
            <form class="companyForm" method="post" enctype="multipart/form-data"
                  action="{{route('space.save',!empty($item->id)?['id'=>$item->id]:[])}}">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="title">@lang('space.name')</label>
                            <input type="text" id="title" name="title"
                                   class="form-control @error('title') is-invalid @enderror" required
                                   data-parsley-required-message="@lang('space.errors.name')"
                                   placeholder="@lang('space.name')"
                                   value="{{ old('title',$item->title) }}">
                            @error('title')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="roles">@lang('space.roles')</label>
                            <div>
                                <select
                                        data-info="{{route('request.getCatalog')}}"
                                        data-searching="@lang('space.search.searching')"
                                        data-no-results="@lang('space.search.noResults')"
                                        data-start="@lang('space.search.start')"
                                        data-placeholder="@lang('space.search.roles')"
                                        data-url="{{route('request.getRoles')}}"
                                        multiple="multiple" id="roles" name="roles[]"
                                        class="@error('roles') is-invalid @enderror form-control"
                                        data-toggle="select2">

                                    @foreach($rolesInfo as $value)
                                        <option selected="selected"
                                                value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('roles')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                            @error('roles.*')
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
                                        class="fe-check-circle mr-1"></i> @lang('space.edit')
                            </button>
                        @else
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle mr-1"></i> @lang('space.create')
                            </button>
                        @endif
                        @if(!empty($item->id))
                            <button type="button" onclick="location='{{route('space.index')}}'"
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
