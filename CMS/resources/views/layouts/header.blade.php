<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('front/') }}/assets/img/apple-icon.png">
    @if($gecerliLogo)
        <link hight rel="icon" type="image/png" class="rounded-circle" href="{{ asset($gecerliLogo->FilePath) }}">
    @endif
    <title>
        Content Management System
    </title>

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('front/') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('front/') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <script src="{{ asset('custom.js') }}"></script>

    <link href="{{ asset('front/') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('front/') }}/assets/css/argon-dashboard.css?v=2.0.4"
        rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar-nav .nav-item:hover .nav-link,
        .navbar-nav .nav-item.active .nav-link,
        .navbar-nav .nav-submenu:hover .nav-link {
            background-color: #f7f7f8;
            /* Arka plan rengi */
            color: #333;
            /* Yazı rengi */
        }

        .navbar-nav .nav-submenu .nav-item:hover .nav-link {
            background-color: #f7f7f8;
            /* Arka plan rengi */
            color: #333;
            /* Yazı rengi */
        }

        .nav-submenu-submenu ul.nav .nav-item:hover {
            background-color: #f7f7f8;
            /* İstediğiniz arkaplan rengini burada belirtin */
        }

        .nav-submenu ul.nav .nav-item:hover .nav-link {
            background-color: #f5f5f5;
            /* Arka plan rengi */
            color: #333;
            /* Yazı rengi */
        }

        .nav-submenu-submenu ul.nav .nav-item:hover .nav-link {
            background-color: #f5f5f5;
            /* Alt menü öğelerinin arka plan rengi */
            color: #333;
            /* Alt menü öğelerinin yazı rengi */
        }

        /* Üst Menü Öğesinin Üzerine Gelindiğinde */
        .navbar-nav .nav-item:hover>.nav-link[data-bs-toggle="collapse"] {
            background-color: transparent;
            /* Üst menü öğesinin arka plan rengini sıfırla */
            color: inherit;
            /* Üst menü öğesinin yazı rengini sıfırla */
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.tiny.cloud/1/bf3fycalmdmwya4mg3521f3d8swj38861kw57l2my4ffz11f/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('front/') }}/langs/tr.js">
    </script>
    <script>
        // TinyMCE'yi etkinleştirin
        tinymce.init({
            selector: '#content',
            content_css: [
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css',
                'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css',
                '{{ asset('drivin-1.0.0/') }}/lib/animate/animate.min.css',
                '{{ asset('drivin-1.0.0/') }}/lib/owlcarousel/assets/owl.carousel.min.css',
                '{{ asset('drivin-1.0.0/') }}/css/bootstrap.min.css',
                '{{ asset('drivin-1.0.0/') }}/css/style.css',
            ],
            setup: function (editor) {
                //
                // Özel menü düğmesini menü çubuğuna ekleyin

                editor.ui.registry.addMenuButton('placeholders', {
                    text: 'Yer Tutucular',
                    fetch: function (callback) {
                        console.log('Yer Tutucu');
                        var items = [{
                                type: 'menuitem',
                                text: 'Şirket Adı',
                                onAction: function () {
                                    editor.insertContent('[sirket_adi]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Telefon Numarası 1',
                                onAction: function () {
                                    editor.insertContent('[telefon]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Telefon Numarası 2',
                                onAction: function () {
                                    editor.insertContent('[telefon2]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Mail',
                                onAction: function () {
                                    editor.insertContent('[mail]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Mail 2',
                                onAction: function () {
                                    editor.insertContent('[mail2]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Adres',
                                onAction: function () {
                                    editor.insertContent('[adres]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Adres 2',
                                onAction: function () {
                                    editor.insertContent('[adres2]');
                                }
                            },

                            // Diğer yer tutucularını buraya ekleyin
                        ];
                        callback(items);
                    }
                });
            },
            valid_elements: '*[*]', // Tüm HTML etiketlerini kabul et
            language: 'tr',
            plugins: ' link lists image code media table emoticons advlist autolink hr paste searchreplace wordcount imagetools',
            toolbar: 'undo redo | styleselect placeholders contentholder| bold italic underline |  numlist bullist checklist | forecolor backcolor casechange | fontselect fontsizeselect| alignleft aligncenter alignright | bullist numlist | link image | code ',
            menubar: 'file edit view insert format table tools',
            contextmenu: 'link image imagetools table ',
            image_caption: true,
            cleanup: false,
            image_advtab: true,
            file_picker_types: 'image',
            automatic_uploads: true,
            images_upload_url: '{{ route('upload.image') }}',
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('upload.image') }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.onload = function () {
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            }

        });
    </script>
    
</script>
</head>
