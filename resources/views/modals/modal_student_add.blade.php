<div class="modal fade" id="modalStudent" tabindex="-1" role="dialog" aria-labelledby="modalStudentTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form-new-student">
      <div class="modal-header">
        <h5 class="modal-title" id="modalStudentTitle">Registrar Estudiante Nuevo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="studentName">Nombre del Estudiante</label>
            <input type="text" class="form-control" id="studentName" placeholder="Nombre">
            <div class="alert alert-danger" role="alert" id="validation_name" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
          <div class="form-group mt-4">
            <label for="studentLastName">Apellidos del estudiante</label>
            <input type="text" class="form-control" id="studentLastName" placeholder="Apellidos">
            <div class="alert alert-danger" role="alert" id="valdiationLastName" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
          <div class="form-group mt-4">
            <label for="studentMail">Email del estudiante</label>
            <input type="email" class="form-control" id="studentMail" placeholder="example@example.com">
            <div class="alert alert-danger" role="alert" id="valdiationMail" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
          </div>
          <div class="form-group mt-4">
            <label class="form-check-label" for="materia">¿Materias a cursar?</label>
            <select class="materia-multi-select form-control" name="materia[]" multiple="multiple" id="materia" style="width: 100%;" placeholder="materias">
              @foreach($courses as $course)
                <option value="{!! $course->id !!}">{!! $course->nombre !!}</option>
              @endforeach
              
            </select>
            <div class="alert alert-danger" role="alert" id="valdiationCourse" style="padding: 5px 10px;margin-top: 10px;display: none;"></div>
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