<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Models\Image;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // [
    //  route  , related method
    // index => view any
    // 'show' => view
    // create => create
    // store => create
    // edit => update
    // update => update
    // destroy => delete
    //]

    public function __construct()
    {
        $this->middleware('auth');
        // this method specifies related policy method for every route that has user at the begining of it
        // for example for route users.edit it applies update policy method for it
        $this->authorizeResource(User::class, 'user');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        return view('users.show' , ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        return view('users.edit' , ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, user $user)
    {
        $user = User::findOrFail($user->id);

        $validatedData = $request->validated();
        if($request->hasfile('avatar')){
            $path = $request->file('avatar')->store('avatars');
            if($user->image){
                Storage::delete($user->image->path);
                $user->image->path = $path;
                $user->image->save();
            }else{
//                $image = new Image();
//                $image->path = $path;
//                $user->image()->save($image);
                $user->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

        $user->update($validatedData);
        return redirect()->route('users.show' , ['user' => $user->id])->withStatus('User has updated successfully');
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Models\user  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(user $user)
//    {
//        //
//    }
}
