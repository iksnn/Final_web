<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\about;
use Illuminate\Support\Facades\File;

class TentangController extends Controller
{
    public function index()
    {
        $about = about::first();
        return view('tentang.index', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $input = $request->all();

        if ($request->has('logo')){
            File::delete('uploads/'. $about->logo);
            $logo = $request->file('logo');
            $nama_logo = time() . rand(1, 9) . '.' . $logo->getClientOriginalExtension();
            $logo->move('uploads', $nama_logo);
            $input['logo'] = $nama_logo;
        }else{
            unset($input['logo']);
        }
        $about->update($input);
        return redirect('/tentang');
    }
}
