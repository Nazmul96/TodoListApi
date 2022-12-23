@extends('backend.layouts.master')
@section('admin_content')
<div id="main" class="bg-light">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Add Team</h3>
        </div>
        <div class="page-content">
        
            <form action="">
                <div class="col-md-6">
                        <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">Name*</label>
                        <input type="text" id="disabledTextInput" class="form-control" placeholder="Name">
                        </div>
                        <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">Email*</label>
                        <input type="text" id="disabledTextInput" class="form-control" placeholder="Email">
                        </div>
                        <div class="mb-3">
                        <label for="">Role*</label>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Carer
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Senior Carer
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Carerhome Admin
                        </label>
                        </div>
                        </div>                
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
        </div>
</div>        
@endsection