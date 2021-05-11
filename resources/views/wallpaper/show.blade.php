@extends('layouts.app')

@section('content')

<div class="container">
    <img style="width: 100%" src="{{ $wallpaper->path }}" alt="">
    <div class="card" style="width: 100%;padding: 25px;background:rgb(178, 179, 176)">
        <strong>{{ $wallpaper->name }} {{ $wallpaper->width }} X {{ $wallpaper->height }} {{ humanFileSize($wallpaper->size) }}</strong>
    </div>
    <div style="width: 100%">
        <div style="width: fit-content;margin: 0 auto">
            <a style="margin-top: 1rem" class="btn btn-danger" href="{{ route('wallpaper.favorite', $wallpaper->getKey()) }}">@if($wallpaper->isFavorite) Remove Favorite @else Favorite @endif </a>
            <a style="margin-top: 1rem" class="btn btn-success" href="{{ $wallpaper->path }}" download="download">Download</a>
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
