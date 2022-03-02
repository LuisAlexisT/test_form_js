@extends('layouts.app')
@section('css')
<style type="text/css">
    .btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
}

.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}
.select2{
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    font-weight: 400;
    line-height: 1.6;
    color: #212529;
    background-color: #f8fafc;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: none;
}
.select2-container--default .select2-selection--multiple {
    background-color: #f8fafc;
    border: none;
}
.text-hidden-content{
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.card-p1{
    padding: 10px 20px;
}
.close{
    background-color: transparent;
    border: 0;
    -webkit-appearance: none;
    position: absolute;
    top: 0;
    right: 0;
    padding: 0.75rem 1.25rem;
    color: inherit;
    font-size: 20px;
}
.alert-toggle-js{
    float: right;
    position: absolute;
    display: flex;
    z-index: 9999999;
    margin-left: 40px;
}
.courses-list{
    display: ;
    position: absolute;
    z-index: 9999;
    background: transparent;
    width: 400px;
    height: auto;
}
.course-item{
    background-color: #cfe2ff;
    padding: 1px 5px;
    border-radius: 15px;
    box-shadow: 4px 4px 6px 0px rgb(0 0 0 / 13%);
    margin-right: 3px;
    display: none;
}

.info-courses:hover .course-item {
    display: flex;
}
.cursor-pointer{
    cursor: pointer;
}
</style>

@endsection
@section('content')
<div class="col-5 alert-toggle-js" id="alert-toggle-js">
    
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Lista de estudiantes') }}
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalStudent" style="float: right; height: 30px; font-size:11px;">
                        <i class="fa fa-plus"></i> 
                    </button>
                </div>

                <div class="card-body">
                    <div id="student_list">
                        @if(count($students)<=0)
                            <p>Sin datos de estudiantes</p>
                            <small>Da click en el botón con el símbolo de más, para añadir un nuevo estudiante.</small>
                        @else
                        @foreach($students as $student)
                        <div class="card card-p1 mt-2"  id="student-item-{{$student->id}}">
                            <div class="row">
                                <div class="col-3 text-hidden-content" id="name-list-studen-{{$student->id}}">{!! $student->nombre !!} {!! $student->apellidos !!}</div>
                                <div class="col-3 text-hidden-content" id="mail-list-studen-{{$student->id}}"><a href="#">{!! $student->email !!}</a></div>
                                <div class="col-4 text-hidden-content info-courses cursor-pointer" id="courses-list-studen-{{$student->id}}">
                                    @foreach($student->materias as $index => $materias)
                                        {!! $materias !!}
                                    @endforeach
                                    <div class="courses-list row" id="courses-list-hidden-{{$student->id}}">
                                        @foreach($student->materias as $index => $course)
                                            <span class="course-item col mt-2">{!! $course !!}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-2 text-hidden-content" id="button-studen-{{$student->id}}">
                                    <button type="button" class="btn btn-success btn-circle btn-edit-modal" data-toggle="modal" data-target="#modalStudentEdit" data-id="{{$student->id}}" data-nombre="{!! $student->nombre !!}" data-apellidos="{!! $student->apellidos !!}" data-email="{!! $student->email !!}" data-materias="<?php
                                        foreach($student->materias_id as $index => $course){
                                            echo($course.'/');
                                        }
                                    ?>"><i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-circle btn-remove-student" data-id="{{$student->id}}" data-name="{!! $student->nombre !!} {!! $student->apellidos !!}"><i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@include('modals.modal_student_add')
@include('modals.modal_student_edit')
@endsection
@section('scripts')
<script type="text/javascript">
    $('.materia-multi-select').select2({
        dropdownParent: $('#modalStudent'),
        placeholder: "Selecciona una materia",
    });
    $('.materia-multi-select-edit').select2({
        dropdownParent: $('#modalStudentEdit'),
        placeholder: "Selecciona una materia",
    });

    $( "#form-new-student").on( "submit", function(e) {
        var validate_flag=0;
        if($("#studentName").val()==""){
            $("#validation_name").text('El campo nombre no debe estar vació.');
            $("#validation_name").css("display", "block");
            validate_flag++;
        }
        if($("#studentLastName").val()==""){
            $("#valdiationLastName").text('El campo apellidos no debe estar vació.');
            $("#valdiationLastName").css("display", "block");
            validate_flag++;
        }
        if($("#materia").val()==""){
            $("#valdiationCourse").text('El campo materia no debe estar vació.');
            $("#valdiationCourse").css("display", "block");
            validate_flag++;
        }

        if($("#studentMail").val()==""){
            $("#valdiationMail").text('El campo email no debe estar vació.');
            $("#valdiationMail").css("display", "block");
            validate_flag++;
        }

        if(validate_flag>0){
            $('.alert-danger').delay(2000).fadeOut();
            e.preventDefault();
            return false;
        }
        else{
            e.preventDefault();
            var name = $("#studentName").val();
            var lastname = $("#studentLastName").val();
            var course = $("#materia").val();
            var email = $("#studentMail").val();
            $.ajax({
                url: `{{route('student.register')}}`,
                type: 'POST',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    lastname: lastname,
                    email: email,
                    course: course,
                },
                success: function(result) {
                    if (result) {
                        console.log(result);
                        var lenght_students = <?php echo(count($students)) ?>;
                        if(lenght_students<=0){
                            document.getElementById('student_list').innerHTML="";
                        }
                        let arr = Array.from(result[0].materias);
                        let arr1 = Array.from(result[0].materias_id);
                        var materias = "";
                        var materias_id = "";
                        arr.forEach(element=>{
                            materias += element+',';
                        });
                        arr1.forEach(element=>{
                            materias_id += element+'/';
                        });
                        $('#student_list').append(`
                            <div class="card card-p1 mt-2"  id="student-item-${result[0].id}">
                                <div class="row">
                                    <div class="col-3 text-hidden-content">${result[0].nombre} ${result[0].apellidos}</div>
                                    <div class="col-3 text-hidden-content"><a href="#">${result[0].email}</a></div>
                                    <div class="col-4 text-hidden-content">
                                        ${materias}
                                    </div>
                                    <div class="col-2 text-hidden-content">
                                        <button type="button" class="btn btn-success btn-circle btn-edit-modal" data-toggle="modal" data-target="#modalStudentEdit" data-id="-${result[0].id}" data-nombre="${result[0].nombre}" data-apellidos="${result[0].apellidos}" data-email="${result[0].email}" data-materias="${materias_id}"><i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-circle btn-remove-student" data-id="${result[0].id}" data-name="${result[0].nombre} ${result[0].apellidos}"><i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `);
                        $("#studentName").val('');
                        $("#studentLastName").val('');
                        // $("#materia").val('');
                        $('#materia').val(null).trigger('change');
                        $("#studentMail").val('');
                        $('#modalStudent .close-modal').click();
                        document.getElementById('alert-toggle-js').innerHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <strong>Guardado!</strong> 
                              Has guardado a <strong>${result[0].nombre} ${result[0].apellidos}</strong> con exito.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        `;
                        $(".alert-toggle-js").css("display", "flex");
                        $('.alert-toggle-js').delay(2000).fadeOut();
                    }

                },
                error: function() {
                    console.log('error');
                }
            });
        }
    });

    $(document).on("click", '.btn-remove-student', function(e) {
        console.log('LLega?')
        var id = $(this).attr('data-id');
        var fullName = $(this).attr('data-name');
        $.ajax({
                url: `{{route('student.delete')}}`,
                type: 'POST',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(result) {
                    if (result) {
                        $("#student-item-"+id).remove();
                        document.getElementById('alert-toggle-js').innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Borrado!</strong> 
                              Has borrado a <strong>${fullName}</strong>.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        `;
                        $(".alert-toggle-js").css("display", "flex");
                        $('.alert-toggle-js').delay(2000).fadeOut();
                        if(result<=0){
                            document.getElementById('student_list').innerHTML=`<p>Sin datos de estudiantes</p>
                            <small>Da click en el botón con el símbolo de más, para añadir un nuevo estudiante.</small>`;
                        }
                    }

                },
                error: function() {
                    alert("No");
                }
            });
    });

    $(document).on("click", '.btn-edit-modal', function(e) {
        var id = $(this).attr('data-id');
        var nombre = $(this).attr('data-nombre');
        var apellidos = $(this).attr('data-apellidos');
        var email = $(this).attr('data-email');
        var materias = $(this).attr('data-materias');

        var arrayDeCadenas = materias.split('/');
        console.log(arrayDeCadenas)
        
        $('#edit_id_student').val(id);
        $('#studentNameEdit').val(nombre);
        $('#studentLastNameEdit').val(apellidos);
        $('#studentMailEdit').val(email);
        $('#materiaEdit').val(arrayDeCadenas);
        $('#materiaEdit').trigger('change');
        // $('#materia').val(materias);
        // $('#materia').val(materias);
    });

    $( "#form-new-student-edit").on( "submit", function(e) {
        var validate_flag=0;
        if($("#studentNameEdit").val()==""){
            $("#validation_name_edit").text('El campo nombre no debe estar vació.');
            $("#validation_name_edit").css("display", "block");
            validate_flag++;
        }
        if($("#studentLastNameEdit").val()==""){
            $("#valdiationLastName_edit").text('El campo apellidos no debe estar vació.');
            $("#valdiationLastName_edit").css("display", "block");
            validate_flag++;
        }
        if($("#materiaEdit").val()==""){
            $("#valdiationCourse_edit").text('El campo materia no debe estar vació.');
            $("#valdiationCourse_edit").css("display", "block");
            validate_flag++;
        }

        if($("#studentMailEdit").val()==""){
            $("#valdiationMail_edit").text('El campo email no debe estar vació.');
            $("#valdiationMail_edit").css("display", "block");
            validate_flag++;
        }

        if(validate_flag>0){
            $('.alert-danger').delay(2000).fadeOut();
            e.preventDefault();
            return false;
        }
        else{
            e.preventDefault();
            var id = $("#edit_id_student").val();
            var name = $("#studentNameEdit").val();
            var lastname = $("#studentLastNameEdit").val();
            var course = $("#materiaEdit").val();
            var email = $("#studentMailEdit").val();
            $.ajax({
                url: `{{route('student.update')}}`,
                type: 'POST',
                cache: false,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    name: name,
                    lastname: lastname,
                    email: email,
                    course: course,
                },
                success: function(result) {
                    if (result) {
                        let arr = Array.from(result[0].materias);
                        let arr1 = Array.from(result[0].materias_id);
                        var materias = "";
                        var materias_id = "";
                        var materias_span = "";
                        arr.forEach(element=>{
                            materias += element+',';
                        });
                        arr.forEach(element=>{
                            materias_span += '<span class="course-item col mt-2">'+element+'</span>';
                        });
                        arr1.forEach(element=>{
                            materias_id += element+'/';
                        });
                        document.getElementById('name-list-studen-'+id).innerHTML = `${result[0].nombre} ${result[0].apellidos}`;
                        document.getElementById('mail-list-studen-'+id).innerHTML = `<a href="#">${result[0].email}</a>`;
                        document.getElementById('courses-list-studen-'+id).innerHTML = materias;
                        $('#courses-list-studen-'+id).append(`
                            <div class="courses-list row" id="courses-list-hidden-${result[0].id}">
                            ${materias_span}
                        </div>`);
                        document.getElementById('button-studen-'+id).innerHTML = `
                            <button type="button" class="btn btn-success btn-circle btn-edit-modal" data-toggle="modal" data-target="#modalStudentEdit" data-id="${result[0].id}" data-nombre="${result[0].nombre}" data-apellidos="${result[0].apellidos}" data-email="${result[0].email}" data-materias="${materias_id}"><i class="fa fa-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-circle btn-remove-student" data-id="${result[0].id}" data-name="${result[0].nombre} ${result[0].apellidos}"><i class="fa fa-trash"></i>
                            </button>
                        `;

                        document.getElementById('alert-toggle-js').innerHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <strong>Guardado!</strong> 
                              Información de <strong>${result[0].nombre} ${result[0].apellidos}</strong> actualizado con exito.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        `;
                        $(".alert-toggle-js").css("display", "flex");
                        $('.alert-toggle-js').delay(2000).fadeOut();
                        $('#modalStudentEdit .close-modal').click();
                    }
                },
                error: function() {
                    console.log('error');
                }
            });
        }
    });
</script>
@endsection