<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Naive Bayes</title>

    <meta name="description" content="" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/assets/logonaivebayes.png') }}" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: "Poppins", sans-serif;
        }

        .login-box {
            width: 500px;
            padding: 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: white;
            animation: fadeIn 0.8s ease;
        }

        .login-box h3 {
            font-weight: 600;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.25);
            border: none;
            padding: 12px;
            color: #fff;
        }

        .form-control::placeholder {
            color: #eee;
        }

        .btn-custom {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            border: none;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            width: 100%;
        }

        .btn-custom:hover {
            opacity: 0.9;
        }

        .social-btn {
            border-radius: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 48%;
        }

        .social-btn img {
            width: 22px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        small.text-danger {
            color: #ffbaba !important;
        }
    </style>
</head>

<body>

    <div class="login-box">


        <h2 class="text-center mb-1">Welcome In</h2>
        <h3 class="text-center mb-2">Cabi Sense Tadulako Pride</h3>

        <p class="text-center mb-4">Silahkan Masuk Terlebih Dahulu</p>


        <form id="formLogin">
            @csrf

            <div class="mb-3">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address">
                <small id="email-error" class="text-danger"></small>
            </div>

            <div class="mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                <small id="password-error" class="text-danger"></small>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn-custom">Masuk</button>
            </div>
        </form>

        <hr style="border-color: rgba(255,255,255,0.2);">

        <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
            <img src="{{ asset('assets/assets/icon.jpg') }}" alt="Logo 1" class="img-fluid"
                style="width: 50px; height: 50px; object-fit: contain;">

            <img src="{{ asset('assets/assets/logonaivebayes.png') }}" alt="Logo 2" class="img-fluid"
                style="width: 50px; height: 50px; object-fit: contain;">
        </div>



    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const loginApi = "{{ url('auth/login') }}";

        $('#formLogin').submit(function(e) {
            e.preventDefault();

            $('.text-danger').text('');
            let formData = new FormData(this);

            Swal.fire({
                title: "Loading...",
                didOpen: () => Swal.showLoading(),
                allowOutsideClick: false
            });

            $.ajax({
                type: 'POST',
                url: loginApi,
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.close();
                    Swal.fire("Success", "Login berhasil!", "success");

                    setTimeout(() => {
                        window.location.href = "/dashboard";
                    }, 800);
                },
                error: function(xhr) {
                    Swal.close();

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, val) {
                            $('#' + key + '-error').text(val[0]);
                        });
                    } else {
                        Swal.fire("Error", "Email atau password salah!", "error");
                    }
                }
            });
        });
    </script>

</body>

</html>
