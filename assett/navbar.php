<nav class="navbar">
  <div class="logo"><?= $_SESSION['nama'] ?? 'User' ?></div>
  
  <!-- Hamburger -->
  <div class="menu-toggle" id="menu-toggle">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <!-- Menu -->
  <ul class="nav-menu" id="nav-menu">
    <li><a href="beranda.php">Home</a></li>
    <li><a href="profil.php">Profil</a></li>
    <li><a href="#">Riwayat</a></li>
    <li><a href="#">Contact Us</a></li>
    <li><a href="logout.php" class="logout">Logout</a></li>
  </ul>
</nav>

<script>
  const toggle = document.getElementById("menu-toggle");
  const menu = document.getElementById("nav-menu");

  toggle.addEventListener("click", () => {
    menu.classList.toggle("active");
  });
</script>