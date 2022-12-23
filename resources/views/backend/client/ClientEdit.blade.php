@extends('backend.layouts.master')
@section('admin_content')
<div id="main" class="bg-light">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Edit Client</h3>
        </div>
        <div class="page-content">
        
            <form action="">
              <div class="row">
                <div class="col-md-6">
                        <label for="">Profile Image</label>
                        <div class="mb-3">
                            <div class="avatar avatar-xl me-3">
                                <img src="{{asset('backend/dist')}}/assets/images/faces/3.jpg" alt="" srcset="">
                            </div>
                        </div>   
                        <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">Name</label>
                        <input type="text" id="disabledTextInput" class="form-control" placeholder="Name">
                        </div>
                        <div class="mb-3">
                        <label for="">Gender</label>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Male
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Female
                        </label>
                        </div>
                        </div>
                        <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">Date Of Birth</label>
                        <input type="date" id="disabledTextInput" class="form-control" placeholder="Disabled input">
                        </div>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Status</label>
                            <select name="" id="" class="form-control">
                                <option value="">Active</option>
                                <option value="">DeActive</option>
                            </select>
                        </div>
                        
                </div>
                <div class="col-md-6">
                      <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">Assign to Carer</label>
                            <select name="" id="" class="form-control">
                                <option value="">aman</option>
                                <option value="">jaman</option>
                            </select>
                      </div>
                      <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">About me</label>
                            <textarea name="" id="" cols="30" rows="5" class="form-control">

                            </textarea>
                      </div>
                </div>
            </div>   
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
</div>        
@endsection