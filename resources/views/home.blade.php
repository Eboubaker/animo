@extends('layouts.app')

@section('content')
<style>
    .grid-container {
        display: grid;
        grid-template-areas: "@foreach(range(1,config('app.imagePerColumn')) as $i) {{ "i " }}@endforeach";
        grid-gap: .5rem;
    }
    .grid-item:hover{
        display: flex;
    }
    #submit-btn{
        border: rgb(199, 199, 199) 1px solid;
        border-radius: 5px;
        background-color: rgb(237, 237, 237);
    }
    #submit-btn:hover{
        border: gray 1px solid;
        border-radius: 5px;
        background-color: rgb(229, 233, 238);
    }

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="card" style="padding: 1rem;width:100%; @if($errors->any()) border: 1px solid red @endif">
            <form action="{{ route('wallpaper.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p id='image-name'>No Image Selected</p>
                <label for="images" style="margin: 0" class="btn btn-primary">Select Image</label>
                <input multiple onchange="refreshInput()" hidden style="display: none" name="images[]" id="images" type="file">
                <button type="submit" class="btn btn-success">Upload</button>
                <h5 style="margin-top: 6px">Tags</h5>
                <input name='tags' multiple data-role="tagsinput"/>
                @if(isset($errors->all()[0]))
                    <p class="text-danger">{{ $errors->all()[0] }}</p>
                @endif

            </form>
        </div>

        <div class="container" style="margin-top: 15px">
            <div class="row">
                <form  autocomplete="off"  action="/" method="GET">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="input-group">
                            <div class="dropdown" style="margin-right:3px;display:inline-block">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="fdd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Search By Tag
                                </button>
                                <div class="dropdown-menu" aria-labelledby="fdd">
                                  <a class="dropdown-item" href="#" onclick="document.getElementById('fdd').innerHTML='Search By Tag';document.getElementById('sf').value='tag'">Search By Tag</a>
                                  <a selected="selected" class="dropdown-item" href="#" onclick="document.getElementById('fdd').innerHTML='Search By Name';document.getElementById('sf').value='name'">Search By Name</a>
                                </div>
                            </div>
                            <div style="display: inline-block">
                                <input autocomplete="false" type="text" style="border-radius: 4px;display:inline-block" size="40" class="form-control" name="search" placeholder="Search for Wallpaper" value="{{ request('search') }}">
                            </div>
                            <input id='sf' hidden style="display:none" name="filter" value="{{ request('filter') ?? 'name' }}" placeholder="Search term...">
                            <span class="input-group-btn" style="display:inline-block">
                                <button style="margin-left:3px" class="btn btn-default" id="submit-btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:100%" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg></button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="grid-container" style="margin-top: 15px">
            @foreach ($wallpapers as $wallpaper)
                <a style="position: relative;text-decoration: none;display: flex;height:fit-content" class="text-secondary" href="{{ route('wallpaper.show', $wallpaper->getKey()) }}">
                    <img class="grid-item" onmouseout="this.parentElement.getElementsByClassName('img-desc')[0].style.display ='none'" onmouseover="this.parentElement.getElementsByClassName('img-desc')[0].style.display ='block'" style="width: 100%;display: flex;" src="{{ $wallpaper->previewPath }}" alt="{{ $wallpaper->name }}">
                    <div class="img-desc" style="color:white;position: absolute;display:none;bottom:0px;;width:100%;background: rgba(120, 120, 120, .5)">
                        <div style="width: 100%;padding-right:4px">
                            &nbsp; {{ $wallpaper->width }} X {{ $wallpaper->height }} <strong style="color: rgb(138, 186, 238)">|</strong> {{ $wallpaper->name }} <strong style="color: rgb(138, 186, 238)">|</strong> {{ $wallpaper->favorites_count }} <svg style="width: 15px;height:15px; margin-bottom:4px" fill="red" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> | {{ $wallpaper->view_count }} <svg style="width: 15px;height:15px; margin-bottom:4px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div style="width: 100%;margin-top:15px">
            <div style="margin: 0 auto; width: fit-content">
                {!! $wallpapers->links() !!}
            </div>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script defer>
        function refreshInput()
        {
            let input = document.getElementById('images');
            let title = document.getElementById('image-name');
            let text = "";
            for(const file of input.files)
            {
                text += file.name + "<br/>";
            }
            title.innerHTML = text;
        }
        jQuery(document).ready(function(e){
            $('.search-panel .dropdown-menu').find('a').click(function(e) {
                e.preventDefault();
                var param = $(this).attr("href").replace("#","");
                var concept = $(this).text();
                $('.search-panel span#search_concept').text(concept);
                $('.input-group #search_param').val(param);
            });
            // Initializing the typeahead
            $("input[name='search']").typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "/tags/typeahead",
                        method: "GET",
                        data: {query: query},
                        dataType: "json",
                        success: data => result(data)
                    })
                }
            });
        });
    </script>
@endpush
