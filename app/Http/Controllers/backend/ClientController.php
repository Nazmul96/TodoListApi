<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function addClient()
    {
       return view('backend.client.addClient');
    }

    public function ClientList()
    {
        return view('backend.client.ClientList');
    }

    public function ClientEdit()
    {
        return view('backend.client.ClientEdit');
    }
}
