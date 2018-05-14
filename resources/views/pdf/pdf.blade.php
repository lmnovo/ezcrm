<!DOCTYPE html>
<html>
<head>

    <title>Load PDF</title>
    <style type="text/css">
        table{
            width: 100%;
            border:1px solid black;
        }
        td, th{
            border:1px solid black;
        }
    </style>

</head>

<body>
<h2>Load PDF File</h2>

<table>
    @foreach($order as $product)
    <tr>
        <th>{{ $product->business_name }}</th>
    </tr>
    @endforeach

</table>

</body>
</html>