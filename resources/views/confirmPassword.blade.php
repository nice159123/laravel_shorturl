@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">กรุณาใส่รหัสผ่าน</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('confirm.check', $shorturl->code) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน" required>
                        </div>
                        <button type="submit" class="btn btn-block btn-success">ยืนยัน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
