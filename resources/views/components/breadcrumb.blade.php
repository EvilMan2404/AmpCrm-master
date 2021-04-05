<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @foreach($bc as $item)
                        @if(!empty($item['active']))
                            <li class="breadcrumb-item active">{{$item['name']}}</li>

                        @else
                            <li class="breadcrumb-item"><a href="{{$item['link']}}">{{$item['name']}}</a></li>
                        @endif

                    @endforeach
                </ol>
            </div>
            <h4 class="page-title">{{$title}}</h4>
        </div>
    </div>
</div>
<!-- end page title -->