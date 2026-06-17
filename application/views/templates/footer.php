<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <!-- <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©
      <script>
        document.write(new Date().getFullYear());
      </script>
      , made with ❤️ by
      <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
    </div>
    <div>
      <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
      <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

      <a
        href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
        target="_blank"
        class="footer-link me-4">Documentation</a>

      <a
        href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
        target="_blank"
        class="footer-link me-4">Support</a>
    </div>
  </div> -->
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="<?= base_url() ?>assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?= base_url('assets/vendor/libs/select2/select2.min.js') ?>"></script>
<script src="<?= base_url() ?>assets/vendor/libs/popper/popper.js"></script>
<script src="<?= base_url() ?>assets/vendor/js/bootstrap.js"></script>
<script src="<?= base_url() ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="<?= base_url() ?>assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?= base_url() ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="<?= base_url() ?>assets/js/main.js"></script>

<!-- Page JS -->
<script src="<?= base_url() ?>assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- filtering -->
<!-- ajax -->
<script>
  document.querySelectorAll('.toggle-password').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
      const input = this.parentElement.querySelector('input');
      const icon = this.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
      } else {
        input.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#kategori').on('change', function() {
      let kategori = $(this).val();

      $.ajax({
        url: "<?= base_url('pos/getProdukByKategori') ?>",
        type: "POST",
        data: {
          kategori: kategori
        },
        dataType: "json",
        success: function(data) {
          $('#produk').empty();
          $('#produk').append('<option value="">-- Pilih produk --</option>');

          if (data.length > 0) {
            $.each(data, function(i, item) {
              $('#produk').append(
                '<option value="' + item.id + '">' + item.nama_produk + ' - Rp. ' + parseInt(item.harga).toLocaleString('id-ID') + '</option>'
              );
            });
          } else {
            $('#produk').append('<option value="">Tidak ada produk</option>');
          }
        }

      });
    });
  });
</script>
<script>
  $(document).on("click", "#btn-clear-cart", function(e) {
    e.preventDefault();
    Swal.fire({
      title: "Yakin?",
      text: "Semua produk di keranjang akan dihapus.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, kosongkan!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "<?= base_url('pos/clearCart') ?>";
      }
    });
  });
</script>
<!-- end ajax -->
<!-- filtering end -->
<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const table = document.getElementById("THead");
    const tbody = document.getElementById("TBody");
    const searchInput = document.getElementById("searchInput");
    const pagination = document.getElementById("paginationWrapper");
    let typingTimer;
    const delay = 300;
    // ==== LIVE SEARCH lama ====
    // searchInput.addEventListener("keyup", function() {
    //   const filter = this.value.toLowerCase();
    //   const rows = tbody.querySelectorAll("tr");

    //   rows.forEach(row => {
    //     const text = row.innerText.toLowerCase();
    //     row.style.display = text.includes(filter) ? "" : "none";
    //   });
    // });
    function fetchData(query = "") {
      fetch("<?= base_url('produk/search_all') ?>?q=" + encodeURIComponent(query))
        .then(response => response.text())
        .then(html => {
          tbody.innerHTML = html;
          tbody.classList.add("fade-in");
          bindSorting();

          setTimeout(() => tbody.classList.remove("fade-in"), 300);
        });
    }

    searchInput.addEventListener("keyup", function() {
      clearTimeout(typingTimer);

      typingTimer = setTimeout(() => {
        const q = this.value.trim();

        // Jika sedang mencari → hide pagination
        if (q !== "") {
          pagination.style.display = "none";
          fetchData(q);
        } else {
          // Jika input kosong → show pagination & reload default page
          pagination.style.display = "block";
          location.reload();
        }
      }, delay);
    });

    function bindSorting() {
      document.querySelectorAll(".sort").forEach(header => {
        header.onclick = function() {
          const sortKey = this.getAttribute("data-sort");
          const rows = Array.from(tbody.querySelectorAll("tr"));
          const asc = this.classList.toggle("asc");

          rows.sort((a, b) => {
            let valA = a.querySelector("." + sortKey)?.innerText.trim() || "";
            let valB = b.querySelector("." + sortKey)?.innerText.trim() || "";

            if (sortKey === "stok") {
              valA = parseInt(valA);
              valB = parseInt(valB);
            }

            return asc ? valA.localeCompare(valB, undefined, {
                numeric: true
              }) :
              valB.localeCompare(valA, undefined, {
                numeric: true
              });
          });

          tbody.innerHTML = "";
          rows.forEach(row => tbody.appendChild(row));
        };
      });
    }
    bindSorting();
  });
</script> -->
</body>

</html>