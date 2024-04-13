<style>
  .fab-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }

  .fab {
    background-color: #25D366;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 30px;
    cursor: pointer;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
  }

  .fab-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    background: white;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    margin-top: 10px;
    padding: 5px;
  }

  .fab-menu li {
    padding: 10px;
    cursor: pointer;
  }

  .fab-menu li:hover {
    background-color: #f0f0f0;
  }

  .hidden {
    display: none;
  }
</style>

<div class="fab-container">
  <div id="fab" class="fab">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
      class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
      <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
    </svg>
  </div>
  <!-- Menu items -->
  <ul id="fab-menu" class="fab-menu hidden">
    <li onclick="openWhatsApp('#')">Admin Tahsin</li>
    <li onclick="openWhatsApp('#')">Admin Bahasa Arab</li>
    <li onclick="openWhatsApp('#')">Admin Lughoh</li>
    <li onclick="openWhatsApp('#')">Admin Bilhaq</li>
    <li onclick="openWhatsApp('#')">Admin Tahfiz</li>
    <li onclick="openWhatsApp('#')">Admin S1 FAI</li>
    <li onclick="openWhatsApp('#')">Admin S1 STEBIS</li>
    <!-- Add more numbers as needed -->
  </ul>
</div>

<script>
  document.getElementById('fab').addEventListener('click', function() {
    document.getElementById('fab-menu').classList.toggle('hidden');
  });

  function openWhatsApp(number) {
    window.open(`https://wa.me/${number}`, '_blank');
  }
</script>
