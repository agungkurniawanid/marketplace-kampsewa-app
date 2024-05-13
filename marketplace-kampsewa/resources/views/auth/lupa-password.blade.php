<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/logo.ico') }}">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="_container w-full h-screen flex justify-center items-center">
        <div class="_form w-[400px]">
            <form action="{{ route('lupa-password.send-email') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div class="_image w-full flex justify-center">
                    <img class="w-[250px] object-cover" src="{{ asset('assets/vector/grapy-online-meetings.png') }}"
                        alt="">
                </div>
                <div class="_title">
                    <h1 class="text-[24px] text-center font-medium">Lupa Password?</h1>
                    <p class="text-[14px] text-center">Untuk mendapatkan link reset password masukkan email yang telah
                        anda daftarkan.</p>
                </div>
                <div class="_feild-email flex flex-col gap-2">
                    <label for="email" class="text-[14px] font-medium">Masukkan Email:</label>
                    <div class="_email w-full">
                        <input placeholder="ex: agungklewang26@gmail.com"
                            class="border focus:outline-[#5038ED] w-full border-solid rounded-[10px] text-[14px] p-4"
                            type="email" name="email" id="email">
                    </div>
                </div>
                <div class="_button-submit w-full">
                    <button type="submit"
                        class="w-full p-4 bg-gradient-to-bl rounded-[10px] from-[#B381F4] to-[#5038ED] text-white text-[14px] font-medium">Selanjutnya</button>
                </div>
                <p class="text-[14px] font-medium text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-[#5038ED] hover:underline">Login</a></p>
            </form>
        </div>
    </div>
</body>

</html>
