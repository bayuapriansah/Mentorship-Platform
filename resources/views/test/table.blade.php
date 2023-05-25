<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
</head>
<body>
    <table id="myTable">
        <thead>
            <tr>
                <th>Select</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emails as $email)
                <tr>
                    <td><input type="checkbox" class="checkbox" name="selected_emails[]" value="{{ $email[0] }}"></td>
                    <td>{{ $email[0] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
</body>
</html>
