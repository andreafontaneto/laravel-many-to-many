@extends('layouts.admin')

@section('content')
<div class="container">
    <div>
      <h1>{{ $post->title }}</h1>

      {{-- SE la categoria esiste stampo un badge --}}
      @if ($post->category)
        <h5><span class="badge bg-secondary">{{ $post->category->name }}</span></h5> 
      @endif
      
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
