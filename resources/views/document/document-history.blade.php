@extends('template.main')
@section('title', 'Document History')
<style>
    .list-link {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgb(255, 153, 0);
        padding: 2rem 5rem;
        border-radius: 5px
    }

    .list-link ul li {
        list-style: none outside;
    }

</style>
@section('content')
    <div class="list-link">
        <h3 class="text-white text-center">Document History</h3>
        <div class="row d-flex">
            @if (count($files) >= 1)
                <?php $file_initial = explode('_', $files[0])[0]; ?>
                @foreach ($files as $key => $file)
                    <?php
                    $file = str_replace('.docx', '', $file);
                    ?>
                    <a href="/document/view/{{ $id }}/{{ $file }}" class="btn btn-primary my-2"
                        style="background: rgb(8, 149, 162)">Version {{ $key += 1 }}</a>
                @endforeach
            @endif
        </div>
    </div>
@endsection
