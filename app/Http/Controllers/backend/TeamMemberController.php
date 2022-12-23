<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function teamMemberAdd()
    {
        return view('backend.team.addTeam');
    }
}
