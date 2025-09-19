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
    .tab-active {
      border-bottom: 2px solid #2563eb;
      color: #2563eb;
    }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

  <div class="flex max-w-5xl w-full bg-white rounded-2xl shadow-lg overflow-hidden border border-blue-500">
    
    <!-- Cột bên trái -->
    <div class="hidden md:flex w-1/3 custom-background text-white p-12 flex-col justify-between items-start relative">
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
    </div>

    <!-- Cột form login -->
    <div class="w-full md:w-2/3 p-8 md:p-12 flex flex-col justify-center">
      <img src="../images/official_logo.jpg" alt="" class="w-16 h-16 mb-6">

      <!-- Tabs -->
      <div class="flex border-b mb-6">
        <button class="flex-1 py-2 text-center font-medium tab-btn tab-active" data-tab="admin">Quản trị viên</button>
        <button class="flex-1 py-2 text-center font-medium tab-btn" data-tab="supplier">Nhà cung cấp</button>
        <button class="flex-1 py-2 text-center font-medium tab-btn" data-tab="customer">Khách hàng</button>
        <button class="flex-1 py-2 text-center font-medium tab-btn" data-tab="shipper">Shipper</button>
      </div>

      <!-- Nội dung Tabs -->
      <div id="tab-contents" class="space-y-6">
        <form id="login-admin" class="tab-content" data-role="admin">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
            <input type="text" name="username" class="w-full px-4 py-2 border rounded-md" placeholder="Nhập tên đăng nhập" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-md" placeholder="********" required>
          </div>
          <p class="text-red-500 mt-2 hidden errorMsg"></p>
          <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md">Đăng nhập Admin</button>
        </form>

        <form id="login-supplier" class="tab-content hidden" data-role="supplier">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
            <input type="text" name="username" class="w-full px-4 py-2 border rounded-md" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-md" required>
          </div>
          <p class="text-red-500 mt-2 hidden errorMsg"></p>
          <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md">Đăng nhập Nhà cung cấp</button>
        </form>

        <form id="login-customer" class="tab-content hidden" data-role="customer">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
            <input type="text" name="username" class="w-full px-4 py-2 border rounded-md" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-md" required>
          </div>
          <p class="text-red-500 mt-2 hidden errorMsg"></p>
          <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md">Đăng nhập Khách hàng</button>
        </form>

        <form id="login-shipper" class="tab-content hidden" data-role="shipper">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
            <input type="text" name="username" class="w-full px-4 py-2 border rounded-md" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-md" required>
          </div>
          <p class="text-red-500 mt-2 hidden errorMsg"></p>
          <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-md">Đăng nhập Shipper</button>
        </form>
      </div>
    </div>
  </div>

<script>
  // Chuyển tab
  const tabs = document.querySelectorAll(".tab-btn");
  const contents = document.querySelectorAll(".tab-content");
  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      tabs.forEach(t => t.classList.remove("tab-active"));
      tab.classList.add("tab-active");
      contents.forEach(c => c.classList.add("hidden"));
      document.getElementById("login-" + tab.dataset.tab).classList.remove("hidden");
    });
  });

  // Đăng nhập giả lập (localStorage)
  const credentials = {
    admin: { user: "admin1", pass: "ad123", redirect: "customer.php" },
    supplier: { user: "supplier1", pass: "sp123", redirect: "customer.php" },
    customer: { user: "khachhang7", pass: "kh123", redirect: "customer.php" },
    shipper: { user: "shipper1", pass: "sh123", redirect: "customer.php" }
  };

  contents.forEach(form => {
    form.addEventListener("submit", e => {
      e.preventDefault();
      const role = form.dataset.role;
      const username = form.querySelector("[name='username']").value.trim();
      const password = form.querySelector("[name='password']").value.trim();
      const errorMsg = form.querySelector(".errorMsg");

      if (username === credentials[role].user && password === credentials[role].pass) {
        localStorage.setItem("user", username);
        localStorage.setItem("role", role);
        window.location.href = credentials[role].redirect;
      } else {
        errorMsg.textContent = "Sai tên đăng nhập hoặc mật khẩu!";
        errorMsg.classList.remove("hidden");
      }
    });
  });
</script>

</body>
</html>
