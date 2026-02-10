<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- {{ $schema ?? '' }} --}}
    <title>{{ $title ?? 'Trang mặc định' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <x-wp-comp::header />
    <main class="container">
        <div class="row">
            {{-- Sidebar: Mặc định ẩn (d-none), hiện khi màn hình từ Large trở lên (d-lg-block) --}}
            {{-- <div class="col-lg-3 d-none d-lg-block">
                <x-wp-compName::sidebar-component />
            </div> --}}
            <div class="col-lg-3 d-none d-lg-block">
                <x-wp-comp::sidebar />
            </div>

            {{-- Content: Mặc định 100% (col-12), chiếm 8 phần khi màn hình lớn (col-lg-8) --}}
            <div class="col-12 col-lg-9">
                {{ $slot }}
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
