@extends('layouts.app')

@section('content')
    <form method="post"
          action="@if(isset($student)){{route('students.update', $student)}} @else{{route('students.store')}}@endif"
          enctype="multipart/form-data">
        @if(isset($student))
            {{method_field('PATCH')}}
        @endif
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name"
                       @if(isset($student)) value="{{$student->name}}" @endif>
            </div>

            <div class="form-group col-md-6">
                <label for="gender">Sex</label>
                <select name="gender" id="gender" class="form-control">
                    @if(isset($student))
                        <option value="1" @if($student->gender_id == 1) selected @endif>Female</option>
                        <option value="2" @if($student->gender_id == 2) selected @endif>Male</option>
                    @else
                        <option selected disabled>Choose...</option>
                        <option value="1">Female</option>
                        <option value="2">Male</option>
                    @endif
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" name="address" id="inputAddress"
                       @if(isset($student)) value="{{$student->place_of_birth}}" @endif placeholder="1234 Main St">
            </div>
            <div class="form-group col-md-6">
                <label for="datepicker">Date time</label>
                <input type="text" class="form-control" name="date_time" id="datepicker" placeholder="2019-09-12"
                       @if(isset($student)) value="{{$student->date_of_birth}}" @endif>
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                   placeholder="Enter email" @if(isset($student)) value="{{$student->email_address}}" @endif>
        </div>
        <button type="submit" class="btn btn-primary">SAVE</button>
        <a href="{{route('students.index')}}">
            <button type="button" class="btn btn-secondary">{{__('Back')}}</button>
        </a>
    </form>

    @if(isset($student))
        <form method="POST" action="{{route('students.destroy',$student)}}">
            {{method_field('DELETE')}}
            @csrf
            <button type="submit" class="btn btn-danger">{{__('Delete')}}</button>
        </form>
    @endif

    @if($errors->any())
        <div class="notification is-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#datepicker").datepicker();
        });
    </script>
@endpush