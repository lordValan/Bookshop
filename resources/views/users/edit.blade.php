@extends('layouts.empty')
@section('title', 'Edit')

@section('content')
    <main class="user-page">
        <div class="panel flexible">
            <div class="panel-heading">
                <h3>Edit</h3>
            </div>
            @if (count($errors) > 0)
            <ul class="errors-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
            @endif
            <div class="panel-body">
                <form action="{{action('UserController@saveChanges')}}" method="POST" class="user-edit-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put" />
                    <div class="form-group">
                        <label for="fullname">Name*</label>
                        <input type="text" maxlength="100" id="fullname" name="fullname" required value="{{!is_null(old('fullname')) ? old('fullname') : $user->name}}">
                    </div>   
                    <div class="form-group">
                        <label for="birthday">Date of birth</label>
                        <input type="date" id="birthday" name="birthday" max="2007-12-31" min="1900-01-01" value="{{!is_null(old('birthday')) ? old('birthday') : $user->birthday}}">
                    </div> 
                    <div class="form-group">
                        <label for="about">About</label>
                        <input type="text" maxlength="1000" id="about" name="about" value="{{!is_null(old('about')) ? old('about') : $user->about}}">
                    </div>      
                    <div class="form-group">
                        <label for="facebook">Facebook id</label>
                        <input type="text" max="32" id="facebook" name="facebook" value="{{!is_null(old('facebook')) ? old('facebook') : $user->facebook}}">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter id</label>
                        <input type="text" id="twitter" max="32" name="twitter" value="{{!is_null(old('twitter')) ? old('twitter') : $user->twitter}}">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram id</label>
                        <input type="text" id="instagram" max="32" name="instagram" value="{{!is_null(old('instagram')) ? old('instagram') : $user->instagram}}">
                    </div>   
                    <div class="form-group">         
                        <button type="submit">Save changes</button>
                        <a href="{{route('home')}}"><button type="button">Home</button></a>
                    </div>   
                </form>
            </div>
        </div>
        
    </main>
@endsection



