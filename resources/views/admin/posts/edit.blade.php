@extends('layouts.admin')

@section('content')
<div class="container">

  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>  
        @endforeach
      </ul>
    </div>
  @endif
    
  <h1>Modifica di: {{ $post->title }}</h1>

  <form class="mt-5" action="{{ route('admin.posts.update', $post) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
      <label for="title" class="form-label">Titolo</label>
      <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" placeholder="Inserisci il titolo del post" name="title" id="title">
      @error('title')
        <p>{{ $message }}</p>
      @enderror
    </div>
    
    <div class="mb-3">
      <label for="content" class="form-label">Contenuto</label>
      <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Inserisci il contenuto del post" name="content" id="content">{{ old('content', $post->content) }}</textarea>
      @error('content')
        <p>{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <label for="category_id" class="form-label">Categoria</label>
      <select class="form-control" name="category_id" id="category_id">
        <option value="">Selezionare una categoria</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}" @if($category->id == old('category_id', $post->category_id)) selected @endif>
              {{ $category->name }}
            </option>
          @endforeach
      </select>
    </div>

    <div class="mb-3">
      <h6>Tags</h6>
      @forelse ($tags as $tag)
        <div class="mr-5 d-inline-block">
          <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" name="tags[]" id="tag{{ $tag->id }}"
          {{-- SE $tag->id è presente dentro ad old OPPURE SE la chiave tags (che è un array) contiene $tag->id cioè l'id che sto iterando --}}
          {{-- ALLORA stampami "checked" dentro all'input --}}

          {{-- SE al primo caricamento non ci sono errori stampo "checked" --}}
          @if (!$errors->any() && $post->tags->contains($tag->id))
              checked
          {{-- SE INVECE ci sono errori "checked" viene stampato dalla regola data dall'old() --}}
          @elseif ($errors->any() && in_array($tag->id, old('tags', [])))
              checked
          @endif
          >
          <label class="form-check-label" for="tag{{ $tag->id }}">
            {{ $tag->name }}
          </label>
        </div>
      @empty
          -
      @endforelse
    </div>
    
    <button type="submit" class="btn btn-success">Invia</button>
  </form>

</div>
@endsection
