@extends('layouts.app')

@section('content')
    <form method="POST" action="{{route('enrollment.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="students">Students</label>
                <select id="students" name="student" class="form-control">
                    <option selected disabled>Choose...</option>
                    @foreach($students as $student)
                        <option value="{{$student->id}}">{{$student->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="study_groups">Study groups</label>
                <select id="study_groups" name="study_group" class="form-control">
                    <option selected disabled>Choose...</option>
                    @foreach($studyGroups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">ADD</button>
        <a href="{{route('students.index')}}">
            <button type="button" class="btn btn-secondary">{{__('BACK')}}</button>
        </a>
    </form>

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