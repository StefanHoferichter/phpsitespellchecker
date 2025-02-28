		<form action="{{ $action }}" target="_top" method="post">
        @csrf
   		   <table>
             <tr><td>Name:</td><td><input dusk="chef_input_banner_name" type="text" name="name" value="{{ $word->name }}"></td></tr>
             <tr><td>Language:</td><td><select dusk="chef_input_ingredient2group_unit_id" name="language_id">
            @foreach($languages as $language) 
              <option value="{{$language->id}}" @if ($language->id === $word->language_id) selected="true" @endif>{{ $language->long_name }}</option>
            @endforeach
              </select></td></tr>
             
             
             <tr><td><input class="" type="hidden" name="id" value="{{ $word->id }}"></td><td><button dusk="project_submit" type="submit">Save</button></td></tr>
   			</table>
		</form>
