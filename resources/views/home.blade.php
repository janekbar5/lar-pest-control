@extends('layouts.master2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard ...{{Route::current()->getName()}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Request::path() == 'home')
                        // code
                    @endif


                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
