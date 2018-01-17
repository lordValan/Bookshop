@extends('layouts.app')

@section('title', $profileUser->name)
@section('content')
@php 
    $photo = '/images/users/user' . $profileUser->id . '.jpg'; 
    $date = !is_null($profileUser->birthday) ? new DateTime($profileUser->birthday) : null;
    $hasSocial = !is_null($profileUser->facebook) || !is_null($profileUser->twitter) || !is_null($profileUser->instagram);
@endphp
    <div class="person-container user-container">
        <div class="person-block flexible rewidth">
            <div class="main-person flexible">
                <div class="person-photo-container" style="background-image: url('{{ File::exists(public_path() . $photo) ? URL::asset($photo) : URL::asset('/images/other/unknown.png') }}');">&nbsp;</div>
                <div class="person-info-container flexible">
                    <h3 class="person-name">{{$profileUser->name}}</h3> 
                    @if(!is_null($date)) <p class="person-date-birth">{{$date->format('M d, Y')}}</p> @endif                
                    @if($hasSocial)
                    <div class="person-social">
                        @if(!is_null($profileUser->facebook)) <a href="{{'https://www.facebook.com/' . $profileUser->facebook}}"><i class="ti ti-facebook"></i></a>  @endif
                        @if(!is_null($profileUser->twitter)) <a href="{{'https://twitter.com/' . $profileUser->twitter}}"><i class="ti ti-twitter"></i></a>  @endif
                        @if(!is_null($profileUser->instagram)) <a href="{{'https://www.instagram.com/' . $profileUser->instagram}}"><i class="ti ti-instagram"></i></a>  @endif
                    </div>
                    @endif
                    <div class="person-bio">
                        <p>{{$profileUser->about}}</p>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    </main>
@endsection



