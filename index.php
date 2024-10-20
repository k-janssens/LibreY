<?php require_once "misc/header.php"; ?>

    <title>Private Google Search</title>
    </style>
    </head>
    <body>
        <form class="search-container" action="search.php" method="get" autocomplete="off">
                <h1 id="google_logo">
                    <span class="google-logo-g1">G</span><span class="google-logo-o1">o</span><span class="google-logo-o2">o</span><span class="google-logo-g2">g</span><span class="google-logo-l">l</span><span class="google-logo-e">e</span>
                </h1>
                <!--img src="/static/images/search.png" class="icon"-->
                <i class="material-icons" id="clear">highlight_off</i>
                <input type="text" name="q" id="search" autofocus />
                <input type="hidden" name="p" value="0"/>
                <input type="hidden" name="t" value="0"/>
                <input type="submit" class="hide"/>
                <div class="search-button-wrapper">
                <!-- button name="t" value="0" type="submit"><?php printtext("search_button"); ?></button -->
                <?php if (!$opts->disable_bittorrent_search) {
                    echo '<button name="t" value="3" type="submit">', printtext("torrent_search_button"), '</button>';
                } ?>
                </div>
        </form>

        <div id="results" style="display: none;"></div>

        <script>
        $(document).ready(function() {
            $('#clear').on('click', function() {
                $('#search').val('');
                $('#results').hide();
                $('#search').focus();
            });

            $('#search').on('input', function() {
                var query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: 'autocomplete.php', // The URL to the PHP file that processes the search
                        type: 'GET',
                        data: { query: query },
                        success: function(data) {
                            $('#results').html(data).show(); // Populate results and show the div
                        },
                        error: function() {
                            $('#results').html('<p>Error retrieving results.</p>').show();
                        }
                    });
                } else {
                    $('#results').hide(); // Hide results if the input is empty
                }
            });
        });
        </script>

<?php require_once "misc/footer.php"; ?>
