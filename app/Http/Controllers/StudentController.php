<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students_list = DB::table('students')
        ->select('students.*')
        ->get();

        $courses = DB::table('course')
        ->select('course.*')
        ->get();

        // $courses_by_student = DB::table('student_has_course')
        // ->select('student_has_course.*')
        // ->get();

        $students = collect();
        foreach($students_list as $student){
            $courses_by_student = array();
            $courses_by_student_id = array();
            foreach($courses as $course){
                $query = DB::table('student_has_course')
                ->select('student_has_course.student_id','student_has_course.course_id')
                ->where('student_has_course.student_id',$student->id)
                ->where('student_has_course.course_id',$course->id)
                ->first();
                if($query){
                    // dd($course->nombre);
                    array_push($courses_by_student, $course->nombre);
                    array_push($courses_by_student_id, $course->id);
                }
            }
            $students->push((object)[
                'id' => $student->id,
                'nombre' => $student->nombre,
                'apellidos' => $student->apellidos,
                'email' => $student->email,
                'materias' => $courses_by_student,
                'materias_id' => $courses_by_student_id,
            ]);
        }
        // dd($students);
        return view('home',compact('students','courses'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = DB::table('students')->insertGetId([
            'nombre' => $request->name,
            'apellidos' => $request->lastname,
            'email' => $request->email
        ]);
        foreach($request->course as $course){
            DB::insert('insert into student_has_course (course_id,student_id) values ('.$course.', '.$id.');');
        }

        $courses = DB::table('course')
        ->select('course.*')
        ->get();

        $student = DB::table('students')
        ->where('id', '=', $id )
        ->select('students.*')
        ->first();

        $students = collect();
        $courses_by_student = array();
        $courses_by_student_id = array();
        foreach($courses as $course){
            $query = DB::table('student_has_course')
            ->select('student_has_course.student_id','student_has_course.course_id')
            ->where('student_has_course.student_id',$student->id)
            ->where('student_has_course.course_id',$course->id)
            ->first();
            if($query){
                array_push($courses_by_student, $course->nombre);
                array_push($courses_by_student_id, $course->id);
            }
        }
        $students->push((object)[
            'id' => $student->id,
            'nombre' => $student->nombre,
            'apellidos' => $student->apellidos,
            'email' => $student->email,
            'materias' => $courses_by_student,
            'materias_id' => $courses_by_student_id,
        ]);
        return $students;
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::update('update students set nombre = "'.$request->name.'" ,apellidos = "'.$request->lastname.'" ,email = "'.$request->email.'" where id = '.$request->id.';');

        $student_has_course = DB::table('student_has_course')
        ->select('student_has_course.student_id','student_has_course.course_id')
        ->where('student_has_course.student_id',$request->id)
        ->get();
        
        
        $flag_delete=0;
        $flag_add=0;
        foreach($student_has_course as $student_course){
            $flag_delete=0;
            foreach($request->course as $sel_course){
                if($student_course->course_id==$sel_course){
                    $flag_delete=0;
                    break;
                }
                else{
                    $flag_delete=1;
                }
            }
            if($flag_delete==1){
                $deleted_studen_courses = DB::table('student_has_course')->where('student_id', $request->id)->where('course_id', $student_course->course_id)->delete();
            }
        }
        foreach($request->course as $sel_course){
            foreach($student_has_course as $student_course){
                if($student_course->course_id!=$sel_course){
                    $flag_add=0;
                }
                else{
                    $flag_add=1;
                    break;
                }
            }
            if($flag_delete==0){
                DB::insert('insert into student_has_course (course_id,student_id) values ('.$sel_course.', '.$request->id.');');
            }
        }

        $courses = DB::table('course')
        ->select('course.*')
        ->get();

        $student = DB::table('students')
        ->where('id', '=', $request->id)
        ->select('students.*')
        ->first();

        $students = collect();
        $courses_by_student = array();
        $courses_by_student_id = array();
        foreach($courses as $course){
            $query = DB::table('student_has_course')
            ->select('student_has_course.student_id','student_has_course.course_id')
            ->where('student_has_course.student_id',$student->id)
            ->where('student_has_course.course_id',$course->id)
            ->first();
            if($query){
                    // dd($course->nombre);
                array_push($courses_by_student, $course->nombre);
                array_push($courses_by_student_id, $course->id);
            }
        }
        $students->push((object)[
            'id' => $student->id,
            'nombre' => $student->nombre,
            'apellidos' => $student->apellidos,
            'email' => $student->email,
            'materias' => $courses_by_student,
            'materias_id' => $courses_by_student_id,
        ]);
        return $students;
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $deleted_studen_courses = DB::table('student_has_course')->where('student_id', $request->id)->delete();
        $deleted_studen = DB::table('students')->where('id', $request->id)->delete();

        $students_list = DB::table('students')
        ->select('students.*')
        ->get();

        return count($students_list);
        //
    }
}
