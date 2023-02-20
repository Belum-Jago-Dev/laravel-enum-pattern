<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Laravel Enum</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-12 col-md-10">
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Created at</th>
                            <th class="text-center" scope="col">Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <th class="text-center align-middle" scope="row">
                                {{ $loop->iteration }}
                            </th>
                            <td class="text-center align-middle">
                                {{ $user->name }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->email }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->status }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->created_at }}
                            </td>
                            <td class="text-center align-middle">
                                {{ $user->updated_at }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <th class="text center">Data Kosong</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
