<?php require_once "misc/header.php"; ?>

    <title>Private Google Search</title>
    </style>
    </head>
    <body>
        <form class="search-container" action="search.php" method="get" autocomplete="off">
                <h1>
                    <span class="google-logo" style="color: '#4285F4';">G</span>
                    <span style="color: #EA4335;">o</span>
                    <span style="color: #FBBC05;">o</span>
                    <span style="color: #4285F4;">g</span>
                    <span style="color: #34A853;">l</span>
                    <span style="color: #EA4335;">e</span>
                </h1>
                <input type="text" name="q" autofocus/>
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

<?php require_once "misc/footer.php"; ?>
