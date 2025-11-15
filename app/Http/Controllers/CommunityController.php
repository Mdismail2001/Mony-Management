<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;

class CommunityController extends Controller
{
    public function show($id)
    {
        $community = Community::findOrFail($id);
        return view('communities.show' , compact('community'));
    }


}
