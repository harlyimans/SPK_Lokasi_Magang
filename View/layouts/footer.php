    </div>
    <!-- ./wrapper -->

    <!-- Custom JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toggler = document.querySelector(".navbar-toggler");
            var collapse = document.querySelector(".navbar-collapse");
            if (toggler && collapse) {
                toggler.addEventListener("click", function() {
                    collapse.classList.toggle("show");
                });
            }
        });
    </script>
</body>
</html>
