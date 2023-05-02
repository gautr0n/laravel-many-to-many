@extends('layouts.app')

@section('content')
    @if (request()->session()->exists('message'))
    <div class="alert fixed alert-primary" role="alert">
        {{ request()->session()->pull('message') }}
    </div>
    @endif

    <div class="container py-5">
        <div class="d-flex alig-items-center">
            <h1 class="me-auto">Tutti i progetti</h1>

            <div>
                @if (request('trashed'))
                    <a class="btn btn-sm btn-light" href="{{ route('projects.index') }}">Tutti i progetti</a>
                @else
                    <a class="btn btn-sm btn-light" href="{{ route('projects.index', ['trashed' => true]) }}">Cestino ({{ $num_of_trashed }})</a>
                @endif
                <a class="btn btn-sm btn-primary" href="{{ route('projects.create') }}">Nuovo Progetto</a>
                
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table table-stripped table-inverse table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>title</th>
                    <th>description</th>
                    <th>link</th>
                    <th>type</th>
                    <th>slug</th>
                    <th>data creazione</th>
                    <th>data modifica</th>
                    <th>eliminato</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>
                            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
                        </td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->website_link}}</td>
                        <td>{{ $project->type ? $project->type->name : '_'}}</td>
                        <td>
                            @forelse($project->technologies as $technology)
                                <span class="badge rounded-pill text-bg-primary">{{ $technology->name }}</span>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>{{ $project->slug }}</td>
                        <td>{{ $project->created_at->format('d/m/Y') }}</td>
                        <td>{{ $project->updated_at->format('d/m/Y') }}</td>
                        <td>
                            {{ $project->trashed() ? $project->deleted_at->format('d/m/Y H:i') : '' }}
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-sm btn-secondary" href="{{ route('projects.edit', $project) }}">Edit</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-sm btn-danger" value="Elimina">
                                </form>
                                @if ($project->trashed())
                                <form action="{{ route('projects.restore', $project) }}" method="POST">
                                    @csrf 
                                    <input type="submit" value="Ripristina" class="btn btn-sm btn-success">
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="9">nessun progetto trovato</th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection