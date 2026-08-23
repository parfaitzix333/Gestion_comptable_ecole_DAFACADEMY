@extends('base.base_enseignant')
@section('content')
    @if ($user->enseignant ?? '')
        <div class="card w-100">
            <b><i>{{ $user->enseignant->classe->designation ?? '' }}</i></b>
        </div>
    @else
        <p>---</p>
    @endif

    <div class="carde m-4 text-center">
        Page en cours de developpement...
    </div>
@endsection
