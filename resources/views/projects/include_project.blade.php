		<form action="{{ $action }}" target="_top" method="post">
        @csrf
   		   <table>
             <tr><td>Title:</td><td><input dusk="chef_input_banner_name" type="text" name="title" value="{{ $project->title }}"></td></tr>
             <tr><td>Sitemap:</td><td><input dusk="chef_input_banner_url" type="text" name="sitemap" value="{{ $project->sitemap }}"></td></tr>
             <tr><td>Max pages:</td><td><input dusk="chef_input_banner_name" type="number" step="1" name="max_pages" value="{{ $project->max_pages }}"></td></tr>
             <tr><td>Delay in ms:</td><td><input dusk="chef_input_banner_url" type="number" step="1" name="delay_ms" value="{{ $project->delay_ms }}"></td></tr>
             <tr><td>Language:</td><td><select dusk="chef_input_ingredient2group_unit_id" name="language_id">
            @foreach($languages as $language) 
              <option value="{{$language->id}}" @if ($language->id === $project->language_id) selected="true" @endif>{{ $language->long_name }}</option>
            @endforeach
              </select></td></tr>
             
             
             <tr><td><input class="" type="hidden" name="id" value="{{ $project->id }}"></td><td><button dusk="project_submit" type="submit">Save</button></td></tr>
   			</table>
		</form>
