<div class="modal fade" id="modalStudentEdit" tabindex="-1" role="dialog" aria-labelledby="modalStudentTitleEdit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form-new-student-edit">
        <input type="hidden" name="id_student"  id="edit_id_student">
      <div class="modal-header">
        <h5 class="modal-title" id="modalStudentTitleEdit">Registrar Estudiante Nuevo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="studentName">Nombre del Estudiante</label>
            <input type="text" class="form-control" id="studentNameEdit" placeholder="Nombre">
            <div class="alert alert-danger" role="alert" id="validation_name_edit" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
          <div class="form-group mt-4">
            <label for="studentLastName">Apellidos del estudiante</label>
            <input type="text" class="form-control" id="studentLastNameEdit" placeholder="Apellidos">
            <div class="alert alert-danger" role="alert" id="valdiationLastName_edit" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
          <div class="form-group mt-4">
            <label for="studentMail">Email del estudiante</label>
            <input type="email" class="form-control" id="studentMailEdit" placeholder="example@example.com">
            <div class="alert alert-danger" role="alert" id="valdiationMail_edit" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
          <div class="form-group mt-4">
            <label class="form-check-label" for="materiaEdit">¿Materias a cursar?</label>
            <select class="materia-multi-select-edit form-control" name="materiaEdit[]" multiple="multiple" id="materiaEdit" style="width: 100%;">
              @foreach($courses as $course)
                <option value="{!! $course->id !!}">{!! $course->nombre !!}</option>
              @endforeach
            </select>
            <div class="alert alert-danger" role="alert" id="valdiationCourse_edit" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-save-student">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>