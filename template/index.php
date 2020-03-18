<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $config['title']; ?></title>
    <style>
        body {
            padding: 2px;
            margin: 0;
        }
        .container {
            max-width: 1024px;
            margin: 0 auto;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            position: relative;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .grid li {
            position: relative;
            height: 40vh;
            flex-grow: 1;
            outline: 2px solid #fff;
        }
        .grid img {
            display: block;
            width: auto;
            max-height: 100%;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
        }
        .grid .open {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            width: 100%;
            height: 100vh;
            background: #fff;
        }
        .grid .open a {
            cursor: default;
        }
        .grid .open img {
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container">
        <ul class="grid">
            <?php
            $photos = glob(PUBLIC_DIR . '/photos/thumbs/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($photos as $idx => $photo) {
                $src = str_replace(PUBLIC_DIR, '', $photo);
                $alt = pathinfo($photo, PATHINFO_FILENAME);
                $id = slugify($alt);
                $link = str_replace('/photos/thumbs', '/photos/large', $src);
                $srcProp = $idx > 20 ? 'data-src' : 'src';
                list($width, $height) = getimagesize($photo);
                ?>
                <li id="<?php echo $id; ?>">
                    <a href="<?php echo $link; ?>" data-target="<?php echo $id; ?>" target="_blank">
                        <img <?php echo $srcProp; ?>="<?php echo $src; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="lazyload">
                    </a>
                </li>
                <?php
            }

            function slugify($text) {
                $text = preg_replace('/[^a-z0-9-_]+/', '-', strtolower($text));
                $text = preg_replace('/-{2,}/', '-', $text);
                return $text;
            }
            ?>
        </ul>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script>
        $(function() {
            $('body').on('click', 'a[data-target]', function(e) {
                e.preventDefault();

                const id = $(this).data('target');
                const href = $(this).attr('href');

                if ($(`#${id}`).hasClass('open')) {
                    closePhoto('/');
                } else {
                    openPhoto(id, href);
                }
            });

            window.onpopstate = function(event) {
                if (event.state && event.state.id) {
                    const id = event.state.id;
                    openPhoto(id);
                } else {
                    closePhoto();
                }
            }

            function openPhoto(id, href = null) {
                $(`#${id}`).addClass('open');
                if (href) {
                    window.history.pushState({id: id}, '', href);
                }
            }

            function closePhoto(href = null) {
                $(`.grid .open`).removeClass('open');
                if (href) {
                    window.history.pushState({}, '', href);
                }
            }
        });

        lazyload();
    </script>
</body>
</html>

