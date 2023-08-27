<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() 
    {
      return view('register');   
    }

   public function registerData(request $request)
   {
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email',
        'language' => 'required',
        'gender' => 'required',
    ]);
        
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('main_image'), $filename);

            Admin::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'language' => $validatedData['language'],
                'gender' => $validatedData['gender'],
                'image' => $filename,
            ]);

            return redirect()->route('form-view');
   }


   public function Userdata(){

    $user = Admin::all();
    return view('dashboard',compact('user'));
   }


   public function editUser(request $request ,$id)
   {  
    $user = Admin::find($id);
    return response()->json(['status'=>200,'user'=>$user]);
      
   }

   

    public function updateUser(Request $request)
    {
        $userId = $request->input('userId');
        $user = Admin::find($userId);
        // Update fields that are not related to the image
        $user->name = $request->input('editName');
        $user->email = $request->input('editEmail');
        $user->gender = $request->input('editGender');
        $user->language = $request->input('editLanguage');
    
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Handle the new image upload
            $newImage = $request->file('image');
            $newImageName = time() . '.' . $newImage->getClientOriginalExtension();
            $newImage->move(public_path('main_image'), $newImageName);
    
            // Delete the old image
            if ($user->image) {
                $oldImagePath = public_path('main_image/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            // Update the image field
        $user->image = $newImageName;
        }
    
        $user->save();
    
        return response()->json(['message' => 'User information updated successfully']);
    }
    
}
