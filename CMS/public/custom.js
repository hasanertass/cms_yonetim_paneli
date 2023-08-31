document.addEventListener("DOMContentLoaded", function () {
    // Sayfa yüklendiğinde, aktif sayfanın URL'sini al
    var currentPageURL = window.location.href;
    // Sidebar linklerini seç
    var sidebarLinks = document.querySelectorAll('.navbar-nav .nav-link');
    // Her sidebar linkini kontrol et
    sidebarLinks.forEach(function (link) {
        // Linkin href özelliğini al
        var linkURL = link.getAttribute('href');

        // Sayfanın URL'sinde linkURL içeriyorsa veya tam tersi, yani linkURL sayfanın URL'sinde geçiyorsa
        if (currentPageURL.includes(linkURL) || linkURL.includes(currentPageURL)) {
            link.classList.add('active');
        }
    });
    // Sidebar linklerine tıklandığında aktif sayfayı güncelle
    sidebarLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            // Tüm sidebar linklerinden active sınıfını kaldır
            sidebarLinks.forEach(function (link) {
                link.classList.remove('active');
            });

            // Tıklanan link için active sınıfını ekle
            link.classList.add('active');
        });
    });
});
