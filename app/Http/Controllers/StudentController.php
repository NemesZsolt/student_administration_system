<?php

namespace App\Http\Controllers;

use App\EnrolledStudent;
use App\Student;
use App\StudyGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    /**
     * Fetching the requested data
     *
     * @param Request $request
     * @return Response
     * @throws \Throwable
     */
    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {

            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');

            $query = $request->get('query');

            $query = str_replace(" ", "%", $query);

            $students = Student::where('name', 'like', '%' . $query . '%')
                ->orWhereIn('id',explode(",", $query))
                ->orderBy($sort_by, $sort_type)
                ->paginate(10);

            return view('pagination_data', compact('students'))->render();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $students = Student::with(['gender', 'enrolled'])
            ->orderBy('id', 'asc')->paginate(10);

        $studyGroups = StudyGroup::orderBy('id', 'asc')->get();

        $enrolledStudentsNumber = EnrolledStudent::get()->groupBy('study_group_id')->count();

        return view('students', compact('students', 'studyGroups', 'enrolledStudentsNumber'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|integer',
            'address' => 'required|string|max:255',
            'date_time' => 'required|date|max:255',
            'email' => 'required|email|unique:students,email_address'

        ]);

        Student::create([
            'name' => $validatedData['name'],
            'gender_id' => $validatedData['gender'],
            'place_of_birth' => $validatedData['address'],
            'date_of_birth' => Carbon::make($validatedData['date_time'])->format('Y-m-d'),
            'email_address' => $validatedData['email']
        ]);

        return redirect('students');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Student $student
     * @return Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Student $student
     * @return Response
     */
    public function edit(Student $student)
    {
        return view('add', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Student $student
     * @return Response
     */
    public function update(Request $request, Student $student)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|integer',
            'address' => 'required|string|max:255',
            'date_time' => 'required|date|max:255',
            'email' => 'required|email|unique:students,email_address,' . $student->id
        ]);

        $student->update([
            'name' => $validatedData['name'],
            'gender_id' => $validatedData['gender'],
            'place_of_birth' => $validatedData['address'],
            'date_of_birth' => Carbon::make($validatedData['date_time'])->format('Y-m-d'),
            'email_address' => $validatedData['email'],
        ]);

        return redirect('students');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Student $student
     * @return Response
     * @throws \Exception
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect('students');
    }
}
