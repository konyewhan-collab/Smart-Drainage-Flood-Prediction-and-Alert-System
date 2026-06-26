@extends("template/mylayout")

@section("title","PageAdmin")
@section("aktif-admin","active")

@section("badan")
<h1> DELETE USER</h1>

<form method='POST'>
    @csrf
    Nama Pengguna: {{$data->nama}}<br>
    Kata Nama: {{$data->katanama}}<br>

    <input type='hidden' name='id' value='{{$data->id}}'>
    <input type='submit' name='btnDeleteConfirm' value='Confirm to DELETE'>
    <input type='submit' name='btnCancel' value='Cancel'>

</form>

@endsection
