@extends('layouts.app')

@section('content')
<style>
    .grid-container {
        display: grid;
        grid-template-areas: "@foreach(range(1,config('app.imagePerColumn')) as $i) {{ "i " }}@endforeach";
        grid-gap: .5rem;
    }
    .grid-item:hover + .img-desc{
        display: inline;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="grid-container">
            @forelse ($wallpapers as $wallpaper)
                <a style="position: relative;text-decoration: none" class="text-secondary" href="{{ route('wallpaper.show', $wallpaper->getKey()) }}">
                    <img class="grid-item" onmouseout="this.parentElement.getElementsByClassName('img-desc')[0].style.display ='none'" onmouseover="this.parentElement.getElementsByClassName('img-desc')[0].style.display ='block'" style="width: 100%; margin: .5rem 0;display: inline;" src="{{ $wallpaper->previewPath }}" alt="{{ $wallpaper->name }}">
                    <div class="img-desc" style="color:white;position: absolute;bottom:6px;;width:100%;display:none;background: rgba(120, 120, 120, .5)">
                        <div style="width: 100%;padding-right:4px">
                            &nbsp; {{ $wallpaper->width }} X {{ $wallpaper->height }} <strong style="color: rgb(138, 186, 238)">|</strong> {{ $wallpaper->name }} <strong style="color: rgb(138, 186, 238)">|</strong> {{ $wallpaper->favorites_count }} Favorites
                        </div>
                    </div>
                </a>
            @empty
                <div class="card" style="background-color: rgba(120, 120, 120, .5); width: 80vw; height: 40px; padding:5px"> You have no favorites !</div>
            @endforelse
        </div>
        <div style="width: 100%">
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
    <script>
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
    </script>
@endpush
