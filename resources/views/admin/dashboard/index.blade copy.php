@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')

<div class="admin">
    <div class="row g-4">

        <div class="col-lg-8">
            <div class="trk-card height-100">
                <div class="trk-card__header">
                    <div>
                        <h5>Traffic Analytics</h5>
                        <p >Tracking traffic analytics</p>
                    </div>
                </div>
                <div class="trk-card__body">
                    <div id="mixChart1">
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-4">
            <div class="trk-card height-100">
              <div class="trk-card__header d-flex align-items-center justify-content-between gap-2">
                <div>
                  <h5>Todo</h5>
                  <p>All todo activity</p>
                </div>
                <div>
                  <bnutton type="button" onclick="showCompleted()" id="completed_btn" class="btn btn-primary">View Completed</a>
                </div>
              </div>
              <div class="trk-card__body">

                <div class="input-group mb-4">
                  <input type="text" id="new_todo" class="form-control" placeholder="Add a new todo">
                  <button id="todo_button" class="btn btn-success">Create</button>
                </div>

                <div class="todo-box">
                    @foreach($data['todos'] as $todo)
                        <div id="todo-{{$todo->id}}" class="todo-item d-flex align-items-center justify-content-between  mb-4 @if($todo->is_complete==1) completed completed-todo @else incompleted-todo @endif">
                        <div class="d-flex align-items-center">
                            <span class="bullet h-35 bg-primary me-3"></span>
                            <input class="form-check-input me-3" type="checkbox" @if($todo->is_complete) checked @endif onclick="toggleTodo({{ $todo->id }});">
                            <div class="todo-item__content">
                            <div>
                                <a href="#" class="fw-semibold">{{$todo->task}}</a>
                                <span class="badge badge-primary ms-2">{{ $todo->is_complete? 'Complete':'Progress'}}</span>
                            </div>
                            {{-- <span class="todo-item__content-date">Due in 12 Days</span> --}}
                            </div>
                        </div>
                        <button class="btn btn-link p-0" onclick="deleteTodo({{$todo->id}});"><i class="lni lni-trash-can"></i></button>
                        </div>
                    @endforeach
                </div>


                <div id="todo_html" contents='<div id="todo-x" class="todo-item d-flex align-items-center justify-content-between  mb-4">
                    <div class="d-flex align-items-center">
                        <span class="bullet h-35 bg-primary me-3"></span>
                        <input class="form-check-input me-3" type="checkbox" onclick="toggleTodo(todo_id);">
                        <div class="todo-item__content">
                        <div>
                            <a href="#" class="fw-semibold">todo_task</a>
                            <span class="badge badge-primary ms-2">Progress</span>
                        </div>
                        {{-- <span class="todo-item__content-date">Due in 12 Days</span> --}}
                        </div>
                    </div>
                    <button class="btn btn-link p-0" onclick="deleteTodo(todo_id);"><i class="lni lni-trash-can"></i></button>
                    </div>'>
                </div>

              </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="trk-card height-100">
                <div class="trk-card__header d-flex align-items-center justify-content-between gap-2">
                    <div>
                        <h5>Top Performig pages</h5>
                        <p>Show pages performance</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary">PDF Report</a>
                    </div>
                </div>
                <div class="trk-card__body">
                    <div class="table-responsive">
                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fs-7 fw-semibold border-0 ">
                                    <th class="min-w-200px" colspan="2">LANDING PAGE</th>
                                    <th class="min-w-100px text-end pe-0" colspan="2">CLICKS</th>
                                    <th class="text-end min-w-100px" colspan="2">AVG. POSITION</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-success min-w-50px text-end fw-semibold fs-6">+935</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-1.35</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">job.cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-935</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-success min-w-50px text-end fw-semibold fs-6">+1.35</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">library.cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-success min-w-50px text-end fw-semibold fs-6">+565</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-1.35</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-935</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-success min-w-50px text-end fw-semibold fs-6">+1.35</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">job.cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-935</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-1.35</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">library.cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-success min-w-50px text-end fw-semibold fs-6">+375</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-success min-w-50px text-end fw-semibold fs-6">+1.35</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="" colspan="2">
                                        <a href="#" class=" fw-semibold  mb-1 fs-6">job.cuet.ac.bd</a>
                                    </td>

                                    <td class="pe-0" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class=" fw-semibold fs-6">1,256</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-935</span>
                                        </div>
                                    </td>

                                    <td class="" colspan="2">
                                        <div class="d-flex justify-content-end gap-3">
                                            <span class="text-gray-900 fw-semibold fs-6">2.63</span>
                                            <span class="text-danger min-w-50px text-end fw-semibold fs-6">-1.35</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-4">
            <div class="trk-card height-100">

                <div class="trk-card__header">
                    <div>
                        <h5>{{ __('default.recent_activities') }}</h5>
                        <p>{{ count($data['activities']) > 10 ? 10 : count($data['activities']) }}
                            activities out of
                            {{ Spatie\Activitylog\Models\Activity::where('causer_id', '!=', null)->count() }}
                        </p>
                    </div>
                </div>


                <div class="trk-card__body">
                    <ul class="list-group list-group-flush">
                    @foreach ($data['activities'] as $activity)
                        {{-- Label --}}
                            {{-- Badge --}}
                            <li class="list-group-item bg-transparent border-0 mb-2">
                                <span class="fw-semibold">
                                {{ $activity['updated_at'] }}
                                </span>
                                <i class="lni lni-opera {{ $activity['class'] }} icon-xxl"  aria-hidden="true"></i>
                                {!! $activity['details'] !!}
                                @if ($activity['link'])
                                    <a href="{{ $activity['link'] }}" 
                                        class="text-primary">{{ $activity['title'] }}</a>.
                                @endif
                            </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>




        <div class="col-lg-6">
            <div class="trk-card height-100">
                <div class="trk-card__header">
                    <div>
                        <h5>Visitors</h5>
                        <p>
                            All visitors tracking
                        </p>
                    </div>
                </div>
                <div class="trk-card__body">
                    <div id="areaChart2">
                    </div>
                </div>
            </div>
        </div>




        <div class="col-lg-6">
            <div class="trk-card height-100">
                <div class="trk-card__header">
                    <div>
                        <h5>Performance</h5>
                        <p> Show performance </p>
                    </div>
                </div>
                <div class="trk-card__body">
                    <div id="barChart1">
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection

@section('js')

<script>
        var completed_todo=$('.completed-todo');
        var incompleted_todo=$('.incompleted-todo');

        function showCompleted()
        {
                $('.todo-box').html('');
                $('.todo-box').html(completed_todo);

                $('#completed_btn').html('Hide Completed');
                $("#completed_btn").attr("onclick","showIncompleted()");
                $("#completed_btn").removeClass("btn-primary");
                $("#completed_btn").addClass("btn-danger");
                removeClass
        }
        function showIncompleted()
        {
                $('.todo-box').html('');
                $('.todo-box').html(incompleted_todo);

                $('#completed_btn').html('Show Completed');
                $("#completed_btn").attr("onclick","showCompleted()");
                $("#completed_btn").removeClass("btn-danger");
                $("#completed_btn").addClass("btn-primary");
        }


function toggleTodo(todo_id)
        {
            var form=new FormData();
                var _token=$("input[name=_token]").val();
                form.append('_token',_token);

                form.append('todo_id',todo_id);

                $.ajax({
                url:"{{route('admin.todos.complete')}}", 
                type:'POST',
                dataType:'script',
                data:form,
                contentType:false,
                processData:false,
                success:function(data,status)
                {            
                    data=JSON.parse(data); 
                    if(data['status']=='success')
                    {

                        if(data['is_complete']==0)
                        {
                            $('#bullet-'+todo_id).removeClass("bg-primary");
                            $('#bullet-'+todo_id).addClass("bg-danger");

                            $('#checkbox-'+todo_id).removeClass("checkbox-light-primary");
                            $('#checkbox-'+todo_id).addClass("checkbox-light-danger");
                        }
                        if(data['is_complete']==1)
                        {
                            
                            $('#bullet-'+todo_id).removeClass("bg-danger");
                            $('#bullet-'+todo_id).addClass("bg-primary");

                            $('#checkbox-'+todo_id).removeClass("checkbox-light-danger");
                            $('#checkbox-'+todo_id).addClass("checkbox-light-primary");

                        }

                        SwalFlash(true, 'Success', 'Todo Updated', icon = 'success')

                        
                    }
                }
                });
        }


        function deleteTodo(todo_id)
        {
            var form=new FormData();
                var _token=$("input[name=_token]").val();
                form.append('_token',_token);

                form.append('todo_id',todo_id);

                $.ajax({
                url:"{{route('admin.todos.delete')}}", 
                type:'POST',
                dataType:'script',
                data:form,
                contentType:false,
                processData:false,
                success:function(data,status)
                {             
                    $('#todo-'+todo_id).remove();
                    SwalFlash(true, 'Success', 'Todo Deleted', icon = 'success')
                }
                });
        }
$(document).ready(function(){

    $("#todo_button").click(function(){
              var new_todo=$('#new_todo').val();
  
              if(new_todo=='')
              {
                  alert('Cannot Submit Empty');
              } 
              else
              {
                  var form=new FormData();
                  var _token=$("input[name=_token]").val();
                  form.append('_token',_token);
  
                  form.append('new_todo',new_todo);
  
                  $.ajax({
                  url:"{{route('admin.todos.store')}}", 
                  type:'POST',
                  dataType:'script',
                  data:form,
                  contentType:false,
                  processData:false,
                  success:function(data,status)
                  {             
                      data=JSON.parse(data);
                        var todo_html = $('#todo_html').attr('contents');
                        todo_html = todo_html.replace("todo-x", "todo-"+data.todo.id);
                        todo_html = todo_html.replace("todo_id", data.todo.id);
                        todo_html = todo_html.replace("todo_id", data.todo.id);
                        todo_html = todo_html.replace("todo_task", data.todo.task);
                        $('.todo-box').prepend(todo_html);

                        SwalFlash(true, 'Success', 'Todo Added', icon = 'success')


                  }
                  });
              }
              
  
  
    });
  });

</script>

@endsection


