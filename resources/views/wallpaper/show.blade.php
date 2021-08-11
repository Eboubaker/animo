@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card text-white" style="width: 100%;padding: 25px;background:rgb(16 33 56)">
        <div class="row">
            <div class="col">
                <h5>{{ $wallpaper->name }}</h5>
                <h5>Tags:
                    @foreach ($wallpaper->tags as $tag)
                        <a style="color:green" href="/?filter=tag&search={{ urlencode($tag->name) }}">{{ $tag->name }} </a>
                        @if(!$loop->last)
                            |
                        @endif
                    @endforeach
                </h5>
            </div>
            <div class="col">
                <div style="position: relative">
                    <div style="position: absolute; right:0">
                        <a style="margin-top: 1rem" class="btn btn-danger" href="{{ route('wallpaper.favorite', $wallpaper->getKey()) }}">@if($wallpaper->isFavorite) <svg xmlns="http://www.w3.org/2000/svg" style="width: 18px; height:18px;margin-bottom:4px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg> Remove Favorite @else <svg style="width: 18px; height:18px;margin-bottom:4px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg> Favorite @endif </a>
                        <a style="margin-top: 1rem" class="btn btn-success" href="{{ $wallpaper->path }}" download="download"><svg style="width: 18px; height:18px;margin-bottom:4px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img style="width: 100%" src="{{ $wallpaper->path }}" alt="">
    <div class="card" style="width: 100%;padding: 25px;background:rgb(16 33 56)">
        <table class="table table-dark" style="border-radius: 4px">
            <tbody>
                <tr>
                    <th style="width: 120px">Dimensions</th>
                    <td style="width: 20px"><svg style="width: 18px; height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg></td>
                    <td>{{ $wallpaper->width }} X {{ $wallpaper->height }}</td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td><svg style="width: 18px; height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></td>
                    <td>{{ humanFileSize($wallpaper->size) }}</td>
                </tr>
                <tr>
                    <th>Favorites</th>
                    <td><svg style="width: 18px; height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></td>
                    <td>{{ $wallpaper->favorites()->count() }}</td>
                </tr>
                <tr>
                    <th>Views</th>
                    <td><svg style="width: 18px; height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></td>
                    <td>{{ $wallpaper->view_count+1 }}</td>
                </tr>
                <tr>
                    <th>Uploaded At</th>
                    <td><svg style="width: 18px; height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></td>
                    <td>{{ $wallpaper->created_at->format('d-m-Y') }}</td>
                </tr>
            </tbody>
        </table>
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
