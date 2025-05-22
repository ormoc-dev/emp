@extends('profile.profile-layout')
@section('profile')
 <div class="card">
  <div class="card-header">
    Change Password
  </div>
  <div class="card-body">
	 
	 <form action="{{route('update_password')}}" id="change_password_form" method="post">
		@csrf
	   <div class="form-group">
		<label for="old_password">Old Password</label>
		<input type="password" name="old_password" class="form-control" id="old_password" >
	
		@if($errors->any('old_password'))
		  <span class="text-danger">{{$errors->first('old_password')}}</span>
		@endif
	  </div>
	  <div class="form-group">
		<label for="password">New Password</label>
		<input type="password" name="new_password" class="form-control" id="new_password" >
		@if($errors->any('new_password'))
		  <span class="text-danger">{{$errors->first('new_password')}}</span>
		@endif
	  </div>
	  <div class="form-group">
		<label for="confirm_password">Confirm Password</label>
		<input type="password" name="confirm_password" class="form-control" id="confirm_password" >
		@if($errors->any('confirm_password'))
		  <span class="text-danger">{{$errors->first('confirm_password')}}</span>
		@endif
	  </div>

	  <button type="submit" class="btn btn-primary">Update Password</button>
	</form>
  </div>
</div>

@endsection


public function change_password(){ 
        return view('profile.change_password');
    }


    public function update_password(Request $request){
        $request->validate([
        'old_password'=>'required|min:6|max:100',
        'new_password'=>'required|min:6|max:100',
        'confirm_password'=>'required|same:new_password'
        ]);

        $current_user=auth()->user();

        if(Hash::check($request->old_password,$current_user->password)){

            $current_user->update([
                'password'=>bcrypt($request->new_password)
            ]);

            return redirect()->back()->with('success','Password successfully updated.');

        }else{
            return redirect()->back()->with('error','Old password does not matched.');
        }



    }


    Route::get('/change-password','ProfileController@change_password')->name('change_password');
		Route::post('/update-password','ProfileController@update_password')->name('update_password');	