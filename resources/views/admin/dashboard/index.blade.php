@extends('admin.layouts.master')

@section('title')
    Admin Dashboard
@endsection

@section('container')

<div class="admin">
    <div class="row g-4">
      <div class="col-lg-8 col-xxxl-9">
        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="trk-card trk-card--sm">
              <div class="trk-card__body">
                <div class="d-flex flex-wrap align-items-center gap-3">
                  <div class="trk-card__icon">
                    <i class="lni lni-users p-10 bg-info rounded-3 text-white fs-3"></i>
                  </div>
                  <div class="trk-card__content">
                    <h5 class="mb-0">{{$data['top_analytics']['today_visitors']}}</h5>
                    <span class="text-secondary">Today’s Visitors</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="trk-card trk-card--sm">
              <div class="trk-card__body">
                <div class="d-flex flex-wrap align-items-center gap-3">
                  <div class="trk-card__icon">
                    <i class="lni lni-book p-10 bg-primary rounded-3 text-white fs-3"></i>
                  </div>
                  <div class="trk-card__content">
                    <h5 class="mb-0">{{$data['top_analytics']['totol_blogs']}}</h5>
                    <span class="text-secondary">Total Blogs</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="trk-card trk-card--sm">
              <div class="trk-card__body">
                <div class="d-flex flex-wrap align-items-center gap-3">
                  <div class="trk-card__icon">
                    <i class="lni lni-user p-10 bg-secondary rounded-3 text-white fs-3"></i>
                  </div>
                  <div class="trk-card__content">
                    <h5 class="mb-0">{{$data['top_analytics']['totol_users']}}</h5>
                    <span class="text-secondary">Total Users</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="trk-card trk-card--sm h-100">
              <div
                class="trk-card__header d-flex flex-wrap align-items-center justify-content-between gap-4 border-0">
                <h5 class="mb-0">Website Visitors</h5>
                <div class="trk-date">
                  <select class="form-select" id="rangeSelect" onchange="changeView(this.value)">
                    <option value="today">Today</option>
                    <option value="lastWeek">Last Week</option>
                    <option value="lastMonth">Last Month</option>
                    <option value="sixMonths">6 Months</option>
                    <option value="oneYear">1 Year</option>
                    <option value="custom">Custom Range</option>
                  </select>

                  <input class="form-control" type="text" id="dateRangePicker"
                    placeholder="Select Custom Date Range" style="display:none;">
                </div>
              </div>
              <div class="trk-card__body">
                <div id="visitorChart">
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-6">
            <div class="trk-card trk-card--sm h-100">
              <div
                class="trk-card__header d-flex flex-wrap align-items-center justify-content-between gap-4 border-0">
                <h5 class="mb-0">Top Devices</h5>
                <div class="trk-date">
                  <select class="form-select" onchange="fetchTopDevicesAnalytics(this)">
                    <option value="today">Today</option>
                    <option value="lastWeek">Last Week</option>
                    <option value="lastMonth">Last Month</option>
                    <option value="sixMonths">6 Months</option>
                    <option value="oneYear">1 Year</option>
                    {{-- <option value="custom">Custom Range</option> --}}
                  </select>

                  <input class="form-control" type="text" id="dateRangePicker"
                    placeholder="Select Custom Date Range" style="display:none;">
                </div>
              </div>

              <div class="trk-card__body">
                <div class="d-flex flex-wrap align-items-center gap-1">
                  <div id="userChart" class="user-chart"></div>

                  <ul class="device-list">

                  </ul>
                </div>
              </div>
            </div>


          </div>
          <div class="col-xxl-6">
            <div class="trk-card trk-card--sm h-100">
              <div
                class="trk-card__header d-flex flex-wrap align-items-center justify-content-between gap-4 border-0">
                <h5 class="mb-0">Visitor By Country</h5>
                <div class="trk-date">
                  <select class="form-select" onchange="fetchCountryAnalytics(this)">
                    <option value="today" selected>Today</option>
                    <option value="lastWeek">Last Week</option>
                    <option value="lastMonth">Last Month</option>
                    <option value="sixMonths">6 Months</option>
                    <option value="oneYear">1 Year</option>
                  </select>

                  <input class="form-control" type="text" id="dateRangePicker"
                    placeholder="Select Custom Date Range" style="display:none;">
                </div>
              </div>

              <div class="trk-card__body pt-0">
                <div id="visitorChart2"></div>
              </div>
            </div>


          </div>
          <div class="col-12">
            <div class="trk-card trk-card--sm">
              <div
                class="trk-card__header d-flex flex-wrap align-items-center justify-content-between gap-4 border-0">
                <h5 class="mb-0">Performance By Top Pages</h5>
                <div class="trk-date">
                  <select class="form-select" onchange="fetchTopPagesAnalytics(this)">
                    <option value="today">Today</option>
                    <option value="lastWeek">Last Week</option>
                    <option value="lastMonth">Last Month</option>
                    <option value="sixMonths">6 Months</option>
                    <option value="oneYear">1 Year</option>
                    {{-- <option value="custom">Custom Range</option> --}}
                  </select>

                  <input class="form-control" type="text" id="dateRangePicker"
                    placeholder="Select Custom Date Range" style="display:none;">
                </div>
              </div>

              <div class="trk-card__body">
                <div class="table-responsive">
                  <table class="table table-row-dashed align-middle gs-0 gy-4">
                    <thead>
                      <tr class="border-0 ">
                        <th class="min-w-200px fw-semibold text-color">Pages</th>
                        <th class="min-w-100px fw-semibold text-color text-center pe-0">Impressions</th>
                      </tr>
                    </thead>

                    <tbody id="topPagesTableBody">
                      {{-- <tr>
                        <td class="">
                          <a href="#" class="   mb-1 fs-6">/</a>
                        </td>

                        <td class="text-center">
                          <span class=" fs-6 text-mute">39,890</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="">
                          <a href="#" class="   mb-1 fs-6">/blog</a>
                        </td>

                        <td class="text-center">
                          <span class=" fs-6 text-mute">39,890</span>
                        </td>
                      </tr> --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-4 col-xxxl-3">
        <div class="row g-4">
          <div class="col-12">
            <div class="trk-card trk-card--sm">
              <div class="trk-card__body">
                <div class="custom-calendar">
                  <div id="inline-calendar"></div>
                </div>
              </div>
            </div>
          </div>

          
          <div class="col-12">
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


          <div class="col-12">
            <div class="trk-card trk-card--sm">
              <div class="trk-card__header border-0">
                <h5 class="mb-0">Activity Log</h5>
              </div>
              <div class="trk-card__body pt-0">
                <div class="timeline">
                    @php
                        foreach ($data['activities'] as $activity) {
                            echo "
                            <div class=\"timeline__item\">
                                <div class=\"timeline__icon {$activity['icon_class']}\"></div>
                                <div class=\"timeline__content\">
                                    <p class=\"timeline__time\">{$activity['updated_at']}</p>
                                    <p class=\"timeline__text\">{$activity['details']}</p>
                                </div>
                            </div>";
                        }

                    @endphp
                </div>
                <a href="{{route('admin.all-activities')}}" class="btn btn-light w-100 mt-4 ">View All <i
                    class="lni lni-chevron-right"></i></a>

              </div>
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


<script>
    /*=============Visitor chart start here ==============*/

    var countries_analytics=null;
    fetchCountryAnalytics();
    function fetchCountryAnalytics(element=null)
    {
      var params={};
      if(element?.value)
      {
        params={
          range_type:element.value
        };
      }
      else
      {
        params={
          range_type:'today'
        };
      }

      const queryString = new URLSearchParams(params).toString();

      fetch(`/admin/countries-analytics?${queryString}`) 
        .then(response => response.json())
        .then(data => {
          countries_analytics = data.data;  
            renderCountriesChart();
        });
    }


    fetchTopPagesAnalytics();
    function fetchTopPagesAnalytics(element=null)
    {
      var params={};
      if(element?.value)
      {
        params={
          range_type:element.value
        };
      }
      else
      {
        params={
          range_type:'today'
        };
      }

      const queryString = new URLSearchParams(params).toString();

      fetch(`/admin/top-pages-analytics?${queryString}`) 
        .then(response => response.json())
        .then(data => {
          populateTopPagesTable(data.data.top_pages);
        });
    }

    let totalScreenPageViews=0;
    fetchTopDevicesAnalytics();
    function fetchTopDevicesAnalytics(element=null)
    {
      var params={};
      if(element?.value)
      {
        params={
          range_type:element.value
        };
      }
      else
      {
        params={
          range_type:'today'
        };
      }

      const queryString = new URLSearchParams(params).toString();

      fetch(`/admin/top-devicec-analytics?${queryString}`) 
        .then(response => response.json())
        .then(data => {
          top_devices=data.data.top_devices;
          totalScreenPageViews = top_devices.reduce((sum, item) => sum + item.screenPageViews, 0);
          if(totalScreenPageViews>0)
          {
            renderDeviceList(top_devices);
            renderDeviceChart(top_devices);
          }
        });
    }


    let visitorData=[];
    fetch(`/admin/visitors-pages-analytics`) 
        .then(response => response.json())
        .then(data => {
          visitors=data.data.visitors_pages;
          if(visitors)
          {
                visitorData = visitors.map(item => {
                  return {
                    date: item.date.split('T')[0],  
                    value: item.screenPageViews  
                };

                // renderChart(visitorData,'dd MMM yyyy');
                // changeView('lastMonth');
            });
          }
          console.log('visitorData',visitorData);
    });


    function renderDeviceList(data) 
    {
      // Get the static <ul> element where we want to append <li> items
      const deviceListContainer = document.querySelector('.device-list');  // Ensure the class is correct

      // Clear existing list items if needed
      deviceListContainer.innerHTML = '';  // Clear the existing items in the list

      // Iterate over the data array to create each <li> item
      data.forEach(item => {
        // Create a new <li> for each item in the data
        const listItem = document.createElement('li');
        listItem.classList.add('device-list__item');  // Add the common class for list items

        // Set a class based on the operating system for specific styling (optional)
        listItem.classList.add(item.operatingSystem);
        // if (item.operatingSystem === 'Windows') {
        //   listItem.classList.add('desktop');
        // } else if (item.operatingSystem === 'Android' || item.operatingSystem === 'iOS') {
        //   listItem.classList.add('tablet');
        // } else {
        //   listItem.classList.add('other');
        // }

        // Create the first div with the device name and color
        const deviceNameDiv = document.createElement('div');
        const deviceColorSpan = document.createElement('span');
        deviceColorSpan.classList.add('device-list__item-color');  // Add the color span
        const deviceNameSpan = document.createElement('span');
        deviceNameSpan.classList.add('device-list__item-name');  // Add the name span
        deviceNameSpan.textContent = item.operatingSystem;

        // Append the color and name spans to the div
        deviceNameDiv.appendChild(deviceColorSpan);
        deviceNameDiv.appendChild(deviceNameSpan);

        // Create the second div with the value and percentage
        const deviceValueDiv = document.createElement('div');
        const deviceValueSpan = document.createElement('span');
        deviceValueSpan.classList.add('device-list__item-value');  // Add the value span
        deviceValueSpan.textContent = item.screenPageViews.toLocaleString();  // Format the value with commas

        // Calculate the percentage (for example, you can divide screenPageViews by a total value)
        const percentageSpan = document.createElement('span');
        percentageSpan.classList.add('device-list__item-percentage');
        const percentage = (item.screenPageViews / totalScreenPageViews) * 100;  // Example calculation, adjust as necessary
        percentageSpan.textContent = `(${percentage.toFixed(1)}%)`;

        // Append the value and percentage spans to the div
        deviceValueDiv.appendChild(deviceValueSpan);
        deviceValueDiv.appendChild(percentageSpan);

        // Append both divs to the <li>
        listItem.appendChild(deviceNameDiv);
        listItem.appendChild(deviceValueDiv);

        // Append the <li> to the existing <ul>
        deviceListContainer.appendChild(listItem);
      });
    }


    const visitorChart = document.querySelectorAll("#visitor-chart");

    if (visitorChart) {
      let chart;

      // Chart rendering function with dynamic x-axis formatting
      function renderChart(data, xaxisFormat) {
        const options = {
          chart: {
            type: 'area',
            height: 350,
            toolbar: {
              show: false,
            },
          },
          stroke: {
            curve: 'smooth',
            width: 2,
          },
          grid: {
            borderColor: '#f1f1f1',
          },
          fill: {
            type: 'gradient',
            gradient: {
              shadeIntensity: 1,
              gradientToColors: ['#6D71FA'], // Ending color of the gradient
              inverseColors: false,
              opacityFrom: 0.8,
              opacityTo: 0.2,
              stops: [0, 100]
            },
            colors: ['#6D71FA'], // Starting color of the gradient
          },
          series: [{
            name: 'Value',
            data: data.map(d => [new Date(d.date).getTime(), d.value])
          }],
          xaxis: {
            type: 'datetime',
            labels: {
              format: xaxisFormat
            }
          },
          // yaxis: { title: { text: 'Value' } },
          dataLabels: {
            enabled: false
          },
          axisTicks: {
            show: false
          },
          tooltip: {
            shared: true
          },
        };
        if (chart) {
          chart.updateOptions(options);
        } else {
          chart = new ApexCharts(document.querySelector("#visitorChart"), options);
          chart.render();
        }
      }


      function filterData(range) {
        const today = new Date();
        let filtered = [];
        let xaxisFormat = 'dd MMM'; // Default daily format

        if (range === 'today') {
          const todayStr = today.toISOString().split('T')[0];
          filtered = visitorData.filter(d => d.date.startsWith(todayStr));
          xaxisFormat = 'HH:mm'; // Hourly format for today
        } else if (range === 'lastWeek') {
          const lastWeek = new Date(today);
          lastWeek.setDate(today.getDate() - 7);
          filtered = visitorData.filter(d => new Date(d.date) >= lastWeek);
          xaxisFormat = 'dd MMM'; // Daily format for weekly
        } else if (range === 'lastMonth') {
          const lastMonth = new Date(today);
          lastMonth.setMonth(today.getMonth() - 1);
          filtered = visitorData.filter(d => new Date(d.date) >= lastMonth);
          xaxisFormat = 'dd MMM'; // Daily format for monthly
        } else if (range === 'sixMonths') {
          const sixMonthsAgo = new Date(today);
          sixMonthsAgo.setMonth(today.getMonth() - 6);
          filtered = visitorData.filter(d => new Date(d.date) >= sixMonthsAgo);
          xaxisFormat = 'MMM yyyy'; // Monthly format for six months
        } else if (range === 'oneYear') {
          const oneYearAgo = new Date(today);
          oneYearAgo.setFullYear(today.getFullYear() - 1);
          filtered = visitorData.filter(d => new Date(d.date) >= oneYearAgo);
          xaxisFormat = 'MMM yyyy'; // Monthly format for yearly
        } else if (range === 'custom') {
          const selectedDates = document.getElementById("dateRangePicker")._flatpickr.selectedDates;
          if (selectedDates.length === 2) {
            const [startDate, endDate] = selectedDates;
            filtered = visitorData.filter(d => new Date(d.date) >= startDate && new Date(d.date) <= endDate);
            xaxisFormat = 'dd MMM yyyy'; // Full date for custom range
          }
        }
        return {
          filtered,
          xaxisFormat
        };
      }

      // Update chart on range change or custom range selection
      function changeView(range) {
        if (range === 'custom') {
          document.getElementById("dateRangePicker").style.display = 'inline';
        } else {
          document.getElementById("dateRangePicker").style.display = 'none';
          const {
            filtered,
            xaxisFormat
          } = filterData(range);
          renderChart(filtered, xaxisFormat);
        }
      }

      // Initialize Flatpickr for custom range selection
      flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "Y-m-d",
        enableTime: true,
        onChange: function (selectedDates) {
          if (selectedDates.length === 2) { // Trigger update only when both dates are selected
            const {
              filtered,
              xaxisFormat
            } = filterData('custom');
            renderChart(filtered, xaxisFormat);
          }
        }
      });


      // Set a default view on load, e.g., Last Month
      document.addEventListener('DOMContentLoaded', () => changeView('lastMonth'));
    }


    /*=============Visitor chart end here ==============*/

    function extractArrayFromObjectArray(objectArray,index_name) 
    {
        return objectArray.map(item => item[index_name]);
    }


    let deviceChart=null;
    function renderDeviceChart(top_deices)
    {
      const userChartSelector = document.querySelector("#userChart");
  
      if (userChartSelector) {
        const userChartConfig = {
          series: extractArrayFromObjectArray(top_deices,'screenPageViews'),
          chart: {
            type: 'donut',
            height: 160,
          },
          labels: extractArrayFromObjectArray(top_deices,'operatingSystem'),
          // colors: ['#d500f9', '#00bcd4', '#1e1e2d', '#0a52be'],
          plotOptions: {
            pie: {
              donut: {
                size: '75%',
                labels: {
                  show: true,
                  name: {
                    show: false,
                  },
                  value: {
                    show: false,
                  },
                },
              },
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            show: true,
            width: 0,
          },
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
              legend: {
                position: 'bottom'
              }
            }
          }],
          legend: {
            show: false,
          },
        };

        if (deviceChart) 
        {
          deviceChart.updateOptions(userChartConfig);
        } else {
          deviceChart = new ApexCharts(userChartSelector, userChartConfig);
          deviceChart.render();
        }
      }

    }
    

    
    let countriesChart=null;
    function renderCountriesChart()
    {
        const visitorChart2Selector = document.querySelector("#visitorChart2");
    
        
        if (visitorChart2Selector) 
        {
          if (countriesChart!=null) {
              // Update data
              countriesChart.updateSeries([
                  {
                      data: extractArrayFromObjectArray(countries_analytics.top_countries,'screenPageViews')
                  }
              ]);

              // Update configuration
              countriesChart.updateOptions({
                  xaxis: {
                    categories: extractArrayFromObjectArray(countries_analytics.top_countries,'country'),
                  }
              });

              return;
          }

          const visitorChartConfig = {
            series: [{
              data: extractArrayFromObjectArray(countries_analytics.top_countries,'screenPageViews')
            }],
            chart: {
              type: 'bar',
              height: 250,
              toolbar: {
                show: false,
                tools: {
                  download: false
                }
              }
            },
            plotOptions: {
              bar: {
                horizontal: true,
                borderRadius: 3,
                barHeight: '20px',
                distributed: false,
              }
            },
            dataLabels: {
              enabled: false
            },
            colors: ['#6D71FA'],
            grid: {
              show: true,
              borderColor: '#fff',
            },
            xaxis: {
              categories: extractArrayFromObjectArray(countries_analytics.top_countries,'country'),
              labels: {
                style: {
                  colors: '#8a8a8a'
                }
              }
            },
            yaxis: {
              labels: {
                style: {
                  colors: '#8a8a8a'
                }
              }
            }
          };
    
    
          
    
          countriesChart = new ApexCharts(visitorChart2Selector, visitorChartConfig);
          countriesChart.render();
        }

    }

    const inlineCalendar = document.querySelector("#inline-calendar");
    if (inlineCalendar) {
      flatpickr("#inline-calendar", {
        inline: true,
        dateFormat: "Y-m-d",
        defaultDate: new Date()
      });
    }


    function populateTopPagesTable(data) 
    {
      const tableBody = document.getElementById("topPagesTableBody");
      tableBody.innerHTML = '';  

      data.forEach(item => {
        const row = document.createElement("tr");  

        // Create and append the Page column
        const pageCell = document.createElement("td");
        const pageLink = document.createElement("a");

        let fullPageUrl = item.fullPageUrl;
        if (!/^https?:\/\//.test(fullPageUrl)) {
            fullPageUrl = `https://${fullPageUrl}`;
        }
        pageLink.href = fullPageUrl;


        pageLink.target = '_blank';
        pageLink.classList.add('mb-1', 'fs-6');
        pageLink.textContent = item.pageTitle;
        pageCell.appendChild(pageLink);

        // Create and append the Impressions column
        const impressionsCell = document.createElement("td");
        impressionsCell.classList.add('text-center');
        const impressionsSpan = document.createElement("span");
        impressionsSpan.classList.add('fs-6', 'text-mute');
        impressionsSpan.textContent = item.screenPageViews;
        impressionsCell.appendChild(impressionsSpan);

        // Append cells to the row
        row.appendChild(pageCell);
        row.appendChild(impressionsCell);

        // Append the row to the table body
        tableBody.appendChild(row);
      });
    }
</script>
@endsection


