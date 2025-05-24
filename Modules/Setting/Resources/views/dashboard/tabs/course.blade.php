
<div class="tab-pane fade" id="courses-settings">
  <div class="col-md-10">
    @inject('semesters', 'Modules\Semester\Entities\Semester')
  
    {!! field()->select('default_semester',__('Default semester') , $semesters->active()->pluck('title','id') ,
     setting('default_semester')) !!}
  
  </div>
</div>
