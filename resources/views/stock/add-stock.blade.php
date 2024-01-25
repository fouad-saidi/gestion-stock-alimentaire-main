<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <form action="{{route('stock.store')}}" method="POST">
        @csrf
        <div style="width: 30%;margin-right: auto;margin-left: auto;margin-top: 10%;">
            <h2 style="text-align: center;margin-bottom: 5%;">Add Stock</h2>
            <div class="mb-3">
                <label for="product" class="form-label">Select product</label>
                <select type="text" class="form-control" name="product_id">
                    @foreach($products as $product)
                    <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Experation Date</label>
                <input type="date" class="form-control" name="date_experation">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</body>

</html>