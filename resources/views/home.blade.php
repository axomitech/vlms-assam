@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       @foreach ($sessionUser as $value)
           
       <div class="col-md-4">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{$value['department_name']}}</h5>
              <p class="card-text">{{$value['role_name']}}</p>
              <a href="{{ route('session_user',[$value['session_user'],$value['department_id'],$value['role_id']]) }}" class="btn btn-primary">Continue</a>
            </div>
          </div>      
    </div>

       @endforeach
    </div>
</div>
@endsection
