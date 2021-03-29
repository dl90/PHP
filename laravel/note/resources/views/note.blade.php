@extends('layouts.base')

@section('pageTitle')
    Note: Your Notes
@endsection

@section('bodyContent')
    <div>
        <div class="container border d-flex align-items-center justify-content-between mt-3">
            <h3>{{ $user_email ?? 'Error' }}</h3>
            <div class="d-flex my-3">
                <input form="note" type="submit" class="btn btn-outline-success mx-2">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <input type="submit" name="logout" value="Logout" class="btn btn-outline-warning mx-2"/>
                </form>
            </div>
        </div>
        <div class="container mt-2">

            <h4 id="message" class="text-info col-12 d-inline-flex justify-content-center">{{ $message ?? '' }}</h4>
            @if($errors)
                @foreach($errors as $error)
                    <div>{{$error->message}}</div>
                @endforeach
            @endif

            <form id="note" method="POST" action="{{ route('app.note') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col border mx-1">
                        <h3>Notes</h3>
                        <textarea name="note" style="resize: none; width: 100%;"
                                  rows="30">{{ $notes->note ?? '' }}</textarea>
                    </div>

                    <div class="col border mx-1 container">
                        <h3>Websites</h3>
                        @for ($i = 0; $i < count($sites ?? []) + 4; $i++)
                            <div class="col-12 d-inline-flex align-items-center">
                                <input
                                        type="text"
                                        name="sites[]"
                                        value="{{ $sites[$i]->link ?? '' }}"
                                        style="width: 100%;"
                                        class="m-2 ">
                                <input hidden name="sites_id[]" value="{{ $sites[$i]->id ?? '' }}">
                                <a href="http://{{ $sites[$i]->link ?? '' }}"
                                   target="_blank"
                                   class="btn btn-secondary btn-sm">Open</a>
                            </div>
                        @endfor
                    </div>

                    <div class="col border mx-1">
                        <h3>Images</h3>
                        @if(count($images) < 4)
                            <input type="file"
                                   name="image[]"
                                   accept="image/png"
                                   multiple onchange="file(event, {{ $images }})"
                                   class="form-control-file my-2">
                        @else
                            <p class="text-info">Max 4 images. Delete some to store new images.</p>
                        @endif

                        @foreach($images as $image)
                            <div class="container d-inline-flex align-items-center">
                                <a href="{{ asset($image->path) }}" target="_blank">
                                    <img src="{{ asset($image->path) }}" width="200" class="my-3">
                                </a>
                                <label for="_img_del" class="mx-1">Delete</label>
                                <input type="checkbox" name="img_del_ids[]" id="_img_del" value="{{ $image->id }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="col border mx-1">
                        <h3>ToDos</h3>
                        @for ($i = 0; $i < count($todos ?? []) + 2; $i++)
                            <input
                                    type="text"
                                    name="todos[]"
                                    value="{{ $todos[$i]->todo ?? '' }}"
                                    style="width: 100%;"
                                    class="mb-2">
                            <input hidden name="todos_id[]" value="{{ $todos[$i]->id ?? '' }}">
                        @endfor
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function file(e, existing_images) {
            e.preventDefault()
            if (e.target.files.length + existing_images.length > 4) {
                document.querySelector('#message').innerText = "Only 4 images per user"
                e.target.value = ''
            }
        }
    </script>
@endsection