<html>
        <head>
               <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
               <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        </head>
</html>

<table class="table align-middle table-row-dashed fs-6 gy-5">

    <tr>
        <th>ID(Ticket)</th>
        <th>Emp</th>
        <th>Manager</th>
        <th>Company Name</th>
        <th>Date</th>
        <th>Picture</th>
        <th>Phone</th>
        <th>Service Request</th>
        <th>Discription</th>
        <th>ACTION</th>
      </tr>
  @foreach($servicerequest as $user)
  <tr>
    <td>{{$user->id }}</td>
     

    <td>
        {{-- @if(!empty($user->emp_id))
        {{getNameById($user->emp_id)}}
        @endif --}}
    </td>

    {{-- <td>{{$user->managername}}</td> --}}
    {{-- <td>{{$user->Service_request}}</td> --}}
      <td>
        {{-- @if(!empty($user->user_id))
        {{getNameById($user->user_id)}}
        @endif --}}
    </td>
    <td>{{$user->Service_request}}</td>
    <td>{{$user->date}}</td>
    <td>
        @if(!is_null($user->pictures))
    @foreach(json_decode($user->pictures,true) as $users)                        
        
        {{-- <img src="{{ url('/') }}/uploads/{{$users}}" style="width:5rem; height:50px;border-radius: 2px;"> --}}
        <a href="{{ url('/') }}/uploads/{{$users}}" target="_blank"><img src="{{ url('/') }}/uploads/{{$users}}" style="width:10rem; height:5rem;border-radius: 10px;"></a>

        @endforeach
        
        @else
        {{-- <img src="{{ asset('blank_user.PNG') }}" style="width:50px; height:50px;border-radius: 25px;" /> --}}
          <i class="fa fa-image" style="width:5rem; height:50px;border-radius: 25px; font-size:2rem;"></i>
        @endif
    </td>
    <td>{{$user->phone}}</td>
    <td>{{$user->discription}}</td>




    <td>
        <a href="{{ url('/') }}/admin/servicerequests/{{$user->id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-pen"></i>
                    </span>
        </a>
        <a onclick="return confirm('Are you sure you want to delete ?')"  href="{{ url('/') }}/admin/servicerequests/destroy/{{$user->id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                    <span class="svg-icon svg-icon-3">
                        <i class="fa fa-trash"></i>
                    </span>
        </a>
    </td>
  </tr>
  @endforeach
</table>
