@extends('phpspellchecker')
@section('submenu')
@include ('include_dummy_menu')     
@endsection
@section('title','Jobs')
@section('url', env('APP_URL').'/jobs')


@section('content')
<script type="text/javascript">
    function handleUpdate() 
    {
    	setInterval(getData, 1000);
//    	getData();
    }
    
    async function getData() 
    {
      var status = null;
      
      const url = "{{env('APP_URL')}}/api/get_job_status";
      fetch(url)
            .then((response) => {
              return response.json();
            })
            .then((data) => {
              let status = data;
			   displayStatus(status);			
            })
    }
    

	function displayStatus(statuses)
	{
//	  	alert("hello" + status[1].duration);

        for (const status of statuses)
        {
        	var jobId = status.job_id;

	  	    document.getElementById("status_" + jobId).innerHTML = status.status;
	  	    document.getElementById("pages_" + jobId).innerHTML = status.pages;
	  	    document.getElementById("faulty_pages_" + jobId).innerHTML = status.faulty_pages;
	  	    document.getElementById("misspellings_" + jobId).innerHTML = status.misspellings;
	  	    document.getElementById("duration_" + jobId).innerHTML = status.duration;
	  	    document.getElementById("completion_" + jobId).innerHTML = status.completion + " %";
        }
	}    
	
	window.onload = handleUpdate;
    
</script>
        <h1>Spellcheck Jobs</h1>

		<form action="/trigger_job" target="_top" method="post">
        @csrf
   		   <table>
			 <tr><td>Project:</td><td>
				<select name="project_id" id="project_id">
            	@foreach($projects as $project) 
  					<option value="{{$project->id}}">{{$project->title}}</option>
            	@endforeach
            </select></td><td>Adhoc:<input type="checkbox" id="adhoc" name="adhoc" value="true"></td><td><button dusk="spellcheck_job_submit" type="submit">Start</button></tr>
            </table>
		</form>

        <br>
        <br>
        <table>
           <tr><td>Job ID</td><td>Sitemap</td><td>Status</td><td>Pages</td><td>Faulty Pages</td><td>Misspellings</td><td>Started</td><td>Duration</td><td>Completion</td></tr>
            @foreach($jobs as $job) 
              <tr><td><a href="/show_job_detail/{{$job->job_id}}">{{ $job->job_id }}</a></td><td><a href="/show_job_detail/{{$job->job_id}}">{{ $job->title }}</a></td><td><a id="status_{{$job->job_id}}" href="/show_job_detail/{{$job->job_id}}">{{ $job->status }}</a></td><td><a id="pages_{{$job->job_id}}" href="/show_job_detail/{{$job->job_id}}">{{ $job->pages }}</a></td><td><a  id="faulty_pages_{{$job->job_id}}" href="/show_job_detail/{{$job->job_id}}">{{ $job->faulty_pages }}</a></td><td><a id="misspellings_{{$job->job_id}}"  href="/show_job_detail/{{$job->job_id}}">{{ $job->misspellings }}</a></td><td>{{ $job->created_at }}</td><td id="duration_{{$job->job_id}}" >{{ $job->duration }}</td><td id="completion_{{$job->job_id}}" >{{ $job->completion }}%</td><td><a href="/delete_job/{{$job->job_id}}">delete</a></td></tr>
            @endforeach
        </table>
        
        
@endsection