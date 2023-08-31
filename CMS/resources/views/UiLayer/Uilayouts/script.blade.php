<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('drivin-1.0.0/') }}/lib/wow/wow.min.js"></script>
<script src="{{ asset('drivin-1.0.0/') }}/lib/easing/easing.min.js"></script>
<script src="{{ asset('drivin-1.0.0/') }}/lib/waypoints/waypoints.min.js"></script>
<script src="{{ asset('drivin-1.0.0/') }}/lib/owlcarousel/owl.carousel.min.js"></script>
<!-- Template Javascript -->
<script src="{{ asset('drivin-1.0.0/') }}/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    });
    $(document).ready(function () {
        $('.customer-news').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 4500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    });
    /* Demo purposes only */
    $(".hover").mouseleave(
        function () {
            $(this).removeClass("hover");
        }
    );

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aboutImage = document.getElementById('about-image');
        const aboutDescription = document.querySelector('.about h3').textContent +
                                  document.querySelector('.about p:first-of-type').textContent +
                                  document.querySelector('.about p:last-of-type').textContent +
                                  document.querySelector('.about h4').textContent;

        const fontSizeMultiplier = aboutDescription.length / 100; // Ölçeklendirme faktörü

        aboutImage.style.width = `${100 + fontSizeMultiplier * 20}%`; // Orantılı olarak genişlik ayarı
        aboutImage.style.height = `${100 + fontSizeMultiplier * 20}%`;
    });
</script>
<script>
    const accordionItemHeaders = document.querySelectorAll(
        ".accordion-item-header"
    );

    accordionItemHeaders.forEach((accordionItemHeader) => {
        accordionItemHeader.addEventListener("click", (event) => {
            // Uncomment in case you only want to allow for the display of only one collapsed item at a time!

            const currentlyActiveAccordionItemHeader = document.querySelector(
                ".accordion-item-header.active"
            );
            if (
                currentlyActiveAccordionItemHeader &&
                currentlyActiveAccordionItemHeader !== accordionItemHeader
            ) {
                currentlyActiveAccordionItemHeader.classList.toggle("active");
                currentlyActiveAccordionItemHeader.nextElementSibling.style.maxHeight = 0;
            }
            accordionItemHeader.classList.toggle("active");
            const accordionItemBody = accordionItemHeader.nextElementSibling;
            if (accordionItemHeader.classList.contains("active")) {
                accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
            } else {
                accordionItemBody.style.maxHeight = 0;
            }
        });
    });

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
    integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
