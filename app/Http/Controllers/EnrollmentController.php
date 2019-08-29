<?php


namespace App\Http\Controllers;


use App\EnrolledStudent;
use App\Student;
use App\StudyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnrollmentController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $students = Student::get();
        $studyGroups = StudyGroup::get();

        return view('enrollment', compact('students', 'studyGroups'));
    }

    /**
     * Saving the user to study groups
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {

        if (EnrolledStudent::where('student_id', $request->student)->count() < 4) {

            $validatedData = $request->validate([
                'student' => 'required|integer|unique:enrolled_students,student_id,NULL,id,study_group_id,' . $request->study_group,
                'study_group' => 'required|integer|unique:enrolled_students,study_group_id,NULL,id,student_id,' . $request->student,
            ]);

            EnrolledStudent::create([
                'student_id' => $validatedData['student'],
                'study_group_id' => $validatedData['study_group']
            ]);

            return redirect('students');

        } else {
            
            return Redirect::back()->withErrors(['msg', 'The student reached the group limit!']);

        }
    }
}