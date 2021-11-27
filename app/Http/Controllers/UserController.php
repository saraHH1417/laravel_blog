<?php

namespace App\Http\Controllers;

use App\Contracts\CounterContract;
use App\Facades\CounterFacade;
use App\Http\Requests\UpdateUser;
use App\Models\Image;
use App\Models\user;
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
        $this->middleware('auth')->except(['show']);
        // this method specifies related policy method for every route that has user at the begining of it
        // for example for route users.edit it applies update policy method for it
        $this->authorizeResource(User::class , 'user');

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $languages = User::LOCALES;
//        $counter = resolve(Counter::class);
        return view('users.show' , [
            'user' => $user ,
            'languages' => $languages,
            'counter' => CounterFacade::increment("user-{$user->id}")
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        $languages = User::LOCALES;
        return view('users.edit' , ['user' => $user , 'languages' => $languages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
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
        $user->name = $request->get('name');
        $user->locale = $request->get('locale');
        $user->save();
//        $user->update($validatedData);
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
