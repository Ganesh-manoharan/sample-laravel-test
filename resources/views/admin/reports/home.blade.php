@extends('layouts.dashboard')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper dashboard">
        <!-- Main content -->
        <section class="content">
            <iframe title="reports" src="{{ route('showreport') }}" width="100%" height="720"></iframe>
        </section>
    </div>

@endsection