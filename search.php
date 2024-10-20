<?php
    require_once "misc/header.php";

    require_once "misc/tools.php";
    require_once "misc/search_engine.php";

    $opts = load_opts();

    $time_options = [
        'a' => 'Any time', 
        'h' => 'Past day', 
        'w' => 'Past week', 
        'm' => 'Past month', 
        'y' => 'Past year'
    ];
    $selected_time_option = isset($_REQUEST['time_period']) ? $_REQUEST['time_period'] : 'a';
    
    function print_page_buttons($type, $query, $page) {
        if ($type > 1)
            return;
        echo "<div class=\"next-page-button-wrapper\">";

            //if ($page != 0) {
                //print_next_page_button("&lt;&lt;", 0, $query, $type);
            //    print_next_page_button($page, "Previous", $page - 10, $query, $type);
            //}

            //for ($i = $page / 10; $page / 10 + 10 > $i; $i++)
            for ($i = 0; $i < 10; $i++) {
                print_next_page_button($page, $i + 1, $i * 10, $query, $type);
            }

            //print_next_page_button($page, "Next", $page + 10, $query, $type);

        echo "</div>";
    }
?>

<title>
<?php
    echo $opts->query;
    ?> - <?php printtext("page_title");?></title>
</head>
    <body>
        <form id="searchForm" class="sub-search-container" method="get" autocomplete="off">
            <h1 class="logomobile">
                <a class="no-decoration" href="./">
                <div id="container">
                    <div id="logo">
                        <div class="g-line"></div>
                        <span class="red"></span>
                        <span class="yellow"></span>
                        <span class="green"></span>
                        <span class="blue"></span>
                    </div>
                </div>
                </a>
            </h1>
            <input type="text" name="q" id="search" 
                <?php
                    if (1 > strlen($opts->query) || strlen($opts->query) > 256)
                    {
                        header("Location: ./");
                        die();
                    }

                    echo "value=\"" . htmlspecialchars($opts->query) . "\"";
                ?>
            >
            <div id="results" style="display: none;"></div>
            <hr>
            <?php
                echo "<button class=\"hide\" name=\"t\" value=\"$opts->type\"/></button>";
            ?>
            <button type="submit" class="hide"></button>
            <input type="hidden" name="p" value="0">
            <div class="sub-search-button-wrapper">
                <?php
                    $categories = array("general", "images", "videos");

                    foreach ($categories as $category)
                    {
                        $category_index = array_search($category, $categories);

                        if (($opts->disable_bittorrent_search && $category_index == 3) ||
                            ($opts->disable_hidden_service_search && $category_index ==4))
                        {
                            continue;
                        }

                        echo "<a " . (($category_index == $opts->type) ? "class=\"active\" " : "") . "href=\"./search.php?q=" . urlencode($opts->query) . "&p=0&t=" . $category_index . "\"><img src=\"static/images/" . $category . "_result.png\" alt=\"" . $category . " result\" />" . TEXTS["category_$category"]  . "</a>";
                    }
                ?>
                <select class="dropdown" name="time_period" id="time_period">
                <?php 
                    foreach ($time_options as $time_option_id => $time_option_name) {
                        $selected = $selected_time_option == $time_option_id ? 'selected' : '';
                        echo "<option value=\"$time_option_id\" $selected>$time_option_name</option>";  
                    }
                ?>
                </select>
            </div>
        </form>
        
        <script>
        document.getElementById('time_period').addEventListener('change', function() {
            document.getElementById('searchForm').submit();
        });
        
        $(document).ready(function() {
            $('#search').on('focus', search());
            $('#search').on('input', search());
            $('#search').on('blur', function() {
               $('#results').hide();
            });
        });

        function search() {
            var query = $(this).val();

            if (query.length > 0) {
                $('#clear').show();
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
        }
        </script>

        <?php
            fetch_search_results($opts, true);
            print_page_buttons($opts->type, $opts->query, $opts->page);
        ?>

<?php require_once "misc/footer.php"; ?>
