@extends('layouts.app')

@section('title', 'Developer Platform')

@section('content')
    <div class="home-page full-height">
        <div class="hero flex align-center justify-space-between has-image animated">
            <div class="container flex align-center justify-space-between">
                <div class="hero-intro col-lg-6 col-md-6">
                    <h1>Build Apps that aid<br>Team Communication.</h1>
                    <p>
                        Create apps, bots and integrations that can be used by your teams, or publish them to the
                        Marketplace for other teams to use.
                    </p>
                    <a class="btn btn-primary" href="#">Start Building</a>
                    <a class="btn btn-default" href="#">View Docs</a>
                </div>
                <div class="hero-image col-lg-6 col-md-6 hidden-sm hidden-xs text-center">
                    <img class="animated zoomIn" src="{{ asset('illustrations/engine.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
