@extends('backend.layouts.master')
@section('admin_content')
<div id="main" class="bg-light">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Client List</h3>
        </div>
        <div class="page-content">
        
            <table class="table table-bordered">
               <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date Of Birth</th>
                            <th>Action</th>
                        </tr>
               </thead>
               <tbody>
                    <tr>
                        <td>abcd</td>
                        <td>Male</td>
                        <td>1970</td>
                        <td>
                            <a href="{{route('client.edit')}}" class="btn btn-sm btn-info">Edit</a>
                            <a href="" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
               </tbody>
            </table>
            
        </div>
</div>        
@endsection