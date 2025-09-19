<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-background {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="flex max-w-4xl w-full bg-white rounded-2xl shadow-lg overflow-hidden border border-blue-500">
        
        <!-- Cột bên trái -->
        <div class="hidden md:flex w-1/2 custom-background text-white p-12 flex-col justify-between items-start relative">
            <h2 class="text-3xl font-bold mb-4 z-10">LogiX</h2>
            <div class="space-y-4 z-10">
                <div class="flex items-center space-x-2">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-lg font-medium">Nhanh chóng</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-lg font-medium">Tiện lợi</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-lg font-medium">An toàn</p>
                </div>
            </div>
            
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <div class="absolute top-8 left-8 w-16 h-16 bg-white rounded-full"></div>
                <div class="absolute top-1/3 left-1/4 w-8 h-8 bg-white rounded-full"></div>
                <div class="absolute bottom-12 right-12 w-24 h-24 bg-white rounded-full"></div>
                <div class="absolute top-1/4 right-1/4 w-4 h-4 rounded-full bg-white animate-pulse"></div>
                <div class="absolute bottom-1/3 left-1/2 w-6 h-6 rounded-full bg-white animate-pulse"></div>
            </div>
        </div>
        
        <!-- Cột form login -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <img src="../images/official_logo.jpg" alt="" class="w-16 h-16 mb-6">
            <form id="loginForm" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="Nhập tên đăng nhập" required>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" placeholder="********" required>
                </div>

                <div class="flex justify-between items-center">
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Quên mật khẩu?</a>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition-colors duration-200">
                    ĐĂNG NHẬP
                </button>
                <p id="errorMsg" class="text-red-500 mt-2 hidden"></p>
            </form>
        </div>
    </div>

<script>
document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();
    const user = document.getElementById("username").value.trim();
    const pass = document.getElementById("password").value.trim();
    const errorMsg = document.getElementById("errorMsg");

    if(user === "khachhang7" && pass === "kh123"){
        localStorage.setItem("user", user);
        window.location.href = "customer.php";
    } else {
        errorMsg.textContent = "Sai tên đăng nhập hoặc mật khẩu!";
        errorMsg.classList.remove("hidden");
    }
});
</script>

</body>
</html>
