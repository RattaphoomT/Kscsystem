@extends('layout')

@section('title')
    ติดต่อเรา | KSC System
@endsection

@section('breadcrumb')
@endsection

@section('contentitle')
    <h4 class="page-title">ติดต่อเรา</h4>
@endsection

@section('nonconten')
@endsection

@section('conten')
    <div class="row">
        <div class="col-sm-12 col-md-6 mt-3">
            <img src="{{ asset('img/contactpage.png') }}" alt="contactpage" class=""
                style="width: 100%; border-radius: 5px;">

        </div>
        <div class="col-sm-12 col-md-6 mt-3">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.211001075479!2d102.7901978!3d16.4141068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x312263e4b44b6ced%3A0xd892e1ac3350c807!2z4Liq4Lij4Liw4Lin4LmI4Liy4Lii4LiZ4LmJ4Liz4Lir4Lih4Li54LmI4Lia4LmJ4Liy4LiZ4Lih4LiH4LiE4Lil4LmA4Lil4Li04Lio4LiY4Liy4LiZ4Li1IDI!5e0!3m2!1sth!2sth!4v1717964970081!5m2!1sth!2sth"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection
