<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php 
        // return dd($data);
    ?>
    <table class="table table-bordered">
        <thead>
            <tr class="table-danger">
                <th>Employee Code</th>
                <th>Password</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            </thead>
          <tbody>
              @foreach ($data as $key => $rec)
                  <tr>
                      <td>{{ $rec->EmployeeCode }}</td>
                      <td>{{ $rec->Password }}</td>
                      <td>{{ $rec->UserName }}</td>
                  </tr>
              @endforeach
          </tbody>
        </table>
</body>
</html>