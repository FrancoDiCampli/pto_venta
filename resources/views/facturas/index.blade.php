@extends('main')

@section('content')

    <table class="table">
        <thead>
            <tr>
                <th>Num</th>
                <th>Importe</th>
                <th>Fecha</th>
                <th>Cuit</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facturas as $item)
            <tr>
            <td>{{$item->id}}</td>
                <td>{{$item->id}}</td>
                <td>{{$item->id}}</td>
                <td>{{$item->id}}</td>
                <td>{{$item->id}}</td>
            </tr>
            @endforeach
           
        </tbody>
    </table>

@endsection