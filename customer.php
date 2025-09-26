<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Theo dõi vận đơn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fadeInUp {
      animation: fadeInUp .45s ease forwards;
    }

    .toast {
      position: fixed;
      right: 1rem;
      bottom: 1rem;
      z-index: 60;
      min-width: 220px;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="bg-blue-700 text-white px-6 py-3 flex items-center justify-between shadow">
    <div class="flex items-center gap-2">
      <img src="../images/official_logo.jpg" alt="logo" class="h-10 w-10 rounded-full border border-white">
      <span class="font-bold text-xl">LogiX</span>
    </div>
    <ul class="flex items-center gap-6 font-medium">
      <li><a href="customer.php" class="hover:underline">Trang chủ</a></li>
      <li><a href="login.php" class="bg-white text-blue-700 px-3 py-1 rounded-lg shadow hover:bg-gray-100">Đăng xuất</a></li>
    </ul>
  </nav>

  <main class="flex-1 w-full max-w-6xl px-4 mx-auto">
    <header class="mt-8 mb-6 flex items-center justify-between">
      <h1 class="text-4xl font-extrabold text-blue-700 animate-pulse">Theo dõi vận đơn</h1>
      <div>
        <button id="refreshBtn" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
          ⟳ Làm mới
        </button>
      </div>
    </header>

    <section id="orders-container" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
      <div class="col-span-full text-center text-gray-500" id="loader">Đang tải đơn hàng...</div>
    </section>

    <!-- Template card -->
    <template id="order-card-template">
      <article class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl animate-fadeInUp">
        <div class="h-44 bg-gray-100 overflow-hidden">
          <img class="w-full h-full object-cover" alt="Ảnh đơn hàng">
        </div>
        <div class="p-5 flex flex-col gap-2">
          <div class="flex items-start justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800 order-id">Mã đơn: -</h2>
              <p class="text-sm text-gray-600 customer-name">Khách hàng: -</p>
              <p class="text-sm text-gray-600 order-status">Shipper: -</p>

            </div>
            <div class="text-right">
              <p class="text-sm text-gray-500">Số lượng</p>
              <p class="text-xl font-semibold qty">0</p>
            </div>
          </div>

          <div class="flex items-center gap-2 text-sm text-gray-700">
            <div class="px-3 py-1 rounded-md bg-blue-50 text-blue-700 font-medium total">0 đ</div>
            <a class="ml-auto text-blue-600 hover:underline map-link" href="#">Theo dõi đơn →</a>
          </div>

          <!-- Thời gian giao random -->
          <div class="mt-3 grid gap-2">
            <p class="text-sm font-medium text-gray-700">Thời gian giao dự kiến</p>
            <div class="time-display px-3 py-2 border rounded-xl bg-gray-50 font-semibold text-gray-800"></div>

            <label class="text-sm font-medium text-gray-700">Chọn địa điểm giao</label>
            <select class="place-select w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300"></select>

            <div class="flex items-center gap-2 mt-3">
              <button class="confirm-btn flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2 rounded-xl font-semibold shadow">Xác nhận giao hàng</button>
              <button class="btn-view-map text-gray-600 px-3 py-2 border rounded-xl hover:bg-gray-50">Bản đồ</button>
            </div>
          </div>
        </div>
      </article>
    </template>
  </main>

  <!-- toast -->
  <div id="toast" class="toast hidden"></div>

  <script>
    (() => {
      const ordersContainer = document.getElementById("orders-container");
      const loader = document.getElementById("loader");
      const template = document.getElementById("order-card-template");
      const refreshBtn = document.getElementById("refreshBtn");
      const toastEl = document.getElementById("toast");

      const lockers = [{
          id: "locker-1",
          label: "Smart Locker 1 - Đại học Cần Thơ"
        },
        {
          id: "locker-2",
          label: "Smart Locker 2 - Lotte Mart Cần Thơ"
        },
        {
          id: "locker-3",
          label: "Smart Locker 3 - Coopmart"
        },
        {
          id: "locker-4",
          label: "Smart Locker 4 - BigC"
        },
        {
          id: "locker-5",
          label: "Smart Locker 5 - Sense City"
        },
        {
          id: "custom-address",
          label: "91D Lý Tự Trọng, P.An Phú, Q.Ninh Kiều, TP.Cần Thơ"
        }
      ];

      const placeholderImages = [
        "https://intriphat.com/wp-content/uploads/2023/03/hop-carton-dong-hang-3.jpg",
        "https://get.pxhere.com/photo/box-carton-odyssey-product-design-packaging-and-labeling-package-delivery-221916.jpg",
        "https://hopcartondonghang.com/wp-content/uploads/2023/08/thung-carton-dung-sau-rieng-14.jpg"
      ];

      // Dữ liệu ảo đơn hàng
      const fakeOrders = [{
          DH_Ma: "DH001",
          KH_Ten: "Nguyễn Văn A",
          DH_SoLuongKIH: 2,
          DH_TongTien: 500000,
          TT_Ma: "TT001"
        },
        {
          DH_Ma: "DH002",
          KH_Ten: "Nguyễn Văn A",
          DH_SoLuongKIH: 1,
          DH_TongTien: 200000,
          TT_Ma: "TT002"
        },
        {
          DH_Ma: "DH003",
          KH_Ten: "Nguyễn Văn A",
          DH_SoLuongKIH: 3,
          DH_TongTien: 750000,
          TT_Ma: "TT001"
        },
        {
          DH_Ma: "DH004",
          KH_Ten: "Nguyễn Văn A",
          DH_SoLuongKIH: 5,
          DH_TongTien: 1500000,
          TT_Ma: "TT003"
        },
        {
          DH_Ma: "DH005",
          KH_Ten: "Nguyễn Văn A",
          DH_SoLuongKIH: 4,
          DH_TongTien: 990000,
          TT_Ma: "TT001"
        }
      ];

      const statusConfigs = {
        'TT001': {
          label: 'Ngô Đại Nam - 0912345678 - 65D 122345',
          btnText: 'Xác nhận giao hàng',
          enabled: true
        },
        'TT002': {
          label: 'Trần Thiên Thanh - 09123455555 - 65D 012345',
          btnText: 'Đang giao',
          enabled: false
        },
        'TT003': {
          label: 'Hứa Hoàng Minh - 09123466666 - 65D 122345',
          btnText: 'Đã giao',
          enabled: false
        }
      };

      function showToast(msg, type = "info") {
        toastEl.className = "toast fixed right-4 bottom-4 z-50";
        toastEl.innerHTML = `<div class="px-4 py-2 rounded-lg shadow-lg text-white ${type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'}">${msg}</div>`;
        toastEl.classList.remove('hidden');
        clearTimeout(toastEl._t);
        toastEl._t = setTimeout(() => {
          toastEl.classList.add('hidden');
        }, 3000);
      }

      function getRandomTime() {
        // Random trong khoảng 08:00 - 20:00
        const startHour = 8;
        const endHour = 20;
        const hour = Math.floor(Math.random() * (endHour - startHour + 1)) + startHour;
        const minute = Math.floor(Math.random() * 60);
        return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
      }

      function renderOrders(orders) {
        ordersContainer.innerHTML = "";
        if (!orders.length) {
          ordersContainer.innerHTML = `<div class="col-span-full text-gray-600 text-center">Không có đơn hàng để hiển thị.</div>`;
          return;
        }
        orders.forEach((order) => {
          const clone = template.content.cloneNode(true);
          const imgEl = clone.querySelector("img");
          const orderIdEl = clone.querySelector(".order-id");
          const customerNameEl = clone.querySelector(".customer-name");
          const statusEl = clone.querySelector(".order-status");
          const qtyEl = clone.querySelector(".qty");
          const totalEl = clone.querySelector(".total");
          const mapLinkEl = clone.querySelector(".map-link");
          const confirmBtn = clone.querySelector(".confirm-btn");
          const placeSelect = clone.querySelector(".place-select");
          placeSelect.id = `place-select-${order.DH_Ma}`;
          const viewMapBtn = clone.querySelector(".btn-view-map");
          const timeDisplay = clone.querySelector(".time-display");

          imgEl.src = placeholderImages[Math.floor(Math.random() * placeholderImages.length)];
          orderIdEl.textContent = `Mã đơn: ${order.DH_Ma}`;
          customerNameEl.textContent = `Khách hàng: ${order.KH_Ten}`;
          qtyEl.textContent = order.DH_SoLuongKIH;
          totalEl.textContent = new Intl.NumberFormat('vi-VN').format(order.DH_TongTien) + " đ";

          const statusConfig = statusConfigs[order.TT_Ma] || {
            label: "Không xác định",
            btnText: "-",
            enabled: false
          };
          statusEl.textContent = `Shipper: ${statusConfig.label}`;
          confirmBtn.textContent = statusConfig.btnText;
          confirmBtn.disabled = !statusConfig.enabled;

          // Thời gian random hôm nay
          const randomTime = getRandomTime();
          timeDisplay.textContent = `${randomTime} hôm nay`;

          // Populate place select
          lockers.forEach(l => {
            const opt = document.createElement("option");
            opt.value = l.id;
            opt.textContent = l.label;
            placeSelect.appendChild(opt);
          });
          let val = null;
          confirmBtn.addEventListener('click', () => {
            showToast(`Đơn ${order.DH_Ma} đã được xác nhận giao lúc ${randomTime}.`, "success");
            confirmBtn.disabled = true;
            confirmBtn.textContent = "Đang giao";
            const sel = document.getElementById(`place-select-${order.DH_Ma}`);
            val = sel.value;
          });
          // Map links
          mapLinkEl.href = `customer_map.php?order_id=${encodeURIComponent(order.DH_Ma)}&dest_id=${encodeURIComponent(val)}`;
          viewMapBtn.addEventListener('click', () => {
            window.location.href = `customer_map.php?order_id=${encodeURIComponent(order.DH_Ma)}&dest_id=${encodeURIComponent(val)}`;
          });

          ordersContainer.appendChild(clone);
        });
      }

      refreshBtn.addEventListener('click', () => renderOrders(fakeOrders));
      document.addEventListener('DOMContentLoaded', () => {
        loader.style.display = "none";
        renderOrders(fakeOrders);
      });
    })();
  </script>
</body>

</html>