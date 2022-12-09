<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container">
    <h2>Vertical (basic) form</h2>
    <form  data-action="{{ route('calculate.result') }}" method="POST"  id="add-user-form">
        @csrf
        <div class="form-group">
            <label for="input1">Input1:</label>
            <input type="number" class="form-control" id="input1"  name="input1">
        </div>
        <div class="form-group">
            <label for="input2">input2:</label>
            <input type="number" class="form-control" id="input2"  name="input2">
        </div>

        <button type="submit" name="btnSubmit" class="btn btn-default abc " value="+">plus</button>
        <button type="submit" name="minus" class="btn btn-default" value="-">minus</button>
        <button type="submit" name="multiply" class="btn btn-default" value="*">multiply</button>
        <button type="submit" name="divide" class="btn btn-default" value="/">divide</button>

        <h3>Result : </h3>
    </form>
</div>

</body>
</html>
<script>
    $(document).ready(function(){

        var form = '#add-user-form';

        $(document).on('click','.abc',function(event){
            event.preventDefault();

form.submit();
            var url = $(this).attr('data-action');

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(response)
                {
                    $(form).trigger("reset");
                    alert(response.success)
                },
                error: function(response) {
                }
            });
        });

    });

</script>
