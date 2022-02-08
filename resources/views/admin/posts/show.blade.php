@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="mb-5">
      <h1>{{ $post->title }}</h1>

      {{-- SE la categoria esiste stampo un badge --}}
      @if ($post->category)
        <h5>Categoria: <span class="badge bg-secondary">{{ $post->category->name }}</span></h5> 
      @endif

      {{-- CICLO i tag prensenti SE ESITONO --}}
      @forelse ($post->tags as $tag)
        <span class="badge bg-info text-white">{{ $tag->name }}</span>
      @empty
        -
      @endforelse
      
    </div>

    <div class="mb-5">
      <p>{{ $post->content }}</p>
    </div>

    <div class="row mb-5">
      <a class="btn btn-info mr-3" href="{{ route('admin.posts.edit', $post)}}">EDIT</a>
      <form onsubmit="return confirm('Sicuro di voler eliminare questo post?')" action="{{ route('admin.posts.destroy', $post)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">DELETE</button>
      </form>
    </div>

    <div>
      <a href="{{ route('admin.posts.index') }}"> << BACK TO LIST </a>
    </div>
</div>
@endsection
